<?php
class Order
{
    public static function createFromCart(array $user, array $items): array
    {
        $threshold = (int) setting('free_delivery_threshold', '20000');
        $fee = (int) setting('delivery_fee', '1000');
        $freeCity = setting('free_delivery_city', 'Yaoundé');

        $lines = [];
        $subtotal = 0;
        foreach ($items as $productId => $qty) {
            $qty = (int) $qty;
            $productId = (int) $productId;
            if ($qty < 1 || $productId < 1) {
                continue;
            }
            $p = Product::find($productId);
            if (!$p || !in_array($p['status'], ['live', 'sold_out'], true)) {
                continue;
            }
            if ((int) $p['stock'] < $qty) {
                throw new RuntimeException($p['name'] . ' does not have enough stock.');
            }
            $lines[] = ['product' => $p, 'qty' => $qty];
            $subtotal += (int) $p['price_xaf'] * $qty;
        }
        if (!$lines) {
            throw new RuntimeException('Your cart is empty.');
        }

        $city = $user['city'] ?? TF_CITY;
        $delivery = ($subtotal >= $threshold && strcasecmp((string) $city, $freeCity) === 0) ? 0 : $fee;
        $total = $subtotal + $delivery;

        $pdo = Database::pdo();
        $pdo->beginTransaction();
        try {
            $publicId = 'TF-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
            Database::run(
                'INSERT INTO orders (public_id, user_id, total_xaf, delivery_xaf, status, city, address, payment)
                 VALUES (?,?,?,?,?,?,?,?)',
                [
                    $publicId,
                    $user['uid'],
                    $total,
                    $delivery,
                    'paid',
                    $city,
                    $user['address'] ?? '',
                    $user['payment'] ?? 'Mobile money',
                ]
            );
            $orderId = Database::lastId();
            foreach ($lines as $line) {
                $p = $line['product'];
                Database::run(
                    'INSERT INTO order_items (order_id, product_id, vendor_id, name_snapshot, qty, unit_xaf)
                     VALUES (?,?,?,?,?,?)',
                    [$orderId, $p['id'], $p['vendor_id'], $p['name'], $line['qty'], $p['price_xaf']]
                );
                Database::run(
                    'UPDATE products SET stock = stock - ? WHERE id = ? AND stock >= ?',
                    [$line['qty'], $p['id'], $line['qty']]
                );
                Database::run(
                    "UPDATE products SET status = 'sold_out' WHERE id = ? AND stock <= 0",
                    [$p['id']]
                );
            }
            $pdo->commit();
        } catch (Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }

        return ['id' => $orderId, 'public_id' => $publicId, 'total' => $total];
    }

    public static function forCustomer(int $userId): array
    {
        if (!TF_DB_OK) {
            return [];
        }
        $orders = Database::fetchAll(
            'SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC',
            [$userId]
        );
        foreach ($orders as &$o) {
            $o['items'] = Database::fetchAll(
                'SELECT * FROM order_items WHERE order_id = ?',
                [$o['id']]
            );
            $names = array_map(static fn($i) => $i['name_snapshot'] . ((int) $i['qty'] > 1 ? ' × ' . $i['qty'] : ''), $o['items']);
            $o['item'] = implode(', ', $names);
            $o['amount'] = (int) $o['total_xaf'];
            $o['date'] = date('j M Y', strtotime($o['created_at']));
            $o['tone'] = tf_status_ok($o['status']) ? 'ok' : 'warn';
            $o['id'] = $o['public_id'];
        }
        unset($o);
        return $orders;
    }

    public static function forVendor(int $vendorId): array
    {
        if (!TF_DB_OK) {
            return [];
        }
        $rows = Database::fetchAll(
            "SELECT o.*, u.name AS buyer,
                    GROUP_CONCAT(CONCAT(oi.name_snapshot, IF(oi.qty>1, CONCAT(' × ', oi.qty), '')) SEPARATOR ', ') AS item,
                    SUM(oi.qty * oi.unit_xaf) AS vendor_amount
               FROM orders o
               JOIN order_items oi ON oi.order_id = o.id
               JOIN users u ON u.id = o.user_id
              WHERE oi.vendor_id = ?
              GROUP BY o.id
              ORDER BY o.created_at DESC",
            [$vendorId]
        );
        foreach ($rows as &$r) {
            $r['amount'] = (int) ($r['vendor_amount'] ?? $r['total_xaf']);
            $r['tone'] = tf_status_ok($r['status']) ? 'ok' : 'warn';
        }
        unset($r);
        return $rows;
    }

    public static function pendingCountForVendor(int $vendorId): int
    {
        $row = Database::fetch(
            "SELECT COUNT(DISTINCT o.id) AS c
               FROM orders o
               JOIN order_items oi ON oi.order_id = o.id
              WHERE oi.vendor_id = ? AND o.status IN ('paid','packing','in_delivery')",
            [$vendorId]
        );
        return (int) ($row['c'] ?? 0);
    }

    public static function salesForVendor(int $vendorId): int
    {
        $row = Database::fetch(
            "SELECT COALESCE(SUM(oi.qty * oi.unit_xaf),0) AS s
               FROM order_items oi
               JOIN orders o ON o.id = oi.order_id
              WHERE oi.vendor_id = ? AND o.status NOT IN ('cancelled')",
            [$vendorId]
        );
        return (int) ($row['s'] ?? 0);
    }

    public static function setStatus(int $orderId, string $status, ?int $vendorId = null): void
    {
        $allowed = ['pending', 'paid', 'packing', 'in_delivery', 'delivered', 'completed', 'cancelled'];
        if (!in_array($status, $allowed, true)) {
            return;
        }
        if ($vendorId) {
            $ok = Database::fetch(
                'SELECT o.id FROM orders o JOIN order_items oi ON oi.order_id = o.id WHERE o.id = ? AND oi.vendor_id = ? LIMIT 1',
                [$orderId, $vendorId]
            );
            if (!$ok) {
                return;
            }
        }
        Database::run('UPDATE orders SET status = ? WHERE id = ?', [$status, $orderId]);
    }

    public static function count(): int
    {
        if (!TF_DB_OK) {
            return 0;
        }
        $row = Database::fetch('SELECT COUNT(*) AS c FROM orders');
        return (int) ($row['c'] ?? 0);
    }

    public static function revenue(): int
    {
        if (!TF_DB_OK) {
            return 0;
        }
        $row = Database::fetch("SELECT COALESCE(SUM(total_xaf),0) AS s FROM orders WHERE status NOT IN ('cancelled')");
        return (int) ($row['s'] ?? 0);
    }

    public static function countForUser(int $userId): int
    {
        $row = Database::fetch('SELECT COUNT(*) AS c FROM orders WHERE user_id = ?', [$userId]);
        return (int) ($row['c'] ?? 0);
    }
}

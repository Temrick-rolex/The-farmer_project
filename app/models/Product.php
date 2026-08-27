<?php
class Product
{
    public static function allLive(): array
    {
        if (!TF_DB_OK) {
            return [];
        }
        return Database::fetchAll(
            "SELECT * FROM products WHERE status IN ('live','sold_out') ORDER BY is_featured DESC, id ASC"
        );
    }

    public static function featured(int $limit = 4): array
    {
        if (!TF_DB_OK) {
            return [];
        }
        return Database::fetchAll(
            "SELECT * FROM products WHERE status = 'live' AND is_featured = 1 ORDER BY id ASC LIMIT " . (int) $limit
        );
    }

    public static function find(int $id): ?array
    {
        if (!TF_DB_OK) {
            return null;
        }
        return Database::fetch('SELECT * FROM products WHERE id = ? LIMIT 1', [$id]);
    }

    public static function forVendor(int $vendorId): array
    {
        if (!TF_DB_OK) {
            return [];
        }
        return Database::fetchAll(
            'SELECT * FROM products WHERE vendor_id = ? ORDER BY created_at DESC',
            [$vendorId]
        );
    }

    public static function pendingApproval(): array
    {
        if (!TF_DB_OK) {
            return [];
        }
        return Database::fetchAll(
            "SELECT p.*, u.name AS vendor_name
               FROM products p
               JOIN users u ON u.id = p.vendor_id
              WHERE p.status = 'pending'
              ORDER BY p.created_at DESC"
        );
    }

    public static function catalogForJs(): array
    {
        $out = [];
        foreach (self::allLive() as $p) {
            $out[(string) $p['id']] = [
                'name'  => $p['name'],
                'price' => (int) $p['price_xaf'],
                'img'   => asset((string) $p['image_path']),
                'stock' => (int) $p['stock'],
                'sku'   => $p['sku'],
            ];
        }
        return $out;
    }

    public static function create(array $data): int
    {
        $slug = tf_slug((string) $data['name']);
        $base = $slug;
        $i = 2;
        while (Database::fetch('SELECT id FROM products WHERE slug = ?', [$slug])) {
            $slug = $base . '-' . $i++;
        }
        $sku = 'p' . bin2hex(random_bytes(3));
        Database::run(
            'INSERT INTO products (vendor_id, sku, name, slug, category, description, price_xaf, stock, status, image_path)
             VALUES (?,?,?,?,?,?,?,?,?,?)',
            [
                $data['vendor_id'],
                $sku,
                $data['name'],
                $slug,
                $data['category'],
                $data['description'] ?? '',
                (int) $data['price_xaf'],
                (int) $data['stock'],
                'pending',
                $data['image_path'] ?? 'Image/farm5.jpg',
            ]
        );
        return Database::lastId();
    }

    public static function update(int $id, int $vendorId, array $data): void
    {
        Database::run(
            'UPDATE products SET name = ?, category = ?, description = ?, price_xaf = ?, stock = ?
              WHERE id = ? AND vendor_id = ?',
            [
                $data['name'],
                $data['category'],
                $data['description'] ?? '',
                (int) $data['price_xaf'],
                (int) $data['stock'],
                $id,
                $vendorId,
            ]
        );
        $row = self::find($id);
        if ($row && (int) $row['stock'] <= 0 && $row['status'] === 'live') {
            Database::run("UPDATE products SET status = 'sold_out' WHERE id = ?", [$id]);
        }
        if ($row && (int) $row['stock'] > 0 && $row['status'] === 'sold_out') {
            Database::run("UPDATE products SET status = 'live' WHERE id = ?", [$id]);
        }
    }

    public static function delete(int $id, int $vendorId): void
    {
        Database::run('DELETE FROM products WHERE id = ? AND vendor_id = ? AND status IN (\'pending\',\'rejected\')', [$id, $vendorId]);
    }

    public static function setStatus(int $id, string $status): void
    {
        if (!in_array($status, ['pending', 'live', 'rejected', 'sold_out'], true)) {
            return;
        }
        Database::run('UPDATE products SET status = ? WHERE id = ?', [$status, $id]);
    }

    public static function countForVendor(int $vendorId): int
    {
        $row = Database::fetch('SELECT COUNT(*) AS c FROM products WHERE vendor_id = ?', [$vendorId]);
        return (int) ($row['c'] ?? 0);
    }
}

<?php
/**
 * Product model — citrus trees, fresh fruit, juice, experiences.
 * Prices are stored as integer XAF (no floating point).
 */
class Product
{
    public static function allLive(): array
    {
        // TODO: SELECT * FROM products WHERE status = 'live' ORDER BY created_at DESC
        return [];
    }

    public static function forVendor(int $vendorId): array
    {
        // TODO: SELECT * FROM products WHERE vendor_id = ?
        return [];
    }

    public static function pendingApproval(): array
    {
        // TODO: SELECT * FROM products WHERE status = 'pending'
        return [];
    }
}

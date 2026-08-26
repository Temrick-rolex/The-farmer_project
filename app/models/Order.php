<?php
/**
 * Order model — customer purchases and farmer fulfilment.
 */
class Order
{
    public static function forCustomer(int $userId): array
    {
        return [];
    }

    public static function forVendor(int $vendorId): array
    {
        return [];
    }
}

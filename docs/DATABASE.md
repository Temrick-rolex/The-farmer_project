# Database

## Import

```bash
mysql -u root -p < database/the_farmer.sql
```

Or phpMyAdmin → Import → `database/the_farmer.sql`.

Copy `.env.example` to `.env`. Defaults: database `the_farmer`, user `root`, empty password, host `127.0.0.1`.

`database/schema.sql` is a pointer file. The real schema **and** seed live in `the_farmer.sql`.

## Engine

- MySQL / MariaDB, `utf8mb4` / `utf8mb4_unicode_ci`
- InnoDB, foreign keys on
- Time zone in the dump: `+01:00` (WAT)

## Tables

| Table | Purpose |
| --- | --- |
| `users` | Accounts. `password_hash` only. `role` ENUM customer/farmer/admin. `wallet_xaf` integer. |
| `products` | Listings. `price_xaf` unsigned int. `status` pending/live/rejected/sold_out. |
| `orders` | Header: totals, delivery, city, payment, status. |
| `order_items` | Line: product, vendor, name snapshot, qty, unit XAF. |
| `opportunities` | Programs. |
| `opportunity_applications` | Unique (user, program). |
| `messages` | Support threads. |
| `newsletter_subscribers` | Unique email. |
| `ratings` | Unique user, stars 1–5. |
| `platform_settings` | Key/value (delivery, support). |

Passwords are **never** selected for display. `User::present()` maps a row to the view model (`uid`, public `id`, no hash).

## Seed logins

All hashes are bcrypt of `Farmer2026!`.

| id | email | role |
| --- | --- | --- |
| 1 | john@thefarmer.cm | customer |
| 2 | bella@thefarmer.cm | customer |
| 3 | jean@thefarmer.cm | farmer |
| 4 | aminata@thefarmer.cm | customer |
| 5 | patrick@thefarmer.cm | farmer |
| 6 | ngono@thefarmer.cm | admin |
| 7 | mballa@thefarmer.cm | farmer |

John’s five orders, Bella’s TF-1048, vendor items for Jean (3) and Patrick (5), pending listings 13–15, and a handful of messages/applications match those accounts so dashboards are seed-accurate.

## Connection

`app/config/database.php`:

- PDO, `ERRMODE_EXCEPTION`
- `ATTR_EMULATE_PREPARES = false` (native prepares)
- `MYSQL_ATTR_MULTI_STATEMENTS = false` when the constant exists
- DSN charset `utf8mb4`

If MySQL is down, pages still render (empty lists) and `process.php` returns 503 / a flash error instead of leaking a stack trace.

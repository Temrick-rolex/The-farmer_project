# The Farmer

Farm-direct citrus from Yaoundé, Cameroon — shop, partnerships, mentorship and jobs.

The storefront is a PHP + MySQL app with a shared header/footer and three role-based dashboards (customer, farmer, admin). Profile and Settings live **inside the dashboard**, not in the public navbar.

**Blueprint:** see [ARCHITECTURE.md](ARCHITECTURE.md).

## Database

Import the full schema and demo seed:

```bash
mysql -u root -p < database/the_farmer.sql
```

Or use phpMyAdmin → Import → `database/the_farmer.sql`.

Copy `.env.example` to `.env` (XAMPP/WAMP defaults: database `the_farmer`, user `root`, empty password).

Demo password for every seeded account: **`Farmer2026!`**

| Email | Role |
| --- | --- |
| john@thefarmer.cm | Customer |
| bella@thefarmer.cm | Customer |
| aminata@thefarmer.cm | Customer |
| jean@thefarmer.cm | Farmer / vendor |
| patrick@thefarmer.cm | Farmer / vendor |
| mballa@thefarmer.cm | Farmer / vendor |
| ngono@thefarmer.cm | Administrator |

Prices are **integer XAF**. Passwords are stored with `password_hash()` — never plaintext.

## Run locally

```bash
php -S 0.0.0.0:8080
```

If PHP is not installed, the Node preview server renders templates only (no MySQL):

```bash
node tools/dev-server.js
```

Then open `/index.php` (shop) or log in at `/regform.php`. Forms POST to `process.php`. Asset paths use forward slashes via `asset()`.

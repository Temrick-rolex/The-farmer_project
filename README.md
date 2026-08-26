# The Farmer

Farm-direct citrus from Yaoundé, Cameroon — shop, partnerships, mentorship and jobs.

The storefront is a PHP app with a shared header/footer and three role-based dashboards (customer, farmer, admin). Profile and Settings live **inside the dashboard**, not in the public navbar.

**Blueprint:** see [ARCHITECTURE.md](ARCHITECTURE.md) for the file tree, navigation split, dashboard UI specs and refactoring rules.

## Run locally

```bash
php -S 0.0.0.0:8080
```

If PHP is not installed:

```bash
node tools/dev-server.js
```

Then open `/index.php` (shop) or `/dashboard/user/index.php` (customer workspace).

Prices are in **XAF**. Asset paths use forward slashes via `asset()`. Forms POST to `process.php`.

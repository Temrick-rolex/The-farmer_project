# The Farmer

Farm-direct citrus from **Yaoundé, Cameroon** — a shop, a grower network, and three role-based workspaces (customer, farmer, administrator).

The storefront sells mature fruit trees, fresh produce, juice and farm experiences in **integer XAF**. Profile and Settings live **inside the dashboard**, not in the public navbar.

## Documentation

Start here, then read the set in `docs/` for the whole product:

| Document | What it covers |
| --- | --- |
| [docs/README.md](docs/README.md) | Map of every markdown file |
| [docs/OVERVIEW.md](docs/OVERVIEW.md) | Product, audience, roles, money |
| [docs/FEATURES.md](docs/FEATURES.md) | Every public page and dashboard screen |
| [docs/USER-GUIDE.md](docs/USER-GUIDE.md) | How to shop, sell, and administer |
| [docs/ARCHITECTURE.md](docs/ARCHITECTURE.md) | Folders, includes, request flow |
| [docs/DATABASE.md](docs/DATABASE.md) | Schema, seed, import |
| [docs/SECURITY.md](docs/SECURITY.md) | Auth, CSRF, XSS, headers, hardening |
| [docs/DEVELOPMENT.md](docs/DEVELOPMENT.md) | Run locally, preview, conventions |
| [ARCHITECTURE.md](ARCHITECTURE.md) | Original UI/UX blueprint (dashboards) |

## Quick start

```bash
cp .env.example .env          # edit DB_* if needed
mysql -u root -p < database/the_farmer.sql
php -S 0.0.0.0:8080
```

Open `/index.php`. Log in at `/regform.php`.

If PHP is not installed, the Node preview renders templates (no MySQL persistence):

```bash
node tools/dev-server.js
```

## Demo accounts

Password for every seeded account: **`Farmer2026!`**

| Email | Role |
| --- | --- |
| john@thefarmer.cm | Customer |
| bella@thefarmer.cm | Customer |
| aminata@thefarmer.cm | Customer |
| jean@thefarmer.cm | Farmer / vendor |
| patrick@thefarmer.cm | Farmer / vendor |
| mballa@thefarmer.cm | Farmer / vendor |
| ngono@thefarmer.cm | Administrator |

Passwords are stored with `password_hash()` — never plaintext. Role always comes from the **account**, never from a form picker at login.

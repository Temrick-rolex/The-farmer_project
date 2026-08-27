# User guide

## Create an account

1. Open **Register** (`/regform.php`).
2. Choose **Customer** or **Farmer / vendor**. You cannot register as admin.
3. Use a real email and a password of **at least 8 characters**.
4. You land in the matching dashboard.

## Log in

1. Open the **Log in** tab.
2. Enter name, email, or public ID, plus password.
3. Your workspace follows the role **saved on the account**.
4. After several failed attempts the form locks for 15 minutes.

Demo password (seeded accounts only): `Farmer2026!`

## Shop and checkout

1. Add items from **Products**. The cart lives in this browser (`localStorage`).
2. Checkout requires a session. Guests are sent to log in.
3. Stock and live status are checked on the server. Sold-out juice cannot be bought.
4. Delivery: **0 XAF** in Yaoundé when the basket is at least the free-delivery threshold; otherwise the delivery fee (defaults 20,000 / 1,000 XAF).
5. The order appears under **My orders**. Support may write in **Messages**.

## Profile

1. Open **User management → Profile**.
2. Fields start locked. Click **Update profile** to edit.
3. **Save changes** posts to the server. **Cancel** restores the previous values.
4. Passwords are never shown. Change them under Settings.

## Farmer listings

1. **Add product** — name, category, price (≥ 100 XAF), stock. Status starts as `pending`.
2. An admin **Approves** (shop goes live) or **Rejects**.
3. **Orders to fulfil** lists buyers of *your* items. Update packing / in delivery / delivered.

## Admin

1. **Product approval** — publish or reject; the vendor is messaged.
2. **Users** — suspend or restore (not your own row).
3. **Opportunity moderation** — publish or close programs.
4. **System settings** — delivery numbers and support contacts.

## Theme and language

Theme can be toggled from any page (stored in `localStorage` and, when you save Settings, on the account). Language and display currency are account preferences; settlement stays XAF.

# Product overview

**The Farmer** is a farm-direct e-commerce and community platform. It sells citrus grown around **Yaoundé (Simbock / Mendong)** and neighbouring cities, and it hosts programs for partners, mentees and job seekers.

## Who it is for

- **Families** who want trees, fruit baskets, juice or a harvest visit.
- **Growers / vendors** who list harvest items for admin review, then fulfil orders.
- **Staff (admin)** who approve listings, moderate programs and manage accounts.

## What you can do

1. Browse the public shop and add items to a cart.
2. Create an account (customer or farmer — never self-serve admin).
3. Check out in **whole XAF** (cash, mobile money, Visa, bank card as a preference).
4. Track orders, messages and saved programs in a dashboard.
5. Farmers list products; admins publish them.
6. Anyone logged in can apply to live opportunity programs.

## Roles

| Role | Workspace | Can do |
| --- | --- | --- |
| `customer` | `dashboard/user/` | Shop, orders, programs, messages, profile |
| `farmer` | `dashboard/farmer/` | Inventory, add/edit pending listings, fulfil sales |
| `admin` | `dashboard/admin/` | Users, product approval, program moderation, system settings |

Role is a column on `users`. Login does **not** accept a role field. Register may choose `customer` or `farmer` only.

## Money

- Settlement currency is **XAF** (integer francs, no decimals).
- `money()` formats `12,400 XAF`.
- Settings may *display* USDT or € later; the database always stores XAF.
- Free delivery in Yaoundé above a threshold (default **20,000 XAF**); otherwise **1,000 XAF**.

## Places

Copy and seed data use Cameroonian cities: Yaoundé, Bafoussam, Bamenda, Douala, Mbalmayo. Phone numbers use `+237` by default.

-- =============================================================================
-- The Farmer — full MySQL database (schema + seed)
-- Import this file in phpMyAdmin or:
--   mysql -u root -p < database/the_farmer.sql
--
-- Demo login (all accounts):  Farmer2026!
--   john@thefarmer.cm      Customer
--   bella@thefarmer.cm     Customer
--   aminata@thefarmer.cm   Customer
--   jean@thefarmer.cm      Farmer / vendor
--   patrick@thefarmer.cm   Farmer / vendor
--   mballa@thefarmer.cm    Farmer / vendor
--   ngono@thefarmer.cm     Administrator
--
-- Currency: integer XAF. Passwords: bcrypt (password_hash). Never plaintext.
-- =============================================================================

CREATE DATABASE IF NOT EXISTS the_farmer
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE the_farmer;

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
SET time_zone = '+01:00';

DROP TABLE IF EXISTS ratings;
DROP TABLE IF EXISTS newsletter_subscribers;
DROP TABLE IF EXISTS messages;
DROP TABLE IF EXISTS opportunity_applications;
DROP TABLE IF EXISTS opportunities;
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS platform_settings;
DROP TABLE IF EXISTS users;

SET FOREIGN_KEY_CHECKS = 1;

-- -----------------------------------------------------------------------------
-- users
-- -----------------------------------------------------------------------------
CREATE TABLE users (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  public_id     VARCHAR(16)  NOT NULL,
  name          VARCHAR(120) NOT NULL,
  email         VARCHAR(190) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  phone         VARCHAR(32)  DEFAULT NULL,
  address       VARCHAR(255) DEFAULT NULL,
  city          VARCHAR(80)  DEFAULT NULL,
  country       VARCHAR(80)  NOT NULL DEFAULT 'Cameroon',
  role          ENUM('customer','farmer','admin') NOT NULL DEFAULT 'customer',
  payment       VARCHAR(40)  NOT NULL DEFAULT 'Mobile money',
  gender        VARCHAR(24)  DEFAULT NULL,
  dob           DATE         DEFAULT NULL,
  wallet_xaf    INT UNSIGNED NOT NULL DEFAULT 0,
  language      VARCHAR(16)  NOT NULL DEFAULT 'english',
  theme         VARCHAR(8)   NOT NULL DEFAULT 'light',
  currency      VARCHAR(8)   NOT NULL DEFAULT 'xaf',
  avatar        VARCHAR(255) NOT NULL DEFAULT 'Image/profile.jpg',
  status        ENUM('active','suspended') NOT NULL DEFAULT 'active',
  created_at    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uq_users_public_id (public_id),
  UNIQUE KEY uq_users_email (email),
  KEY idx_users_role (role),
  KEY idx_users_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- products
-- -----------------------------------------------------------------------------
CREATE TABLE products (
  id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  vendor_id    INT UNSIGNED NOT NULL,
  sku          VARCHAR(16)  DEFAULT NULL,
  name         VARCHAR(160) NOT NULL,
  slug         VARCHAR(180) NOT NULL,
  category     ENUM('trees','fresh','juice','experience') NOT NULL,
  description  TEXT,
  price_xaf    INT UNSIGNED NOT NULL,
  stock        INT          NOT NULL DEFAULT 0,
  status       ENUM('pending','live','rejected','sold_out') NOT NULL DEFAULT 'pending',
  image_path   VARCHAR(255) DEFAULT NULL,
  badge        VARCHAR(32)  DEFAULT NULL,
  rating_avg   DECIMAL(2,1) NOT NULL DEFAULT 0.0,
  rating_count INT UNSIGNED NOT NULL DEFAULT 0,
  is_featured  TINYINT(1)   NOT NULL DEFAULT 0,
  created_at   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uq_products_slug (slug),
  UNIQUE KEY uq_products_sku (sku),
  KEY idx_products_status (status),
  KEY idx_products_vendor (vendor_id),
  KEY idx_products_category (category),
  CONSTRAINT fk_products_vendor FOREIGN KEY (vendor_id) REFERENCES users (id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- orders
-- -----------------------------------------------------------------------------
CREATE TABLE orders (
  id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  public_id    VARCHAR(16)  NOT NULL,
  user_id      INT UNSIGNED NOT NULL,
  total_xaf    INT UNSIGNED NOT NULL,
  delivery_xaf INT UNSIGNED NOT NULL DEFAULT 0,
  status       ENUM('pending','paid','packing','in_delivery','delivered','completed','cancelled') NOT NULL DEFAULT 'pending',
  city         VARCHAR(80)  DEFAULT NULL,
  address      VARCHAR(255) DEFAULT NULL,
  payment      VARCHAR(40)  DEFAULT NULL,
  notes        VARCHAR(255) DEFAULT NULL,
  created_at   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uq_orders_public_id (public_id),
  KEY idx_orders_user (user_id),
  KEY idx_orders_status (status),
  CONSTRAINT fk_orders_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE order_items (
  id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  order_id       INT UNSIGNED NOT NULL,
  product_id     INT UNSIGNED NOT NULL,
  vendor_id      INT UNSIGNED NOT NULL,
  name_snapshot  VARCHAR(160) NOT NULL,
  qty            INT UNSIGNED NOT NULL DEFAULT 1,
  unit_xaf       INT UNSIGNED NOT NULL,
  KEY idx_items_order (order_id),
  KEY idx_items_vendor (vendor_id),
  KEY idx_items_product (product_id),
  CONSTRAINT fk_items_order   FOREIGN KEY (order_id)   REFERENCES orders (id)   ON DELETE CASCADE,
  CONSTRAINT fk_items_product FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE RESTRICT,
  CONSTRAINT fk_items_vendor  FOREIGN KEY (vendor_id)  REFERENCES users (id)    ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- opportunities
-- -----------------------------------------------------------------------------
CREATE TABLE opportunities (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title      VARCHAR(180) NOT NULL,
  slug       VARCHAR(180) NOT NULL,
  type       ENUM('partnership','mentorship','employment','news','giveaway','sale') NOT NULL,
  body       TEXT,
  icon       VARCHAR(64)  DEFAULT 'fa-handshake',
  cta_label  VARCHAR(80)  DEFAULT 'Apply',
  status     ENUM('draft','pending','live','closed') NOT NULL DEFAULT 'pending',
  created_by INT UNSIGNED DEFAULT NULL,
  created_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uq_opportunities_slug (slug),
  KEY idx_opportunities_status (status),
  CONSTRAINT fk_opportunities_user FOREIGN KEY (created_by) REFERENCES users (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE opportunity_applications (
  id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id         INT UNSIGNED NOT NULL,
  opportunity_id  INT UNSIGNED NOT NULL,
  status          ENUM('saved','pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  note            VARCHAR(255) DEFAULT NULL,
  created_at      TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at      TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uq_app_user_opp (user_id, opportunity_id),
  CONSTRAINT fk_app_user FOREIGN KEY (user_id)        REFERENCES users (id)         ON DELETE CASCADE,
  CONSTRAINT fk_app_opp  FOREIGN KEY (opportunity_id) REFERENCES opportunities (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- messages, newsletter, ratings, settings
-- -----------------------------------------------------------------------------
CREATE TABLE messages (
  id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  sender_id    INT UNSIGNED DEFAULT NULL,
  recipient_id INT UNSIGNED NOT NULL,
  subject      VARCHAR(180) DEFAULT NULL,
  body         TEXT         NOT NULL,
  is_read      TINYINT(1)   NOT NULL DEFAULT 0,
  created_at   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY idx_msg_recipient (recipient_id, is_read),
  CONSTRAINT fk_msg_sender    FOREIGN KEY (sender_id)    REFERENCES users (id) ON DELETE SET NULL,
  CONSTRAINT fk_msg_recipient FOREIGN KEY (recipient_id) REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE newsletter_subscribers (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email      VARCHAR(190) NOT NULL,
  created_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_newsletter_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE ratings (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id    INT UNSIGNED NOT NULL,
  stars      TINYINT UNSIGNED NOT NULL,
  created_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_ratings_user (user_id),
  CONSTRAINT fk_ratings_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE platform_settings (
  setting_key   VARCHAR(64)  NOT NULL PRIMARY KEY,
  setting_value VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================================
-- SEED — bcrypt of Farmer2026!
-- =============================================================================
-- $2y$10$Pem/NPiailJMRqxlN8Fdm.H.rc0FGRu6/r.Q0WNqD6XN1k4UFuA/m

INSERT INTO users
  (id, public_id, name, email, password_hash, phone, address, city, country, role, payment, gender, dob, wallet_xaf, avatar, status, created_at)
VALUES
  (1, '01XJ00F', 'John Doe', 'john@thefarmer.cm',
      '$2y$10$Pem/NPiailJMRqxlN8Fdm.H.rc0FGRu6/r.Q0WNqD6XN1k4UFuA/m',
      '+237 605 048 910', 'Yaoundé, Simbock — Mendong', 'Yaoundé', 'Cameroon',
      'customer', 'Mobile money', 'Male', '1994-03-12', 12400, 'Image/profile.jpg', 'active', '2024-02-11 09:00:00'),
  (2, '02BN14K', 'Bella Ngwa', 'bella@thefarmer.cm',
      '$2y$10$Pem/NPiailJMRqxlN8Fdm.H.rc0FGRu6/r.Q0WNqD6XN1k4UFuA/m',
      '+237 677 112 233', 'Bastos, Yaoundé', 'Yaoundé', 'Cameroon',
      'customer', 'Cash', 'Female', '1996-07-22', 3500, 'Image/profile.jpg', 'active', '2025-01-18 10:00:00'),
  (3, '03JM22P', 'Jean-Claude Mbarga', 'jean@thefarmer.cm',
      '$2y$10$Pem/NPiailJMRqxlN8Fdm.H.rc0FGRu6/r.Q0WNqD6XN1k4UFuA/m',
      '+237 699 445 566', 'Banengo, Bafoussam', 'Bafoussam', 'Cameroon',
      'farmer', 'Mobile money', 'Male', '1988-11-03', 86000, 'Image/profile.jpg', 'active', '2024-05-02 08:00:00'),
  (4, '04AS09M', 'Aminata Salla', 'aminata@thefarmer.cm',
      '$2y$10$Pem/NPiailJMRqxlN8Fdm.H.rc0FGRu6/r.Q0WNqD6XN1k4UFuA/m',
      '+237 655 778 899', 'Commercial Avenue, Bamenda', 'Bamenda', 'Cameroon',
      'customer', 'Visa', 'Female', '1992-01-30', 0, 'Image/profile.jpg', 'active', '2025-03-09 14:00:00'),
  (5, '05PE31D', 'Patrick Etoundi', 'patrick@thefarmer.cm',
      '$2y$10$Pem/NPiailJMRqxlN8Fdm.H.rc0FGRu6/r.Q0WNqD6XN1k4UFuA/m',
      '+237 670 221 334', 'Akwa, Douala', 'Douala', 'Cameroon',
      'farmer', 'Bank card', 'Male', '1985-09-14', 54000, 'Image/profile.jpg', 'active', '2023-11-20 11:00:00'),
  (6, '06NK18T', 'Ngono Kesseng', 'ngono@thefarmer.cm',
      '$2y$10$Pem/NPiailJMRqxlN8Fdm.H.rc0FGRu6/r.Q0WNqD6XN1k4UFuA/m',
      '+237 605 048 910', 'Mendong, Yaoundé', 'Yaoundé', 'Cameroon',
      'admin', 'Mobile money', 'Female', '1990-04-08', 0, 'Image/profile.jpg', 'active', '2023-08-01 09:00:00'),
  (7, '07MF44R', 'Mballa Farms', 'mballa@thefarmer.cm',
      '$2y$10$Pem/NPiailJMRqxlN8Fdm.H.rc0FGRu6/r.Q0WNqD6XN1k4UFuA/m',
      '+237 681 900 112', 'Mbalmayo', 'Mbalmayo', 'Cameroon',
      'farmer', 'Mobile money', 'Male', '1982-06-19', 12000, 'Image/profile.jpg', 'active', '2025-06-01 09:00:00');

INSERT INTO products
  (id, vendor_id, sku, name, slug, category, description, price_xaf, stock, status, image_path, badge, rating_avg, rating_count, is_featured, created_at)
VALUES
  (1,  3, 'p1',  'Mature Orange Tree (Valencia)', 'mature-orange-tree-valencia', 'trees',
      '4–5 year old tree, already bearing fruit. Potted, delivered and ready to plant in your yard.',
      30000, 18, 'live', 'Image/product-images/88423a61-a94d-4d96-ba54-62aa4372992c_1500x1875.jpeg', 'Bestseller', 5.0, 24, 1, '2024-06-01 10:00:00'),
  (2,  3, 'p2',  'Mature Tangerine Tree', 'mature-tangerine-tree', 'trees',
      'Dense, reliable tangerine canopy. Plant it once, harvest it every winter for years.',
      25000, 11, 'live', 'Image/product-images/Tangerine-SpotlessFruitsIndia_1024x1024.png', NULL, 4.5, 11, 0, '2024-06-01 10:05:00'),
  (3,  3, 'p3',  'Fresh Oranges — 5 kg basket', 'fresh-oranges-5kg', 'fresh',
      'Hand-picked Valencia oranges, sweet and juicy. Delivered within 48 hours in Yaoundé.',
      3500, 42, 'live', 'Image/product-images/Orange-Fruit-Pieces.jpg', NULL, 4.8, 40, 1, '2024-06-02 08:00:00'),
  (4,  5, 'p4',  'Fresh Lemons — 3 kg', 'fresh-lemons-3kg', 'fresh',
      'Bright, zesty lemons picked in the morning for maximum juice and aroma.',
      2800, 30, 'live', 'Image/product-images/27554428-lemon-fruits-with-leaves-isolated-on-white.jpg', NULL, 4.5, 18, 0, '2024-06-02 08:10:00'),
  (5,  5, 'p5',  'Fresh Limes — 3 kg', 'fresh-limes-3kg', 'fresh',
      'Fragrant green limes, perfect for juice, tea, marinades and cooking.',
      2500, 22, 'live', 'Image/product-images/Lime-copy-scaled-1.jpg', NULL, 4.3, 9, 0, '2024-06-02 08:15:00'),
  (6,  3, 'p6',  'Mixed Citrus Platter — 6 kg', 'mixed-citrus-platter-6kg', 'fresh',
      'Our bestsellers on one platter: oranges, tangerines, lemons, limes and grapefruit.',
      6000, 9, 'live', 'Image/product-images/images-7.jpeg', 'New', 4.9, 33, 1, '2024-07-01 09:00:00'),
  (7,  3, 'p7',  'Fresh Orange Juice — 1 L', 'fresh-orange-juice-1l', 'juice',
      'Cold-pressed the same morning. No sugar, no water, no preservatives.',
      1800, 0, 'sold_out', 'Image/product-images/94253411-orange-juice-in-a-glass-bottle-and-orange-fruit-with-green-leaves-isolated-on-white-background.jpg', NULL, 4.6, 21, 1, '2024-07-04 07:30:00'),
  (8,  5, 'p8',  'Fresh Lemon Juice — 1 L', 'fresh-lemon-juice-1l', 'juice',
      'Sun-bright lemon juice, pressed to order in our farm kitchen.',
      1800, 16, 'live', 'Image/product-images/bottle-lemon-juice-fresh-lemons-25336807.jpg', NULL, 4.4, 8, 0, '2024-07-04 07:40:00'),
  (9,  5, 'p9',  'Sparkling Grapefruit — 750 ml', 'sparkling-grapefruit-750ml', 'juice',
      'Our cellar''s pink sparkling grapefruit — dry, fizzy and festive.',
      8500, 14, 'live', 'Image/product-images/cd2304634da009da07e0e2f77650cedc0cf695de213a16fd6171548fed4629d4.jpg', NULL, 4.2, 6, 0, '2024-08-01 12:00:00'),
  (10, 3, 'p10', 'Natural Orange Wine — 750 ml', 'natural-orange-wine-750ml', 'juice',
      'Vegan orange wine from our own harvest. No added sugars, yeasts or sulphites.',
      9000, 10, 'live', 'Image/product-images/images2.jpeg', NULL, 4.7, 12, 0, '2024-08-01 12:10:00'),
  (11, 3, 'p11', 'Farm Visit & Self-Harvest', 'farm-visit-self-harvest', 'experience',
      'Spend a day with our growers, pick your own fruit basket and take the harvest home.',
      15000, 30, 'live', 'Image/farm6.jpg', 'Popular', 5.0, 19, 0, '2024-09-01 09:00:00'),
  (12, 5, 'p12', 'Orchard Box — 1 month', 'orchard-box-1-month', 'experience',
      'A weekly box of seasonal citrus, fresh juice and farm news delivered to your door.',
      12000, 20, 'live', 'Image/farm5.jpg', NULL, 4.6, 15, 0, '2024-09-01 09:10:00'),
  (13, 3, 'p13', 'Pink Grapefruit Tree', 'pink-grapefruit-tree', 'trees',
      'Young pink grapefruit, grafted on hardy rootstock. Ready for a Yaoundé courtyard.',
      28000, 6, 'pending', 'Image/product-images/Tangerine-SpotlessFruitsIndia_1024x1024.png', NULL, 0.0, 0, 0, '2026-08-24 11:00:00'),
  (14, 5, 'p14', 'Honey Tangerine — 4 kg', 'honey-tangerine-4kg', 'fresh',
      'Sweet honey tangerines from the Douala peri-urban plots.',
      3200, 24, 'pending', 'Image/product-images/images-7.jpeg', NULL, 0.0, 0, 0, '2026-08-23 16:20:00'),
  (15, 7, 'p15', 'Cold-pressed Lime Juice', 'cold-pressed-lime-juice', 'juice',
      'Pressed in Mbalmayo the same morning. No sugar, no water.',
      2000, 40, 'pending', 'Image/product-images/Lime-copy-scaled-1.jpg', NULL, 0.0, 0, 0, '2026-08-22 09:45:00');

-- Fix sparkling image path to the real filename in the repo
UPDATE products SET image_path = 'Image/product-images/cd2304634ba009da07e0e2f77650cedc0cf695de213a16fd6171548fed4629d4.jpg' WHERE id = 9;
-- Home featured row needs four live items (juice p7 is sold out)
UPDATE products SET is_featured = 1 WHERE id = 11;

INSERT INTO orders
  (id, public_id, user_id, total_xaf, delivery_xaf, status, city, address, payment, created_at)
VALUES
  (1, 'TF-1042', 1, 6000,  1000, 'delivered',    'Yaoundé', 'Yaoundé, Simbock — Mendong', 'Mobile money', '2026-08-12 10:22:00'),
  (2, 'TF-1017', 1, 31000, 0,    'in_delivery',  'Yaoundé', 'Yaoundé, Simbock — Mendong', 'Mobile money', '2026-07-28 15:10:00'),
  (3, 'TF-1004', 1, 7200,  1000, 'delivered',    'Yaoundé', 'Yaoundé, Simbock — Mendong', 'Mobile money', '2026-07-11 09:05:00'),
  (4, 'TF-0988', 1, 12000, 1000, 'delivered',    'Yaoundé', 'Yaoundé, Simbock — Mendong', 'Mobile money', '2026-07-02 18:40:00'),
  (5, 'TF-0961', 1, 30000, 0,    'completed',    'Yaoundé', 'Yaoundé, Simbock — Mendong', 'Mobile money', '2026-06-18 08:00:00'),
  (6, 'TF-1048', 2, 7000,  1000, 'packing',      'Yaoundé', 'Bastos, Yaoundé',            'Cash',         '2026-08-25 11:12:00'),
  (7, 'TF-1046', 3, 25000, 0,    'in_delivery',  'Bafoussam', 'Banengo, Bafoussam',        'Mobile money', '2026-08-24 17:00:00'),
  (8, 'TF-1043', 4, 6000,  1000, 'packing',      'Bamenda', 'Commercial Avenue, Bamenda', 'Visa',         '2026-08-24 09:30:00'),
  (9, 'TF-1039', 5, 45000, 0,    'paid',         'Douala',  'Akwa, Douala',               'Bank card',    '2026-08-20 13:45:00');

INSERT INTO order_items (order_id, product_id, vendor_id, name_snapshot, qty, unit_xaf) VALUES
  (1, 6,  3, 'Mixed Citrus Platter — 6 kg',     1, 6000),
  (2, 1,  3, 'Mature Orange Tree (Valencia)',   1, 30000),
  (3, 7,  3, 'Fresh Orange Juice — 1 L',        4, 1800),
  (4, 12, 5, 'Orchard Box — 1 month',           1, 12000),
  (5, 11, 3, 'Farm Visit & Self-Harvest',       2, 15000),
  (6, 3,  3, 'Fresh Oranges — 5 kg basket',     2, 3500),
  (7, 2,  3, 'Mature Tangerine Tree',           1, 25000),
  (8, 6,  3, 'Mixed Citrus Platter — 6 kg',     1, 6000),
  (9, 11, 3, 'Farm Visit & Self-Harvest',       3, 15000);

INSERT INTO opportunities (id, title, slug, type, body, icon, cta_label, status, created_by, created_at) VALUES
  (1, 'Partnership Program', 'partnership-program', 'partnership',
      'Become an official The Farmer partner: sell on our shelves, buy our trees at partner prices and co-market the harvest across Cameroon and Central Africa.',
      'fa-handshake', 'Apply as partner', 'live', 6, '2024-03-01 09:00:00'),
  (2, 'Mentorship Program', 'mentorship-program', 'mentorship',
      'Learn from our best tutors — soil preparation, irrigation, citrus care and how to turn a plot of land into a real, profitable business.',
      'fa-hands-holding-child', 'Find a mentor', 'live', 6, '2024-03-01 09:05:00'),
  (3, 'Get Employed', 'get-employed', 'employment',
      'Well-paid seasonal and permanent roles on our farm and with our partner companies — from nursery care and orchard work to delivery driving.',
      'fa-briefcase', 'See open roles', 'live', 6, '2024-03-01 09:10:00'),
  (4, 'The Farmer News', 'the-farmer-news', 'news',
      'Daily updates straight from the field: harvest news, weather, market prices and new opportunities as they happen.',
      'fa-newspaper', 'Read the latest', 'live', 6, '2024-03-01 09:15:00'),
  (5, 'Gift & Giveaway', 'gift-giveaway', 'giveaway',
      'Join our G&GA program: monthly giveaways of free trees, fruit baskets and harvest tours for the community. Awesome prizes, easy entry.',
      'fa-gift', 'Join the next draw', 'live', 6, '2024-03-01 09:20:00'),
  (6, 'Big Sales Show', 'big-sales-show', 'sale',
      'Our BSS events: the whole harvest at the best prices of the season — 48 hours only, once a quarter, in Yaoundé.',
      'fa-bolt', 'Get the date', 'live', 6, '2024-03-01 09:25:00'),
  (7, 'Youth harvest crew — seasonal', 'youth-harvest-crew', 'employment',
      'Six-week paid harvest crew for growers aged 18–30 around Simbock and Mbalmayo.',
      'fa-briefcase', 'Apply', 'pending', 6, '2026-08-20 10:00:00'),
  (8, 'Retail partner — Douala market', 'retail-partner-douala', 'partnership',
      'Kotto Fresh Ltd. wants a standing weekly citrus supply into Douala central market.',
      'fa-handshake', 'Review', 'pending', 5, '2026-08-21 11:00:00'),
  (9, 'Soil clinic — Bafoussam', 'soil-clinic-bafoussam', 'mentorship',
      'Jean-Claude Mbarga hosts a free soil clinic for new citrus growers in Bafoussam.',
      'fa-hands-holding-child', 'Join', 'live', 3, '2026-08-10 08:00:00');

INSERT INTO opportunity_applications (user_id, opportunity_id, status, created_at) VALUES
  (1, 1, 'pending',  '2026-08-04 09:00:00'),
  (1, 2, 'accepted', '2026-05-12 09:00:00'),
  (2, 5, 'pending',  '2026-08-01 12:00:00'),
  (4, 3, 'saved',    '2026-07-22 16:00:00');

INSERT INTO messages (sender_id, recipient_id, subject, body, is_read, created_at) VALUES
  (6, 1, 'Delivery today', 'Your Valencia tree is out for delivery in Yaoundé today. Please keep a clear path to the courtyard.', 0, '2026-08-26 09:14:00'),
  (3, 1, 'Mentorship visit', 'Shall we visit the Simbock plot on Saturday morning? Bring a notebook and boots.', 0, '2026-08-25 18:02:00'),
  (6, 1, 'Orchard Box', 'Your Orchard Box for August has been packed. The rider will call from a +237 number.', 1, '2026-08-11 10:40:00'),
  (6, 3, 'Listing received', 'We received your Pink Grapefruit Tree listing. An admin will review it within 48 hours.', 0, '2026-08-24 11:05:00'),
  (6, 2, 'Order TF-1048', 'Bella, we are packing your two orange baskets. Pickup in Bastos is ready from 16:00.', 0, '2026-08-25 11:30:00');

INSERT INTO newsletter_subscribers (email, created_at) VALUES
  ('bella@thefarmer.cm', '2025-02-01 08:00:00'),
  ('aminata@thefarmer.cm', '2025-04-12 08:00:00');

INSERT INTO ratings (user_id, stars, created_at) VALUES
  (1, 5, '2026-07-01 12:00:00'),
  (2, 5, '2026-07-15 12:00:00'),
  (4, 4, '2026-08-01 12:00:00');

INSERT INTO platform_settings (setting_key, setting_value) VALUES
  ('default_currency', 'XAF'),
  ('free_delivery_threshold', '20000'),
  ('delivery_fee', '1000'),
  ('free_delivery_city', 'Yaoundé'),
  ('support_phone', '+237 605 048 910'),
  ('support_email', 'temrick4@gmail.com');

SET FOREIGN_KEY_CHECKS = 1;

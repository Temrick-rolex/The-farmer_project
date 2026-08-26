-- The Farmer — MySQL schema (utf8mb4). Run when the backend is wired.
-- Currency: integer XAF amounts. Never store plaintext passwords.

CREATE DATABASE IF NOT EXISTS the_farmer
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE the_farmer;

CREATE TABLE users (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  public_id     VARCHAR(16) NOT NULL UNIQUE,
  name          VARCHAR(120) NOT NULL,
  email         VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  phone         VARCHAR(32),
  address       VARCHAR(255),
  city          VARCHAR(80),
  country       VARCHAR(80) DEFAULT 'Cameroon',
  role          ENUM('customer','farmer','admin') NOT NULL DEFAULT 'customer',
  payment       VARCHAR(40) DEFAULT 'mobile_money',
  gender        VARCHAR(24),
  created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE products (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  vendor_id   INT UNSIGNED NOT NULL,
  name        VARCHAR(160) NOT NULL,
  slug        VARCHAR(180) NOT NULL UNIQUE,
  category    ENUM('trees','fresh','juice','experience') NOT NULL,
  description TEXT,
  price_xaf   INT UNSIGNED NOT NULL,
  stock       INT NOT NULL DEFAULT 0,
  status      ENUM('pending','live','rejected','sold_out') NOT NULL DEFAULT 'pending',
  image_path  VARCHAR(255),
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_products_vendor FOREIGN KEY (vendor_id) REFERENCES users(id)
) ENGINE=InnoDB;

CREATE TABLE orders (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  public_id   VARCHAR(16) NOT NULL UNIQUE,
  user_id     INT UNSIGNED NOT NULL,
  total_xaf   INT UNSIGNED NOT NULL,
  delivery_xaf INT UNSIGNED NOT NULL DEFAULT 0,
  status      ENUM('pending','paid','packing','in_delivery','delivered','cancelled') NOT NULL DEFAULT 'pending',
  city        VARCHAR(80),
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_orders_user FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB;

CREATE TABLE order_items (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  order_id    INT UNSIGNED NOT NULL,
  product_id  INT UNSIGNED NOT NULL,
  qty         INT UNSIGNED NOT NULL DEFAULT 1,
  unit_xaf    INT UNSIGNED NOT NULL,
  CONSTRAINT fk_items_order FOREIGN KEY (order_id) REFERENCES orders(id),
  CONSTRAINT fk_items_product FOREIGN KEY (product_id) REFERENCES products(id)
) ENGINE=InnoDB;

CREATE TABLE opportunities (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title       VARCHAR(180) NOT NULL,
  type        ENUM('partnership','mentorship','employment','news','giveaway','sale') NOT NULL,
  body        TEXT,
  status      ENUM('draft','pending','live','closed') NOT NULL DEFAULT 'pending',
  created_by  INT UNSIGNED,
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE opportunity_saves (
  user_id         INT UNSIGNED NOT NULL,
  opportunity_id  INT UNSIGNED NOT NULL,
  status          VARCHAR(40) DEFAULT 'saved',
  created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (user_id, opportunity_id)
) ENGINE=InnoDB;

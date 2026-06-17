# E-Commerce Database - Complete Table Reference Guide

## QUICK REFERENCE: All Tables & Fields

### 1. USERS TABLE
```sql
users (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  email_verified_at TIMESTAMP NULL,
  password VARCHAR(255) NOT NULL,
  phone VARCHAR(20) NULL,
  role ENUM('admin', 'customer') DEFAULT 'customer',
  is_active BOOLEAN DEFAULT true,
  last_login_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at TIMESTAMP NULL,
  
  INDEX idx_email (email),
  INDEX idx_role (role),
  INDEX idx_is_active (is_active)
)
```

---

### 2. CUSTOMERS TABLE
```sql
customers (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  user_id BIGINT UNIQUE NOT NULL,
  date_of_birth DATE NULL,
  gender ENUM('male', 'female', 'other') NULL,
  loyalty_points INT DEFAULT 0,
  total_spent DECIMAL(19,2) DEFAULT 0,
  is_premium BOOLEAN DEFAULT false,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_is_premium (is_premium)
)
```

---

### 3. CATEGORIES TABLE
```sql
categories (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  parent_id BIGINT NULL,
  name VARCHAR(255) NOT NULL,
  slug VARCHAR(255) UNIQUE NOT NULL,
  description TEXT NULL,
  image_url VARCHAR(255) NULL,
  is_active BOOLEAN DEFAULT true,
  sort_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE CASCADE,
  INDEX idx_parent_id (parent_id),
  INDEX idx_slug (slug),
  INDEX idx_is_active (is_active)
)
```

---

### 4. PRODUCTS TABLE
```sql
products (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  category_id BIGINT NOT NULL,
  name VARCHAR(255) NOT NULL,
  slug VARCHAR(255) UNIQUE NOT NULL,
  sku VARCHAR(100) UNIQUE NOT NULL,
  description TEXT NULL,
  short_desc VARCHAR(500) NULL,
  price DECIMAL(19,2) NOT NULL,
  cost_price DECIMAL(19,2) NULL,
  stock_quantity INT DEFAULT 0,
  low_stock_alert INT DEFAULT 10,
  is_active BOOLEAN DEFAULT true,
  is_featured BOOLEAN DEFAULT false,
  rating DECIMAL(3,2) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at TIMESTAMP NULL,
  
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
  INDEX idx_category_id (category_id),
  INDEX idx_slug (slug),
  INDEX idx_sku (sku),
  INDEX idx_is_active (is_active),
  INDEX idx_is_featured (is_featured)
)
```

---

### 5. PRODUCT_IMAGES TABLE
```sql
product_images (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  product_id BIGINT NOT NULL,
  image_url VARCHAR(255) NOT NULL,
  alt_text VARCHAR(255) NULL,
  sort_order INT DEFAULT 0,
  is_primary BOOLEAN DEFAULT false,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
  INDEX idx_product_id (product_id),
  INDEX idx_is_primary (is_primary)
)
```

---

### 6. PRODUCT_VARIANTS TABLE
```sql
product_variants (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  product_id BIGINT NOT NULL,
  name VARCHAR(255) NOT NULL,
  sku VARCHAR(100) UNIQUE NOT NULL,
  price_modifier DECIMAL(19,2) DEFAULT 0,
  stock_quantity INT DEFAULT 0,
  attributes JSON NOT NULL,
  is_active BOOLEAN DEFAULT true,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
  INDEX idx_product_id (product_id),
  INDEX idx_sku (sku)
)
```

---

### 7. CARTS TABLE
```sql
carts (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  user_id BIGINT UNIQUE NOT NULL,
  total_items INT DEFAULT 0,
  total_price DECIMAL(19,2) DEFAULT 0,
  abandoned_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_abandoned_at (abandoned_at)
)
```

---

### 8. CART_ITEMS TABLE
```sql
cart_items (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  cart_id BIGINT NOT NULL,
  product_id BIGINT NOT NULL,
  variant_id BIGINT NULL,
  quantity INT NOT NULL DEFAULT 1,
  price DECIMAL(19,2) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (cart_id) REFERENCES carts(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
  FOREIGN KEY (variant_id) REFERENCES product_variants(id) ON DELETE SET NULL,
  INDEX idx_cart_id (cart_id),
  INDEX idx_product_id (product_id)
)
```

---

### 9. WISHLISTS TABLE
```sql
wishlists (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  user_id BIGINT NOT NULL,
  product_id BIGINT NOT NULL,
  variant_id BIGINT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
  FOREIGN KEY (variant_id) REFERENCES product_variants(id) ON DELETE SET NULL,
  UNIQUE KEY unique_wishlist (user_id, product_id),
  INDEX idx_user_id (user_id),
  INDEX idx_product_id (product_id)
)
```

---

### 10. ORDERS TABLE
```sql
orders (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  user_id BIGINT NOT NULL,
  order_number VARCHAR(50) UNIQUE NOT NULL,
  status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded') DEFAULT 'pending',
  payment_status ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending',
  subtotal DECIMAL(19,2) NOT NULL,
  tax_amount DECIMAL(19,2) DEFAULT 0,
  shipping_cost DECIMAL(19,2) DEFAULT 0,
  discount_amount DECIMAL(19,2) DEFAULT 0,
  total_amount DECIMAL(19,2) NOT NULL,
  shipping_address JSON NOT NULL,
  billing_address JSON NOT NULL,
  notes TEXT NULL,
  tracking_number VARCHAR(100) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at TIMESTAMP NULL,
  
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  UNIQUE KEY unique_order_number (order_number),
  INDEX idx_user_id (user_id),
  INDEX idx_status (status),
  INDEX idx_payment_status (payment_status),
  INDEX idx_created_at (created_at)
)
```

---

### 11. ORDER_ITEMS TABLE
```sql
order_items (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  order_id BIGINT NOT NULL,
  product_id BIGINT NULL,
  variant_id BIGINT NULL,
  product_name VARCHAR(255) NOT NULL,
  sku VARCHAR(100) NOT NULL,
  quantity INT NOT NULL,
  unit_price DECIMAL(19,2) NOT NULL,
  total_price DECIMAL(19,2) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL,
  FOREIGN KEY (variant_id) REFERENCES product_variants(id) ON DELETE SET NULL,
  INDEX idx_order_id (order_id),
  INDEX idx_product_id (product_id)
)
```

---

### 12. PAYMENTS TABLE
```sql
payments (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  order_id BIGINT UNIQUE NOT NULL,
  payment_method ENUM('card', 'upi', 'wallet', 'net_banking') NOT NULL,
  amount DECIMAL(19,2) NOT NULL,
  currency VARCHAR(3) DEFAULT 'INR',
  transaction_id VARCHAR(100) UNIQUE NOT NULL,
  status ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending',
  gateway VARCHAR(50) NOT NULL,
  gateway_response JSON NULL,
  paid_at TIMESTAMP NULL,
  refund_amount DECIMAL(19,2) DEFAULT 0,
  refunded_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  INDEX idx_status (status),
  INDEX idx_transaction_id (transaction_id)
)
```

---

### 13. REVIEWS TABLE
```sql
reviews (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  product_id BIGINT NOT NULL,
  user_id BIGINT NOT NULL,
  order_item_id BIGINT NULL,
  rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
  title VARCHAR(255) NOT NULL,
  comment TEXT NULL,
  is_verified_buy BOOLEAN DEFAULT false,
  helpful_count INT DEFAULT 0,
  unhelpful_count INT DEFAULT 0,
  is_approved BOOLEAN DEFAULT false,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at TIMESTAMP NULL,
  
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (order_item_id) REFERENCES order_items(id) ON DELETE SET NULL,
  UNIQUE KEY unique_review (product_id, user_id),
  INDEX idx_product_id (product_id),
  INDEX idx_user_id (user_id),
  INDEX idx_is_approved (is_approved),
  INDEX idx_created_at (created_at)
)
```

---

### 14. COUPONS TABLE
```sql
coupons (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  code VARCHAR(50) UNIQUE NOT NULL,
  description TEXT NULL,
  discount_type ENUM('percentage', 'fixed') NOT NULL,
  discount_value DECIMAL(19,2) NOT NULL,
  max_discount DECIMAL(19,2) NULL,
  min_order_value DECIMAL(19,2) DEFAULT 0,
  max_usage INT NULL,
  per_user_limit INT DEFAULT 1,
  used_count INT DEFAULT 0,
  valid_from DATETIME NOT NULL,
  valid_until DATETIME NOT NULL,
  is_active BOOLEAN DEFAULT true,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  UNIQUE KEY unique_code (code),
  INDEX idx_is_active (is_active),
  INDEX idx_valid_from (valid_from),
  INDEX idx_valid_until (valid_until)
)
```

---

### 15. COUPON_ORDERS TABLE (Pivot/Junction)
```sql
coupon_orders (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  coupon_id BIGINT NOT NULL,
  order_id BIGINT NOT NULL,
  discount_applied DECIMAL(19,2) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (coupon_id) REFERENCES coupons(id) ON DELETE CASCADE,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  UNIQUE KEY unique_coupon_order (coupon_id, order_id)
)
```

---

### 16. NOTIFICATIONS TABLE
```sql
notifications (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  user_id BIGINT NOT NULL,
  type VARCHAR(50) NOT NULL,
  title VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  related_model VARCHAR(50) NULL,
  related_id BIGINT NULL,
  is_read BOOLEAN DEFAULT false,
  read_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_user_id (user_id),
  INDEX idx_is_read (is_read),
  INDEX idx_created_at (created_at)
)
```

---

## RELATIONSHIP MATRIX

### One-to-One (1:1)
| Parent | Child | Nature |
|--------|-------|--------|
| users | customers | Each user has max 1 customer profile (customers only) |
| users | carts | Each user has 1 active cart |
| orders | payments | Each order has 1 payment record |

### One-to-Many (1:N)
| Parent | Child | Nature |
|--------|-------|--------|
| users | orders | 1 user → many orders |
| users | reviews | 1 user → many reviews |
| users | wishlists | 1 user → many wishlist items |
| users | notifications | 1 user → many notifications |
| categories | products | 1 category → many products |
| categories | categories | 1 parent category → many subcategories |
| products | product_images | 1 product → many images |
| products | product_variants | 1 product → many variants |
| products | reviews | 1 product → many reviews |
| products | cart_items | 1 product → many cart items |
| carts | cart_items | 1 cart → many items |
| orders | order_items | 1 order → many line items |

### Many-to-Many (M:N) with Pivot Table
| Table 1 | Pivot Table | Table 2 | Nature |
|---------|-------------|---------|--------|
| coupons | coupon_orders | orders | 1 order can use many coupons; 1 coupon used on many orders |
| users | wishlists | products | 1 user can wishlist many products; 1 product on many wishlists |
| carts | cart_items | products | 1 cart has many products; 1 product in many carts |

### Has-Many-Through (Polymorphic/Derived)
| From | Through | To | Purpose |
|------|---------|----|---------| 
| users | carts | products | All products user has in cart |
| users | orders | products | All products user has purchased |
| categories | products | reviews | All reviews for products in category |
| categories | products | cart_items | All cart items for products in category |

---

## CASCADING DELETE BEHAVIOR

### CASCADE (Parent deletion deletes all children)
- users → customers, orders, reviews, wishlists, notifications, carts
- products → product_images, product_variants, reviews, cart_items
- categories → child_categories, products
- carts → cart_items
- orders → order_items, payments
- coupons → coupon_orders

### SET NULL (Optional references preserved)
- cart_items.variant_id → product_variants
- wishlists.variant_id → product_variants
- order_items.product_id → products
- order_items.variant_id → product_variants
- reviews.order_item_id → order_items

---

## KEY QUERIES ENABLED BY THIS DESIGN

### User Queries
```
- Get all orders for a user: users → orders
- Get user's cart with items: users → carts → cart_items → products
- Get user's wishlist: users → wishlists → products
- Get user's reviews: users → reviews → products
```

### Product Queries
```
- Get all variants of a product: products → product_variants
- Get all images for a product: products → product_images
- Get all reviews for a product: products → reviews
- Get category and subcategories: categories (self-join)
- Get all products in category tree: categories → products
```

### Order Queries
```
- Get order with line items: orders → order_items → products
- Get order payment details: orders → payments
- Get coupons used on order: orders → coupon_orders → coupons
- Get user order history with totals: orders
```

### Analytics Queries
```
- Total revenue by category: orders → order_items → products → categories
- Average product rating: reviews grouped by product_id
- Top selling products: order_items aggregated
- Customer lifetime value: SUM(orders.total_amount) by user_id
- Abandoned cart recovery: carts WHERE abandoned_at IS NOT NULL
```

---

## IMPORTANT NOTES FOR DEVELOPERS

1. **Always use transactions** when modifying orders + payments together
2. **Update denormalized fields** (carts.total_price, products.rating) via triggers or application logic
3. **Archive strategy**: Consider archiving old orders (>2 years) to separate table for performance
4. **Soft deletes** on users/products/orders - always filter with `WHERE deleted_at IS NULL` in queries
5. **JSON fields** (addresses, attributes) - validate in application layer
6. **Stock management** - use database constraints or application-level validation
7. **Coupon validation** - check expiry, max usage, and per-user limits before applying
8. **Payment gateway integration** - store full response in gateway_response JSON for troubleshooting

---

## NEXT STEPS (Will create in Step 2)
- ✅ Database Design (COMPLETED)
- ⏳ Create migrations
- ⏳ Create models
- ⏳ Create controllers & routes
- ⏳ Create views & templates
- ⏳ Create policies & middleware
- ⏳ Create notifications & events

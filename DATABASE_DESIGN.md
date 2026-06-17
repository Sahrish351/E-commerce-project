# E-Commerce Database Design Documentation

## 1. ENTITY RELATIONSHIP DIAGRAM (ERD)

```
┌─────────────────────────────────────────────────────────────────────┐
│                        E-COMMERCE DATABASE ERD                       │
└─────────────────────────────────────────────────────────────────────┘

                            ┌──────────────┐
                            │    Users     │
                            └──────────────┘
                                   │
                    ┌──────────────┼──────────────┐
                    │              │              │
            ┌───────▼────────┐    │    ┌─────────▼──────────┐
            │   Customers    │    │    │      Admins        │
            │   (has many)   │    │    │   (has many)       │
            └────────────────┘    │    └────────────────────┘
                    │             │
        ┌───────────┼─────────────┼───────────────┐
        │           │             │               │
    ┌───▼──┐  ┌────▼────┐  ┌─────▼──────┐  ┌────▼─────┐
    │Carts │  │ Wishlists│  │Notifications│  │ Reviews  │
    └──────┘  └──────────┘  └────────────┘  └──────────┘
        │           │
        └─────┬─────┘
              │ (many to many through pivot)
              │
        ┌─────▼────────────┐
        │    Products      │
        │  (has many)      │
        └──────────────────┘
              │
    ┌─────────┼──────────────┐
    │         │              │
┌───▼──────┐ │   ┌──────────▼─────────┐
│Categories│ │   │ ProductVariants    │
│(many to) │ │   │ (has many)         │
└──────────┘ │   └────────────────────┘
             │
        ┌────▼────────────┐
        │  ProductImages  │
        │  (has many)     │
        └─────────────────┘


        ┌─────────────┐
        │   Orders    │
        └─────────────┘
              │
    ┌─────────┼─────────────┐
    │         │             │
┌───▼──────┐  │  ┌─────────▼─────┐
│OrderItems│  │  │    Payments    │
└──────────┘  │  └────────────────┘
              │
        ┌─────▼──────────┐
        │   Coupons      │
        │(many to many)  │
        └────────────────┘
```

---

## 2. DETAILED TABLE DEFINITIONS

### 2.1 USERS TABLE
**Purpose:** Core user authentication and profile data

```
Table: users
┌──────────────────────────────────────┐
│ Column Name       │ Type       │ Notes│
├──────────────────────────────────────┤
│ id               │ BIGINT PK  │ Auto-increment
│ name             │ VARCHAR    │ Full name
│ email            │ VARCHAR    │ Unique, indexed
│ email_verified_at│ TIMESTAMP  │ NULL if unverified
│ password         │ VARCHAR    │ Bcrypt hashed
│ phone            │ VARCHAR    │ Optional
│ role             │ ENUM       │ 'admin', 'customer'
│ is_active        │ BOOLEAN    │ Default: true
│ last_login_at    │ TIMESTAMP  │ Track activity
│ created_at       │ TIMESTAMP  │ Auto
│ updated_at       │ TIMESTAMP  │ Auto
│ deleted_at       │ TIMESTAMP  │ Soft delete
└──────────────────────────────────────┘
```

**Indexes:** email (unique), role, is_active

---

### 2.2 CUSTOMERS TABLE
**Purpose:** Customer-specific data (extends users for customers only)

```
Table: customers
┌──────────────────────────────────────┐
│ Column Name       │ Type       │ Notes│
├──────────────────────────────────────┤
│ id               │ BIGINT PK  │ Auto-increment
│ user_id          │ BIGINT FK  │ users.id (unique)
│ date_of_birth    │ DATE       │ Optional
│ gender           │ ENUM       │ 'male','female','other'
│ loyalty_points   │ INT        │ Default: 0
│ total_spent      │ DECIMAL    │ 19,2 - Track spending
│ is_premium       │ BOOLEAN    │ Default: false
│ created_at       │ TIMESTAMP  │ Auto
│ updated_at       │ TIMESTAMP  │ Auto
└──────────────────────────────────────┘
```

**Foreign Keys:** user_id → users.id (cascade delete)
**Indexes:** user_id (unique), is_premium

---

### 2.3 CATEGORIES TABLE
**Purpose:** Product categorization with hierarchical support

```
Table: categories
┌──────────────────────────────────────┐
│ Column Name       │ Type       │ Notes│
├──────────────────────────────────────┤
│ id               │ BIGINT PK  │ Auto-increment
│ parent_id        │ BIGINT FK  │ NULL for root, self-ref
│ name             │ VARCHAR    │ Unique per parent
│ slug             │ VARCHAR    │ URL-friendly, unique
│ description      │ TEXT       │ Optional
│ image_url        │ VARCHAR    │ Category icon/image
│ is_active        │ BOOLEAN    │ Default: true
│ sort_order       │ INT        │ For display ordering
│ created_at       │ TIMESTAMP  │ Auto
│ updated_at       │ TIMESTAMP  │ Auto
└──────────────────────────────────────┘
```

**Foreign Keys:** parent_id → categories.id (cascade delete)
**Indexes:** parent_id, slug, is_active

---

### 2.4 PRODUCTS TABLE
**Purpose:** Core product information

```
Table: products
┌──────────────────────────────────────┐
│ Column Name       │ Type       │ Notes│
├──────────────────────────────────────┤
│ id               │ BIGINT PK  │ Auto-increment
│ category_id      │ BIGINT FK  │ categories.id
│ name             │ VARCHAR    │ Product name
│ slug             │ VARCHAR    │ URL-friendly, unique
│ sku              │ VARCHAR    │ Unique SKU
│ description      │ TEXT       │ Full description
│ short_desc       │ VARCHAR    │ Brief description
│ price            │ DECIMAL    │ 19,2 - Base price
│ cost_price       │ DECIMAL    │ 19,2 - For profit calc
│ stock_quantity   │ INT        │ Total available
│ low_stock_alert  │ INT        │ Alert threshold
│ is_active        │ BOOLEAN    │ Default: true
│ is_featured      │ BOOLEAN    │ Featured on homepage
│ rating           │ DECIMAL    │ 3,2 - Avg rating (0-5)
│ created_at       │ TIMESTAMP  │ Auto
│ updated_at       │ TIMESTAMP  │ Auto
│ deleted_at       │ TIMESTAMP  │ Soft delete
└──────────────────────────────────────┘
```

**Foreign Keys:** category_id → categories.id (cascade delete)
**Indexes:** category_id, slug (unique), sku (unique), is_active

---

### 2.5 PRODUCT_IMAGES TABLE
**Purpose:** Store multiple images per product

```
Table: product_images
┌──────────────────────────────────────┐
│ Column Name       │ Type       │ Notes│
├──────────────────────────────────────┤
│ id               │ BIGINT PK  │ Auto-increment
│ product_id       │ BIGINT FK  │ products.id
│ image_url        │ VARCHAR    │ Image path/URL
│ alt_text         │ VARCHAR    │ For accessibility
│ sort_order       │ INT        │ Display order
│ is_primary       │ BOOLEAN    │ Primary image flag
│ created_at       │ TIMESTAMP  │ Auto
│ updated_at       │ TIMESTAMP  │ Auto
└──────────────────────────────────────┘
```

**Foreign Keys:** product_id → products.id (cascade delete)
**Indexes:** product_id, is_primary

---

### 2.6 PRODUCT_VARIANTS TABLE
**Purpose:** Handle product variations (size, color, etc.)

```
Table: product_variants
┌──────────────────────────────────────┐
│ Column Name       │ Type       │ Notes│
├──────────────────────────────────────┤
│ id               │ BIGINT PK  │ Auto-increment
│ product_id       │ BIGINT FK  │ products.id
│ name             │ VARCHAR    │ e.g. 'Red-Large'
│ sku              │ VARCHAR    │ Unique variant SKU
│ price_modifier   │ DECIMAL    │ 19,2 - +/- from base
│ stock_quantity   │ INT        │ Variant stock
│ attributes       │ JSON       │ {size, color, etc}
│ is_active        │ BOOLEAN    │ Default: true
│ created_at       │ TIMESTAMP  │ Auto
│ updated_at       │ TIMESTAMP  │ Auto
└──────────────────────────────────────┘
```

**Foreign Keys:** product_id → products.id (cascade delete)
**Indexes:** product_id, sku (unique)

---

### 2.7 CARTS TABLE
**Purpose:** Shopping cart management (abandoned carts tracking)

```
Table: carts
┌──────────────────────────────────────┐
│ Column Name       │ Type       │ Notes│
├──────────────────────────────────────┤
│ id               │ BIGINT PK  │ Auto-increment
│ user_id          │ BIGINT FK  │ users.id (unique)
│ total_items      │ INT        │ Denormalized count
│ total_price      │ DECIMAL    │ 19,2 - Total value
│ created_at       │ TIMESTAMP  │ Auto
│ updated_at       │ TIMESTAMP  │ Auto
│ abandoned_at     │ TIMESTAMP  │ NULL if active
└──────────────────────────────────────┘
```

**Foreign Keys:** user_id → users.id (cascade delete, unique)
**Indexes:** user_id (unique), abandoned_at

---

### 2.8 CART_ITEMS TABLE
**Purpose:** Products in shopping cart (has many through relationship)

```
Table: cart_items
┌──────────────────────────────────────┐
│ Column Name       │ Type       │ Notes│
├──────────────────────────────────────┤
│ id               │ BIGINT PK  │ Auto-increment
│ cart_id          │ BIGINT FK  │ carts.id
│ product_id       │ BIGINT FK  │ products.id
│ variant_id       │ BIGINT FK  │ product_variants.id (nullable)
│ quantity         │ INT        │ Qty in cart
│ price           │ DECIMAL    │ 19,2 - Price at add time
│ created_at       │ TIMESTAMP  │ Auto
│ updated_at       │ TIMESTAMP  │ Auto
└──────────────────────────────────────┘
```

**Foreign Keys:** 
- cart_id → carts.id (cascade delete)
- product_id → products.id (cascade delete)
- variant_id → product_variants.id (set null)

**Indexes:** cart_id, product_id

---

### 2.9 WISHLISTS TABLE
**Purpose:** Customer wishlist/saved items

```
Table: wishlists
┌──────────────────────────────────────┐
│ Column Name       │ Type       │ Notes│
├──────────────────────────────────────┤
│ id               │ BIGINT PK  │ Auto-increment
│ user_id          │ BIGINT FK  │ users.id
│ product_id       │ BIGINT FK  │ products.id
│ variant_id       │ BIGINT FK  │ product_variants.id (nullable)
│ created_at       │ TIMESTAMP  │ Auto
│ updated_at       │ TIMESTAMP  │ Auto
└──────────────────────────────────────┘
```

**Foreign Keys:**
- user_id → users.id (cascade delete)
- product_id → products.id (cascade delete)
- variant_id → product_variants.id (set null)

**Indexes:** user_id, product_id, (user_id, product_id) composite unique

---

### 2.10 ORDERS TABLE
**Purpose:** Order header information

```
Table: orders
┌──────────────────────────────────────┐
│ Column Name       │ Type       │ Notes│
├──────────────────────────────────────┤
│ id               │ BIGINT PK  │ Auto-increment
│ user_id          │ BIGINT FK  │ users.id
│ order_number     │ VARCHAR    │ Unique order ref
│ status           │ ENUM       │ pending, processing,
│                  │            │ shipped, delivered,
│                  │            │ cancelled, refunded
│ payment_status   │ ENUM       │ pending, completed,
│                  │            │ failed, refunded
│ subtotal         │ DECIMAL    │ 19,2 - Before tax/ship
│ tax_amount       │ DECIMAL    │ 19,2
│ shipping_cost    │ DECIMAL    │ 19,2
│ discount_amount  │ DECIMAL    │ 19,2 - From coupons
│ total_amount     │ DECIMAL    │ 19,2 - Final total
│ shipping_address │ TEXT       │ JSON format
│ billing_address  │ TEXT       │ JSON format
│ notes            │ TEXT       │ Special instructions
│ tracking_number  │ VARCHAR    │ Shipping tracking
│ created_at       │ TIMESTAMP  │ Auto
│ updated_at       │ TIMESTAMP  │ Auto
│ deleted_at       │ TIMESTAMP  │ Soft delete
└──────────────────────────────────────┘
```

**Foreign Keys:** user_id → users.id (cascade delete)
**Indexes:** user_id, order_number (unique), status, payment_status, created_at

---

### 2.11 ORDER_ITEMS TABLE
**Purpose:** Individual items in an order

```
Table: order_items
┌──────────────────────────────────────┐
│ Column Name       │ Type       │ Notes│
├──────────────────────────────────────┤
│ id               │ BIGINT PK  │ Auto-increment
│ order_id         │ BIGINT FK  │ orders.id
│ product_id       │ BIGINT FK  │ products.id
│ variant_id       │ BIGINT FK  │ product_variants.id (nullable)
│ product_name     │ VARCHAR    │ Snapshot of name
│ sku              │ VARCHAR    │ Snapshot of SKU
│ quantity         │ INT        │ Qty ordered
│ unit_price       │ DECIMAL    │ 19,2 - Price at order
│ total_price      │ DECIMAL    │ 19,2 - qty * unit_price
│ created_at       │ TIMESTAMP  │ Auto
│ updated_at       │ TIMESTAMP  │ Auto
└──────────────────────────────────────┘
```

**Foreign Keys:**
- order_id → orders.id (cascade delete)
- product_id → products.id (set null)
- variant_id → product_variants.id (set null)

**Indexes:** order_id, product_id

---

### 2.12 PAYMENTS TABLE
**Purpose:** Payment transaction tracking

```
Table: payments
┌──────────────────────────────────────┐
│ Column Name       │ Type       │ Notes│
├──────────────────────────────────────┤
│ id               │ BIGINT PK  │ Auto-increment
│ order_id         │ BIGINT FK  │ orders.id (unique)
│ payment_method   │ ENUM       │ 'card','upi','wallet'
│ amount           │ DECIMAL    │ 19,2
│ currency         │ VARCHAR    │ Default: 'INR'
│ transaction_id   │ VARCHAR    │ Payment gateway ref
│ status           │ ENUM       │ pending, completed,
│                  │            │ failed, refunded
│ gateway          │ VARCHAR    │ 'stripe','razorpay',etc
│ gateway_response │ JSON       │ Full gateway response
│ paid_at          │ TIMESTAMP  │ When paid
│ refund_amount    │ DECIMAL    │ 19,2 - If refunded
│ refunded_at      │ TIMESTAMP  │ When refunded
│ created_at       │ TIMESTAMP  │ Auto
│ updated_at       │ TIMESTAMP  │ Auto
└──────────────────────────────────────┘
```

**Foreign Keys:** order_id → orders.id (cascade delete, unique)
**Indexes:** order_id (unique), transaction_id (unique), status

---

### 2.13 REVIEWS TABLE
**Purpose:** Product reviews and ratings

```
Table: reviews
┌──────────────────────────────────────┐
│ Column Name       │ Type       │ Notes│
├──────────────────────────────────────┤
│ id               │ BIGINT PK  │ Auto-increment
│ product_id       │ BIGINT FK  │ products.id
│ user_id          │ BIGINT FK  │ users.id
│ order_item_id    │ BIGINT FK  │ order_items.id (nullable)
│ rating           │ INT        │ 1-5 stars
│ title            │ VARCHAR    │ Review title
│ comment          │ TEXT       │ Review content
│ is_verified_buy  │ BOOLEAN    │ Purchased from us
│ helpful_count    │ INT        │ Helpful votes
│ unhelpful_count  │ INT        │ Unhelpful votes
│ is_approved      │ BOOLEAN    │ Admin moderated
│ created_at       │ TIMESTAMP  │ Auto
│ updated_at       │ TIMESTAMP  │ Auto
│ deleted_at       │ TIMESTAMP  │ Soft delete
└──────────────────────────────────────┘
```

**Foreign Keys:**
- product_id → products.id (cascade delete)
- user_id → users.id (cascade delete)
- order_item_id → order_items.id (set null)

**Indexes:** product_id, user_id, is_approved, created_at, (product_id, user_id) unique

---

### 2.14 COUPONS TABLE
**Purpose:** Discount codes and promotional coupons

```
Table: coupons
┌──────────────────────────────────────┐
│ Column Name       │ Type       │ Notes│
├──────────────────────────────────────┤
│ id               │ BIGINT PK  │ Auto-increment
│ code             │ VARCHAR    │ Coupon code (unique)
│ description      │ TEXT       │ What coupon offers
│ discount_type    │ ENUM       │ 'percentage','fixed'
│ discount_value   │ DECIMAL    │ 19,2
│ max_discount     │ DECIMAL    │ 19,2 - Cap for %age
│ min_order_value  │ DECIMAL    │ 19,2 - Min purchase
│ max_usage        │ INT        │ Max global uses
│ per_user_limit   │ INT        │ Uses per customer
│ used_count       │ INT        │ Current usage
│ valid_from       │ DATETIME   │ Coupon start
│ valid_until      │ DATETIME   │ Coupon end
│ is_active        │ BOOLEAN    │ Default: true
│ created_at       │ TIMESTAMP  │ Auto
│ updated_at       │ TIMESTAMP  │ Auto
└──────────────────────────────────────┘
```

**Indexes:** code (unique), is_active, valid_from, valid_until

---

### 2.15 COUPON_ORDERS TABLE
**Purpose:** Track which coupons used on which orders (many-to-many)

```
Table: coupon_orders
┌──────────────────────────────────────┐
│ Column Name       │ Type       │ Notes│
├──────────────────────────────────────┤
│ id               │ BIGINT PK  │ Auto-increment
│ coupon_id        │ BIGINT FK  │ coupons.id
│ order_id         │ BIGINT FK  │ orders.id
│ discount_applied │ DECIMAL    │ 19,2 - Actual discount
│ created_at       │ TIMESTAMP  │ Auto
│ updated_at       │ TIMESTAMP  │ Auto
└──────────────────────────────────────┘
```

**Foreign Keys:**
- coupon_id → coupons.id (cascade delete)
- order_id → orders.id (cascade delete)

**Indexes:** (coupon_id, order_id) composite unique

---

### 2.16 NOTIFICATIONS TABLE
**Purpose:** System notifications for users

```
Table: notifications
┌──────────────────────────────────────┐
│ Column Name       │ Type       │ Notes│
├──────────────────────────────────────┤
│ id               │ BIGINT PK  │ Auto-increment
│ user_id          │ BIGINT FK  │ users.id
│ type             │ VARCHAR    │ Email, SMS, in-app
│ title            │ VARCHAR    │ Notification title
│ message          │ TEXT       │ Notification body
│ related_model    │ VARCHAR    │ Model name (Order, etc)
│ related_id       │ BIGINT     │ Related record ID
│ is_read          │ BOOLEAN    │ Default: false
│ read_at          │ TIMESTAMP  │ When read
│ created_at       │ TIMESTAMP  │ Auto
│ updated_at       │ TIMESTAMP  │ Auto
└──────────────────────────────────────┘
```

**Foreign Keys:** user_id → users.id (cascade delete)
**Indexes:** user_id, is_read, created_at

---

## 3. RELATIONSHIP DEFINITIONS

### 3.1 One-to-Many Relationships

| Parent Table | Child Table | Relationship | Behavior |
|---|---|---|---|
| users | customers | 1:1 (one user = one customer profile) | User deletes → Customer deleted |
| users | carts | 1:1 (one active cart per user) | User deletes → Cart deleted |
| users | orders | 1:Many (user has many orders) | User deletes → Orders deleted |
| users | reviews | 1:Many (user writes many reviews) | User deletes → Reviews deleted |
| users | wishlists | 1:Many (user has many wishlist items) | User deletes → Wishlists deleted |
| users | notifications | 1:Many (user receives many notifications) | User deletes → Notifications deleted |
| categories | products | 1:Many (category has many products) | Category deletes → Products deleted |
| categories | categories | 1:Many (parent-child hierarchy) | Parent deletes → Child categories deleted |
| products | product_images | 1:Many (product has many images) | Product deletes → Images deleted |
| products | product_variants | 1:Many (product has variants) | Product deletes → Variants deleted |
| products | reviews | 1:Many (product has many reviews) | Product deletes → Reviews deleted |
| products | cart_items | 1:Many (product in many carts) | Product deletes → Cart items deleted |
| orders | order_items | 1:Many (order has many line items) | Order deletes → Items deleted |
| orders | payments | 1:1 (one payment per order) | Order deletes → Payment deleted |

### 3.2 Many-to-Many Relationships

| Table 1 | Table 2 | Pivot Table | Purpose |
|---|---|---|---|
| carts | products | cart_items | Products in shopping cart |
| coupons | orders | coupon_orders | Track coupon usage per order |
| users | products | wishlists | Customer wishlist |

### 3.3 Has-Many-Through Relationships

| From | Through | To | Relationship |
|---|---|---|---|
| users | carts | products | User can see products in their cart |
| users | orders | products | User can see all products they ordered |
| categories | products | reviews | See reviews for all products in category |

---

## 4. DATA TYPE STANDARDS

### Decimal Fields
All monetary values use: `DECIMAL(19, 2)` for precision

### Timestamps
- `created_at` - Record creation time
- `updated_at` - Last modification time
- `deleted_at` - Soft delete timestamp (nullable)

### String Fields
- URLs/paths: `VARCHAR(255)`
- Codes/SKU/slugs: `VARCHAR(100)` with indexes
- Names/titles: `VARCHAR(255)`
- Descriptions: `TEXT`

### Boolean Fields
Default to `false` for safety

### JSON Fields
Used for:
- `product_variants.attributes` - Flexible variant options
- `orders.shipping_address` - Address data structure
- `orders.billing_address` - Address data structure
- `payments.gateway_response` - Full payment gateway response

---

## 5. INDEXING STRATEGY

### Composite Indexes (Performance)
- `carts(user_id)` - Unique, frequently queried
- `cart_items(cart_id, product_id)` - Common filter
- `wishlists(user_id, product_id)` - Prevent duplicates
- `orders(user_id, created_at)` - User order history
- `reviews(product_id, is_approved)` - Featured reviews
- `notifications(user_id, is_read)` - Unread notifications
- `coupon_orders(coupon_id, order_id)` - Prevent duplicate usage

### Foreign Key Indexes
All FK relationships automatically indexed

---

## 6. KEY DESIGN DECISIONS

### 1. **Soft Deletes**
Used on: `users`, `products`, `orders`, `reviews`
- Maintains data integrity
- Allows view/report restoration
- Keeps audit trail

### 2. **Denormalization**
- `carts.total_items`, `carts.total_price` - Faster cart display
- `products.rating` - Avoid recalculating reviews
- `order_items` stores product snapshots - Historical accuracy

### 3. **JSON Fields**
- `product_variants.attributes` - Flexible for different product types
- Address fields in orders - Accommodate different formats globally

### 4. **User Role Management**
- Single users table with `role` ENUM
- Separate `customers` table for customer-specific data
- Admins don't have customer profile

### 5. **Cart Management**
- Separate cart and cart_items tables
- `abandoned_at` timestamp - Identify abandoned carts for recovery
- Clear separation from orders

### 6. **Order Snapshots**
- `order_items` stores product name, SKU, price - Immutable historical data
- Product changes don't affect past order records

### 7. **Coupon Flexibility**
- Supports both percentage and fixed discounts
- Per-user and global limits
- Min order threshold for validity

### 8. **Notification System**
- Generic table supporting multiple notification types
- `related_model` and `related_id` for polymorphic relationships
- Tracks read status with timestamp

---

## 7. CONSTRAINTS & VALIDATIONS

### Unique Constraints
- `users.email` - One account per email
- `products.slug` - SEO-friendly URLs
- `products.sku` - Product identification
- `product_variants.sku` - Variant identification
- `categories.slug` - Category URLs
- `coupons.code` - Coupon code
- `orders.order_number` - Order reference
- `payments.transaction_id` - Payment gateway reference

### Check Constraints (if supported)
- `products.price >= 0`
- `products.stock_quantity >= 0`
- `reviews.rating BETWEEN 1 AND 5`
- `orders.total_amount >= 0`
- `payments.amount > 0`

### Foreign Key Cascading
- **CASCADE** - Categories, Products, Images, Variants (parent deletion removes children)
- **SET NULL** - Optional references like review.order_item_id (preserve reviews if item deleted)

---

## 8. SCALABILITY CONSIDERATIONS

### Partitioning Strategy (Future)
- `orders` - Partition by `created_at` (monthly/yearly)
- `order_items` - Partition by `order_id` range
- `reviews` - Partition by `created_at` for archival

### Archive Strategy
- Archive old orders (> 2 years) - Improves query performance
- Keep reviews indefinitely - SEO value
- Archive abandoned carts - Reduce table size

### Backup Strategy
- Full backup before schema changes
- Incremental backups daily
- Test restore procedures regularly

---

## SUMMARY

This database design provides:
✅ Clean MVC architecture alignment
✅ Comprehensive e-commerce functionality
✅ Data integrity through FK constraints
✅ Flexibility through JSON fields
✅ Performance through strategic indexing
✅ Scalability through partitioning planning
✅ Audit trail through soft deletes
✅ Historical accuracy through snapshots

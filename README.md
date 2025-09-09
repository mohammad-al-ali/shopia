# 🛒 SHOPIA – Laravel E-Commerce Platform

SHOPIA is a full-featured e-commerce web application built with **Laravel 12**.  
It provides a robust shopping experience for customers and a powerful dashboard for administrators.  
The project is designed with **clean architecture principles** to ensure scalability, maintainability, and readability.

---
## 🤖 AI Shopping Assistant

SHOPIA includes a built-in **AI Assistant** powered by **GPT-3.5** and trained on the store’s product database.  
This assistant enhances the shopping experience by:

- Helping customers find products that match their needs and preferences
- Comparing multiple products and providing clear recommendations
- Keeping chat history so users don’t lose previous conversations
- Generating direct links to product detail pages for quick navigation

This integration makes the store more interactive, reduces user confusion when choosing between similar products, and improves overall customer satisfaction.
---

## 🚀 Features

### 👥 Customer Features
- Browse products with advanced filtering (categories, brands, price, etc.).
- View detailed product pages with images and descriptions.
- Add/update/remove items from the cart.
- Apply/remove discount coupons at checkout.
- Complete checkout with order confirmation.
- Secure checkout with multiple payment methods(PayPal , Cash on Delivery).
- Contact form with email notifications to admin.

### 🛠️ Admin Features
- Dashboard with order statistics and monthly revenue summaries
- Manage products (CRUD)
- Manage categories and brands (CRUD)
- Manage slides/banners (CRUD)
- Manage coupons (CRUD)
- View and manage orders (update status, filter by payment mode)
- View customer contact messages

---

## 🏗️ Architecture

The project follows **best practices** in Laravel development:

- **MVC (Model–View–Controller)** for structured code organization
- **Repository Pattern** for abstracting database queries and ensuring testability
- **Service Layer** for handling business logic and keeping controllers lightweight

This architecture ensures **scalability** and allows easy integration of new features such as product reviews, 5-star ratings, and real-time notifications.

---

## 📂 Controllers Overview

- **AdminController** → Handles dashboard statistics and monthly reports
- **BrandController** → Manage brands (CRUD)
- **CartController** → Shopping cart operations (add, update, delete, clear)
- **CategoryController** → Manage categories (CRUD)
- **CheckoutController** → Validate cart and process checkout
- **ContactController** → Store contact messages and notify admin via email
- **CouponController** → Manage coupons (CRUD + apply/remove at checkout)
- **OrderController** → Manage orders (both admin and customer views)
- **ProductController** → Manage products (CRUD + show details on frontend)
- **ShopController** → Display shop page with filtering (categories, brands, etc.)
- **SlideController** → Manage homepage slides/banners

---

🛠️ Tech Stack

Framework: Laravel 12 (PHP 8.2)

Database: MySQL

Frontend: Laravel UI + Bootstrap



---

⚙️ Requirements

PHP >= 8.2

Composer: 2.8.8

Node.js: 22.14.0

NPM: 11.5.2

---
## 📂 Installation

1. Clone the repository
   ```bash
   git clone https://github.com/mohammad-al-ali/shopia.git
   cd shopia

2. Install dependencies
   ```bash
   composer install
   npm install && npm run build

3. Create .env file and configure database & mail settings
   ```bash
   cp .env.example .env
   php artisan key:generate

4. Run migrations and seed database
   ```bash
   php artisan migrate --seed
5. Start development server
   ```bash
   php artisan serve
---

📌 Future Enhancements

⭐ Product Reviews & Ratings (5-star system)

🔔 Real-time Notifications (Admin & Customer)

📦 Inventory tracking

📊 Sales analytics dashboard



---

👤 Author

Muhammad AlAli

📧 Email: mhmdalrab6@gmail.com

🌐 LinkedIn: linkedin.com/in/MuhammadAlAli

💻 GitHub: github.com/mohammad-al-ali


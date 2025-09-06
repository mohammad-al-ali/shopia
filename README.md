# 🛒 SHOPIA

SHOPIA is a **full-featured e-commerce platform** built with Laravel 12 and MySQL.  
It provides a smooth shopping experience for customers and powerful management tools for administrators.

The project also integrates an **AI Shopping Assistant**, trained on the store’s product database, which helps users discover, compare, and choose the right products.

---

## 🚀 Features

- **Authentication & Security**
    - User authentication with **Laravel Sanctum**
    - Secure login & registration

- **Product Management**
    - Product catalog with categories
    - Add, update, delete products
    - Product images with **Intervention Image**

- **Shopping Cart & Orders**
    - Full shopping cart functionality with **SurfsideMedia/ShoppingCart**
    - Order management system
    - Checkout flow

- **AI Assistant 🤖**
    - Integrated with GPT-3.5
    - Recommends and compares products
    - Provides personalized shopping experience

- **Notifications**
    - Email notifications with **Symfony Mailer**
    - Admin gets notified of new contact messages

- **Contact With Us**
    - Form with name, email, phone, and message
    - Stores messages in DB and sends admin notifications

---

## 🛠️ Tech Stack

- **Framework**: Laravel 12 (PHP 8.2)
- **Database**: MySQL
- **Frontend**: Laravel UI + Bootstrap
- **Packages**:
    - Laravel Sanctum
    - Fruitcake/laravel-cors
    - GuzzleHTTP
    - Intervention Image
    - SurfsideMedia/ShoppingCart
    - Symfony Mailer

---

## 📂 Installation

1. Clone the repository
   ```bash
   git clone https://github.com/your-username/shopia.git
   cd shopia

# Ecom-Management System

📌 Project Overview

Ecom-Management System is a web-based application built using Laravel and PHP that allows admins to manage products, categories, orders, and users efficiently. The system includes authentication, sales reports, and data filtering to streamline e-commerce operations.

🚀 Features

- **Product Management:** Add, edit, delete, and filter products.
- **Category Management:** Organize products into categories.
- **Sales Report:** Track sales report.
- **User Authentication:** Secure login and registration with "Remember Me" functionality.
- **Sales Reports:**
  - Daily Sales
  - Weekly Sales
  - Monthly Sales
  - Yearly Sales
- **Media Uploads:** Upload product images and manage them efficiently.
- **Role-Based Access Control (RBAC):** Restrict admin and user functionalities.

🛠️ Tech Stack

- **Backend:** Laravel 11, PHP 8+
- **Frontend:** Bootstrap, Tailwind CSS, JavaScript (AJAX, jQuery)
- **Database:** MySQL
- **Authentication:** Laravel Breeze
- **Storage:** Laravel Filesystem (public disk for images)

📺 Dependencies

Before installing the project, ensure you have the following dependencies installed:

- **PHP** (>=8.0)
- **Composer** (Latest version)
- **Node.js** (>=16.x)
- **NPM** (Latest version)
- **MySQL** (or any compatible database)

📂 Installation Guide

1️⃣ Clone the Repository

```sh
git clone https://github.com/Logesh2802/ecom-management-system.git
cd ecom-management-system
```

2️⃣ Install Dependencies

```sh
composer install
npm install 
npm run dev
npm run build
```

3️⃣ Configure Environment

Copy `.env.example` to `.env`

```sh
cp .env.example .env
```

Update database credentials and storage settings in `.env`.

4️⃣ Generate App Key

```sh
php artisan key:generate
```

5️⃣ Run Migrations & Seeders

```sh
php artisan migrate --seed
```

6️⃣ Serve the Application

```sh
php artisan serve
```

7️⃣ Access the App

Open [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser.

🔒 Authentication

**Default Admin Login:**

```sh
Email: admin@example.com
Password: password123
```


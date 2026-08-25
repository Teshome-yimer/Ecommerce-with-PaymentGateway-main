# 🛍️ Modern E-Commerce Platform with Midtrans Payment Gateway & Filament Admin

[![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Filament](https://img.shields.io/badge/Filament_PHP-v3-FDAE4B?style=for-the-badge&logo=laravel&logoColor=black)](https://filamentphp.com)
[![Midtrans](https://img.shields.io/badge/Payment-Midtrans_Gateway-005B9C?style=for-the-badge)](https://midtrans.com)
[![License](https://img.shields.io/badge/License-MIT-blue.svg?style=for-the-badge)](LICENSE)

A feature-complete, modern E-Commerce web application built with **Laravel 10**, **Filament v3 Admin Panel**, and **Midtrans Payment Gateway**. This application provides a seamless shopping experience for customers and a powerful management interface for store administrators, including automated PDF invoice generation, real-time payment webhook notifications, Cloudinary image management, and role-based access control.

---

## ✨ Features Overview

### 🛒 Customer Storefront

- **Dynamic Product Catalog**: Browse products with search, category filtering, and sorting.
- **Interactive Shopping Cart & Checkout**: Smooth add-to-cart experience with real-time total calculations.
- **Multi-Channel Payment Options**: Integrated with Midtrans API supporting Credit/Debit Cards, Virtual Accounts (BCA, BNI, BRI), and E-Wallets (GoPay, OVO, DANA).
- **Order History & Real-Time Tracking**: Track order status (Pending, Processing, Completed, Cancelled) and payment states.
- **📄 Downloadable PDF Invoices**: View and download professional PDF invoices generated on-the-fly using `barryvdh/laravel-dompdf`.
- **Social Login & Auth**: Authentication via standard credentials or Socialite integrations.

### 🛡️ Admin Dashboard (Filament PHP v3)

- **Comprehensive Analytics & Dashboard**: Monitor sales, total revenue, order counts, and customer activities.
- **Order Management System**: View order details, update shipping/fulfillment statuses, and issue invoice prints.
- **Catalog Management**: Full CRUD operations for Products, Brands, and Categories.
- **Role & Permission Management**: Powered by `spatie/laravel-permission` for fine-grained Admin and Customer access control.

### ⚡ Technical Highlights

- **Cloud Image Storage**: Powered by Cloudinary for scalable product media hosting.
- **Docker & Cloud Ready**: Pre-configured `Dockerfile`, `docker-compose.yml`, and `render.yaml` for instant cloud deployment.
- **Automated Webhooks**: Midtrans payment status callback handler for automatic payment verification.

---

## 🛠️ Tech Stack & Dependencies

- **Framework**: [Laravel 10.x](https://laravel.com)
- **Admin Panel**: [Filament PHP v3](https://filamentphp.com)
- **Payment Gateway**: [Midtrans PHP SDK](https://github.com/Midtrans/midtrans-php)
- **PDF Generation**: [Laravel DomPDF](https://github.com/barryvdh/laravel-dompdf)
- **Image Cloud Storage**: [Cloudinary Laravel](https://github.com/cloudinary-labs/cloudinary-laravel)
- **Roles & Permissions**: [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- **Authentication**: Laravel UI / Sanctum / Socialite

---

## 🚀 Getting Started

Follow these instructions to set up and run the project locally on your machine.

### 📋 Prerequisites

Ensure you have the following installed on your system:

- **PHP** `>= 8.1` with `intl`, `pdo_mysql`, `gd`/`imagick` extensions enabled
- **Composer** `>= 2.x`
- **Node.js** `>= 18.x` & **NPM**
- **MySQL / MariaDB** database engine

---

### 💻 Installation Steps

1. **Clone the Repository**

   ```bash
   git clone https://github.com/Teshome-yimer/Ecommerce-with-PaymentGateway-main.git
cd Ecommerce-with-PaymentGateway-main

   ```

2. **Install PHP Dependencies**

   ```bash
   composer install
   ```

3. **Install & Build Frontend Assets**

   ```bash
   npm install
   npm run build
   ```

4. **Environment Setup**
   Copy the `.env.example` file to create your `.env` configuration file:

   ```bash
   cp .env.example .env
   ```

   Generate the Laravel Application Key:

   ```bash
   php artisan key:generate
   ```

5. **Configure Database Connection**
   Open `.env` and set your database connection settings:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ecommerce_db
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

6. **Run Database Migrations & Seeders**
   Run the migrations and seed demo catalog & default users:

   ```bash
   php artisan migrate --seed
   ```

7. **Create Storage Link**
   Link the public storage directory:

   ```bash
   php artisan storage:link
   ```

8. **Start Development Server**

   ```bash
   php artisan serve
   ```

   Access the store in your browser at `http://127.0.0.1:8000`.

---

## 🔑 Default Credentials

The database seeders generate default accounts for testing:

| Role | Email | Password | Access URL |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin@admin.com` | `password` | `http://127.0.0.1:8000/admin` |
| **Test User** | `user@test.com` | `password` | `http://127.0.0.1:8000/login` |

---

## 💳 Midtrans Payment Gateway Setup

To enable online payments in Sandbox/Development mode:

1. Obtain your keys from the [Midtrans Sandbox Dashboard](https://dashboard.sandbox.midtrans.com).
2. Add your Midtrans credentials to `.env`:

   ```env
   MIDTRANS_SERVER_KEY=SB-Mid-server-YOUR_SERVER_KEY
   MIDTRANS_CLIENT_KEY=SB-Mid-client-YOUR_CLIENT_KEY
   MIDTRANS_IS_PRODUCTION=false
   MIDTRANS_IS_SANITIZED=true
   MIDTRANS_IS_3DS=true
   ```

3. For local webhook testing, use **ngrok** to expose your server:

   ```bash
   ngrok http 8000
   ```

   Set the Notification URL in Midtrans Dashboard to:
   `https://<your-ngrok-id>.ngrok.io/midtrans/notification`

---

## 📄 PDF Invoice Feature

- **Customer View**: Customers can view and download PDF invoices directly from the checkout success page or order history (`/invoice/{order_id}/download`).
- **Admin Access**: Administrators can generate and print customer invoices directly from the Filament Admin panel.
- **Security Check**: Access to invoices is protected so users can only download invoices belonging to their own account.

---

## 🐳 Docker Deployment (Optional)

You can run the entire application environment using Docker:

```bash
# Build and run containers
docker-compose up -d --build

# Run migrations inside the app container
docker-compose exec app php artisan migrate --seed
```

---

## 📂 Project Structure Overview

```
├── app/
│   ├── Http/Controllers/   # Application Controllers (Checkout, Invoice, Payment)
│   ├── Models/             # Eloquent Models (Product, Order, User, Category)
│   └── Providers/          # Service Providers
├── config/                 # Application Configuration Files
├── database/
│   ├── migrations/         # Database Table Migrations
│   └── seeders/            # Demo Data & Role Seeders
├── public/                 # Web Root & Compiled Assets
├── resources/
│   ├── views/              # Blade UI Templates (Invoice, Customer Storefront)
├── routes/
│   ├── web.php             # Web Routes & Midtrans Callback Endpoints
│   └── api.php             # API Endpoints
└── storage/                # PDF Generation Output & Logs
```

---

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!  
Feel free to check out the [issues page](https://github.com/Teshome-yimer/Ecommerce-with-PaymentGateway-main).

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📝 License

Distributed under the **MIT License**. See [`LICENSE`](LICENSE) for more information.

---

<p align="center">Made with ❤️ for Seamless E-Commerce & Payment Gateway Integration</p>

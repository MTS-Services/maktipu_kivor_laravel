# 🛍️ Luisacuna Marketplace

## Project Overview

Luisacuna Marketplace is a modern, secure, and feature-rich e-commerce platform designed to facilitate the buying and selling of digital goods. It provides dedicated, optimized experiences for multiple user roles, robust administrative control, and full internationalization support, including multi-currency and various digital payment/withdrawal methods.

The platform is built for speed, security, and scalability using the latest PHP ecosystem tools.

## Key Features & Functionality

### 1. Multi-Role User Panels

The marketplace is designed to serve distinct user needs through dedicated panels:

* **Seller Panel:** Tools for listing products, managing inventory, tracking sales, and managing withdrawal requests.

* **Buyer Panel:** Features for browsing, purchasing, order tracking, and managing account details.

* **Guest Access:** Supports guest browsing and potential limited checkout capabilities.

### 2. Secure & Modern Admin Dashboard

A centralized and highly secure dashboard provides complete oversight and control:

* **Full Control:** Manage users, products, categories, transactions, and system settings.

* **Monitoring:** Real-time analytics and monitoring tools to track sales performance, user activity, and system health.

* **Modern UI:** Built with a modern, responsive, and intuitive interface for optimal administrative efficiency.

### 3. Products & Digital Goods

The platform specializes in the sale and purchase of various digital items:

* 🎮 Games

* 🔑 Passes / Subscriptions

* 🎁 Gift Cards

* 💡 And many other types of digital assets.

### 4. Internationalization & Finance

The platform is built to operate globally with flexible financial options:

* **Multi-Language Support:** The primary language is **English**, with support for multiple secondary languages to cater to a global user base.

* **Multi-Currency Support:** Handles transactions in various fiat (country-specific) currencies as well as digital currencies like **Bitcoin** and other cryptocurrencies.

* **Multiple Withdrawal Methods:** Sellers can easily withdraw their earnings through diverse and secured payment gateways, including:

  * Stripe

  * PayPal

  * Various crypto withdrawal platforms

## Technology Stack

Luisacuna Marketplace leverages a cutting-edge, highly secure, and efficient technology stack:

| **Category** | **Technology** | **Version / Use** |
| :--- | :--- | :--- |
| **Backend** | **PHP** | `v8.3` (Latest stable and secure version) |
| **Framework** | **Laravel** | `v12` (Latest, most secure major version) |
| **Interactivity** | **Livewire** | `v3` (Used as the core "Starter Kit" for dynamic interfaces) |
| **Styling/UI** | **Tailwind CSS** | Utility-first CSS framework for rapid development. |
| **UI Components** | **Daisy UI** & **Flux** | Component libraries built on Tailwind for a cohesive and aesthetic design. |
| **Icons** | **Heroicons** & **Lucide** | A comprehensive set of modern, clear icons for the application interface. |
| **Packages** | Other essential Laravel/PHP packages for payment, security, and localization. | |

## Installation & Setup

Follow these steps to set up and run the Luisacuna Marketplace project on your local machine.

### Prerequisites

Ensure you have the following software installed:

* **PHP:** Version `8.3` or higher

* **Composer:** Latest version

* **Node.js & npm:** Latest LTS version (for compiling frontend assets)

* **Database:** MySQL, PostgreSQL, or SQLite (configured in `.env`)

### Step 1: Clone the Repository

Clone the project repository to your local system and navigate into the directory:

```bash
git clone [https://github.com/luisacuna/marketplace.git](https://github.com/luisacuna/marketplace.git)
cd marketplace
```

Step 2: Configure Environment
Create your environment configuration file by copying the example:

```bash
cp .env.example .env
```

Now, open the newly created .env file and update the database credentials (DB_* variables), application URL (APP_URL), and any third-party service keys (e.g., Stripe, PayPal, Crypto Platform API keys) as needed.

### Step 3: Install Dependencies
Install the backend (PHP) dependencies using Composer and the frontend (JavaScript/CSS) dependencies using npm:

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```
### Step 4: Generate Application Key and Compile Assets
Generate a unique application key and link the public storage directory. Then, compile the Tailwind CSS (including Daisy UI and Flux) and Livewire assets:

```bash
# Generate application key
php artisan key:generate

# Link storage directory
php artisan storage:link

# Compile frontend assets
npm run build
```

### Step 5: Run Migrations and Seeding
Run the database migrations to create the necessary tables and use the seeders to populate the database with initial data (e.g., categories, initial admin user):

```bash
php artisan migrate --seed
```

### Step 6: Start the Local Server
Start the Laravel development server. The application will typically be accessible at http://127.0.0.1:8000.

```bash
php artisan serve
```
You should now be able to access and test the Luisacuna Marketplace locally!
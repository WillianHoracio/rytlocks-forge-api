# 🔥 Rytlock’s Forge API 🔥

> **⚠️ This project is a work in progress. Features and APIs are subject to change.**

Backend Laravel 11 to track legendary weapon progress in Guild Wars 2.

---

## 🗺️ Roadmap

You can follow the project's progress on the [Project Board](https://github.com/users/WillianHoracio/projects/2).

---

## 🚀 Features

- 🔑 Authentication via GW2 API Key  
- 🗃 Inventory, armory, and wallet queries  
- 🛠 Legendary roadmap management  
- ⚡ REST endpoints for React frontend

---

## 🛠 Technologies

- Laravel 11 (PHP 8.2+)  
- MySQL / PostgreSQL  
- Sanctum for authentication (planned)  

---

## ⚡ Getting Started

```bash
# Clone the repository
git clone https://github.com/YOUR-USERNAME/rytlocks-forge-api.git
cd rytlocks-forge-api

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Configure database in .env

# Run migrations
php artisan migrate

# Start the server
php artisan serve

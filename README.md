# Offer & Codes Management System

A Laravel-based dashboard for managing shops, offers, and promotional codes with usage tracking, exports, and OTP-based offer retrieval.

---

## Features

- Admin dashboard
- Shops management
- Offers & promo codes management
- Code usage tracking
- OTP phone verification
- PDF & Excel exports
- Multi-language support (EN / AR)
- Activity logs

---

## Requirements

- PHP >= 8.1
- Composer
- MySQL / MariaDB
- Node.js & NPM
- Git

---

## Installation

### 1. Clone Repository

```bash
git clone https://github.com/HossamSoliuman/Coupons-Management
cd Coupons-Management
````

### 2. Install Dependencies

```bash
composer install
npm install
npm run build
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Update database credentials inside `.env`.

### 4. Run Migrations & Seeders

```bash
php artisan migrate --seed
```

This creates the default admin account automatically.

### 5. Storage Link

```bash
php artisan storage:link
```

### 6. Run Application

```bash
php artisan serve
```

Open:

```
http://127.0.0.1:8000
```

---

## Default Admin Login

```
Email: admin@gmail.com
Password: password
```

---

## Main Modules

* **Dashboard** — statistics and charts
* **Shops** — manage partner shops
* **Codes** — manage promotional codes
* **Offers** — attach offers to codes
* **Exports** — PDF & Excel reports
* **OTP API** — phone verification & offer retrieval
* **Logs** — system activity tracking

---

## License

MIT License

```
```

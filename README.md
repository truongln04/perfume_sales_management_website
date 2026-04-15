# 🌸 WEBSITE QUẢN LÝ BÁN NƯỚC HOA (LARAVEL THUẦN)

## 📖 Giới thiệu
Hệ thống Quản lý Bán Nước Hoa là ứng dụng web thương mại điện tử được xây dựng bằng Laravel thuần.

Hệ thống hỗ trợ quản lý toàn diện hoạt động kinh doanh nước hoa, bao gồm sản phẩm, đơn hàng, kho, khách hàng và thanh toán.

---

## 🎯 Mục tiêu
- Xây dựng website bán hàng hoàn chỉnh
- Áp dụng mô hình MVC
- Quản lý dữ liệu hiệu quả với MySQL
- Tích hợp thanh toán MOMO
- Dễ mở rộng và bảo trì

---

## 👥 Người dùng

### Khách hàng
- Xem và tìm kiếm sản phẩm
- Thêm vào giỏ hàng, đặt hàng
- Thanh toán COD hoặc MOMO
- Theo dõi đơn hàng

### Nhân viên
- Quản lý sản phẩm
- Quản lý kho
- Xử lý đơn hàng

### Quản trị viên
- Quản lý toàn bộ hệ thống
- Quản lý tài khoản
- Quản lý sản phẩm, đơn hàng
- Xem báo cáo

---

## 🛠️ Công nghệ
- PHP
- Laravel
- Blade Template
- MySQL
- Apache
- MOMO API

---

## ⚙️ Cài đặt

### Yêu cầu
- PHP >= 8.0
- Composer >= 2.x
- MySQL

---

### Cài đặt project

```bash
git clone https://github.com/truongln04/perfume_sales_management_website.git
cd perfume_sales_management_website
composer install
cp .env.example .env
php artisan key:generate
```

### Cấu hình .env

```env
APP_NAME=PerfumeStore
APP_ENV=local
APP_KEY=base64:xxxx
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=perfume_store
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

### Chạy database

```bash
php artisan migrate --seed
```

---

## 🚀 Chạy ứng dụng

```bash
php artisan serve
```

Truy cập: http://localhost:8000

---

## 🧩 Chức năng

- Quản lý tài khoản (Admin / Nhân viên / Khách hàng)
- Quản lý sản phẩm
- Quản lý danh mục, thương hiệu
- Quản lý nhà cung cấp
- Quản lý kho
- Giỏ hàng
- Thanh toán (COD, MOMO)
- Quản lý đơn hàng
- Quản lý phiếu nhập
- Báo cáo & thống kê

---

## 💳 Thanh toán
- COD (Thanh toán khi nhận hàng)
- MOMO (Thanh toán online)

---


## 📬 Liên hệ
- Tác giả: Nhóm 20
- GitHub: https://github.com/truongln04

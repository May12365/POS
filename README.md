# 🛒 POS System (Learnventory Hub)
### ระบบ Point of Sale (POS) สำหรับจัดการสินค้า การขาย และสต็อกสินค้า พัฒนาด้วย PHP + MySQL เหมาะสำหรับร้านค้าขนาดเล็กถึงกลาง
![GitHub repo size](https://img.shields.io/github/repo-size/May12365/TypingTestGame)
![GitHub stars](https://img.shields.io/github/stars/May12365/TypingTestGame?style=social)
![GitHub forks](https://img.shields.io/github/forks/May12365/TypingTestGame?style=social)

---

## 📌 Overview

โปรเจคนี้เป็นระบบ POS ที่พัฒนาขึ้นเพื่อ:

* จัดการสินค้า (CRUD)
* จัดการหมวดหมู่สินค้า
* บันทึกการขายสินค้า
* แสดงรายงานการขาย
* รองรับการใช้งานแบบ Role-based (Admin / Staff)

---

## 🚀 Features

### 👤 Authentication & Authorization

* Login / Logout
* Session-based authentication
* แยกสิทธิ์การใช้งาน:

  * **Admin** → จัดการสินค้า / หมวดหมู่ / รายงาน/ ขายสินค้า
  * **Staff** → ขายสินค้า

---

### 📦 Product Management (CRUD)

* เพิ่มสินค้า
* แก้ไขสินค้า
* ลบสินค้า
* จัดหมวดหมู่สินค้า
* แสดงรายการสินค้าแบบตาราง

---

### 📂 Category Management

* เพิ่ม / แก้ไข / ลบหมวดหมู่
* เชื่อมโยงสินค้าเข้ากับหมวดหมู่

---

### 🛒 Sales System

* เลือกสินค้าเพื่อขาย
* คำนวณราคาอัตโนมัติ
* บันทึกข้อมูลการขายลงฐานข้อมูล

---

### 📊 Sales Report

* แสดงรายงานยอดขาย
* แสดงข้อมูลต่อใบเสร็จ

---

## 📸 Screenshots
### Registration
![Dashboard](gif/register.gif)

---

### Login
![Dashboard](gif/login.gif)

---

### Sell
![Dashboard](gif/sell.gif)

---

### Manage Products
![Dashboard](gif/manage_products.gif)

---

### Edit Products
![Dashboard](gif/edit_products.gif)

---

### Manage Categories
![Dashboard](gif/manage_categories.gif)

---

### Sell Report
![Dashboard](gif/seles_report.gif)

---
### Logout
![Dashboard](gif/logout.gif)

---

## 🧑‍💻 Tech Stack

| Layer    | Technology       |
| -------- | ---------------- |
| Frontend | HTML, CSS        |
| Backend  | PHP (Procedural) |
| Database | MySQL / MariaDB  |
| Server   | Apache (XAMPP)   |

---
## 📦 Project Structure

```bash
POS/
│
├── db.php                 # ไฟล์เชื่อมต่อฐานข้อมูล (MySQL)
├── index.php              # หน้าแรกหลัง login (Dashboard)
├── login.php              # หน้าเข้าสู่ระบบ
├── logout.php             # ออกจากระบบ (destroy session)
│
├── manage_products.php    # จัดการสินค้า (แสดง / เพิ่ม / ลบ)
├── edit_product.php       # แก้ไขข้อมูลสินค้า
│
├── manage_categories.php  # จัดการหมวดหมู่สินค้า
│
├── sell.php               # หน้าขายสินค้า (POS)
├── sales_report.php       # รายงานยอดขาย
│
├── css/                   # (ถ้ามี) ไฟล์ CSS แยก
│   └── style.css
│
├── assets/                # รูปภาพ / icon / ไฟล์ static
│
├── database/              # ไฟล์ SQL
│   └── pos_db.sql
│
└── README.md              # เอกสารโปรเจค
```

---

### 🧠 อธิบายโครงสร้าง

* **db.php**
  ใช้สำหรับเชื่อมต่อฐานข้อมูล (ควรแยกเพื่อ reuse)

* **auth (login/logout)**
  ใช้ session ในการจัดการผู้ใช้งาน

* **manage_products.php / edit_product.php**
  จัดการ CRUD ของสินค้า

* **manage_categories.php**
  จัดการหมวดหมู่ (สัมพันธ์กับ Product)

* **sell.php**
  เป็น core ของระบบ POS สำหรับขายสินค้า

* **sales_report.php**
  แสดงข้อมูลการขายในรูปแบบรายงาน

* **database/**
  เก็บไฟล์ SQL สำหรับ import

---

## 🗄️ Database Structure

### Tables หลัก:

* `Product` → เก็บข้อมูลสินค้า
* `Categories` → หมวดหมู่สินค้า
* `Users` → ผู้ใช้งานระบบ
* `Sales` → ข้อมูลการขาย

### Relationship:

* Product → Categories (Many-to-One)

---

## ⚙️ Installation

### 1. Clone Project

```bash
git clone https://github.com/your-username/pos-system.git
```

---

### 2. Setup Database

* เปิด phpMyAdmin
* สร้าง database ใหม่ เช่น `pos_db`
* Import ไฟล์ `.sql`

---

### 3. Config Database

แก้ไขไฟล์:

```php
db.php
```

```php
$conn = new mysqli("localhost", "root", "", "pos_db");
```

---

### 4. Run Project

* เปิด XAMPP (Apache + MySQL)
* เข้า:

```
http://localhost/POS/
```

---

## 🔐 Default User (ตัวอย่าง)

| Role  | Username | Password |
| ----- | -------- | -------- |
| Admin | admin    | 1234     |
| Staff | staff    | 1234     |

---

## 🔮 Future Improvements
* ✅ ใช้ Prepared Statement (Security)
* ✅ เพิ่มระบบ Upload รูปสินค้า
* ✅ ทำ UI ด้วย Bootstrap / Tailwind
* ✅ แยก MVC Structure
* ✅ เพิ่ม Dashboard (Chart / Analytics)

---

## 📜 License

This project is created for **educational and portfolio purposes**.

---

## 👤 Author

* GitHub: https://github.com/May12365
---

---

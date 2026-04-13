<?php
session_start(); // เริ่มต้น session เพื่อใช้ตรวจสอบผู้ใช้

include 'db.php'; // เรียกไฟล์เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่า login และเป็น admin หรือไม่
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php"); // ถ้าไม่ใช่ให้กลับหน้า index
    exit(); // หยุดการทำงาน
}

// ตรวจสอบว่ามีการส่ง p_ID มาหรือไม่
if (!isset($_GET['p_ID'])) {
    header("Location: manage_products.php"); // ถ้าไม่มีให้กลับหน้าจัดการสินค้า
    exit();
}

$p_ID = $_GET['p_ID']; // รับค่า ID สินค้า

// ดึงข้อมูลสินค้าจากฐานข้อมูลตาม p_ID
$product = $conn->query("SELECT * FROM Product WHERE p_ID='$p_ID'")->fetch_assoc();
// ดึงหมวดหมู่ใหม่สำหรับฟอร์ม

$categories2 = $conn->query("SELECT * FROM Categories");
// เมื่อมีการ submit form (POST)


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // รับค่าจาก form
    $p_name = $_POST['p_name'];   // ชื่อสินค้า
    $p_detail = $_POST['p_detail']; // รายละเอียดสินค้า
    $p_price = $_POST['p_price']; // ราคา
    $p_total = $_POST['p_total']; // จำนวนสินค้า
    $c_ID = $_POST['c_ID'];//หมวดหมู่สินค้า

    // คำสั่ง SQL สำหรับอัปเดตข้อมูลสินค้า
    $sql = "UPDATE Product 
        SET p_name='$p_name', 
            p_detail='$p_detail', 
            p_price='$p_price', 
            p_total='$p_total',
            c_ID='$c_ID'
        WHERE p_ID='$p_ID' ";

    $conn->query($sql); // รันคำสั่ง SQL

    header("Location: manage_products.php"); // redirect กลับหน้าจัดการสินค้า
    exit(); // หยุดการทำงาน
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Product</title>

    <style>
        .wrapper {
            display: flex;
            /* ใช้ flexbox */
            justify-content: center;
            /* จัดกลางแนวนอน */
            align-items: baseline;
            /* จัดกลางแนวตั้ง */
            height: 100vh;
            /* สูงเต็มหน้าจอ */
        }

        /* =========================
           BODY (พื้นหลัง)
        ========================= */
        body {
            background: linear-gradient(to right, #769FCD, #B9D7EA);
            /* ไล่สีพื้นหลัง */
            margin: 0;
            /* ลบ margin เริ่มต้น */
            font-family: Arial, sans-serif;
            /* ฟอนต์ */
        }

        /* =========================
           ปุ่มกลับ
        ========================= */
        .back-home {
            position: absolute;
            /* วางตำแหน่งแบบลอย */
            top: 18px;
            /* ห่างจากด้านบน */
            right: 20px;
            /* ห่างจากด้านขวา */
            padding: 8px 15px;
            /* ระยะห่างในปุ่ม */
            border: 2px solid #0D4C92;
            /* เส้นขอบ */
            border-radius: 5px;
            /* มุมโค้ง */
            background-color: white;
            /* สีพื้น */
            color: #0D4C92;
            /* สีตัวอักษร */
            font-weight: bold;
            /* ตัวหนา */
            text-decoration: none;
            /* เอาเส้นใต้ลิงก์ออก */
            transition: 0.3s;
            /* ทำให้ hover ลื่น */
        }

        /* เมื่อ hover ปุ่ม */
        .back-home:hover {
            background-color: #0D4C92;
            /* เปลี่ยนพื้นหลัง */
            color: white;
            /* เปลี่ยนสีตัวอักษร */
        }

        /* =========================
           กล่องฟอร์ม
        ========================= */


        .card {
            width: 100%;
            max-width: 450px;
            /* จำกัดขนาด */
            background: #F7FBFC;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            /* เงา */

        }

        /* =========================
           FORM
        ========================= */
        label {
            font-weight: bold;
            color: #333;
        }

        input,
        textarea,
        select{
            width: 100%;
            /* เต็มความกว้าง */
            padding: 10px;
            margin: 6px 0 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        textarea {
            min-height: 80px;
        }

        /* =========================
           หัวข้อ
        ========================= */
        h2 {
            text-align: center;
            /* จัดกลางข้อความ */
            padding-top: 20px;
            font-size: 35px;
            font-weight: bold;
        }

        /* =========================
           label
        ========================= */
        label {
            font-size: 18px;
            /* ขนาดตัวอักษร */
        }

        /* =========================
           ปุ่ม submit
        ========================= */
        button {
            background: #0D4C92;
            /* สีปุ่ม */
            color: white;
            /* สีตัวอักษร */
            border: none;
            /* ไม่มีขอบ */
            padding: 8px 12px;
            /* ขนาดปุ่ม */
            cursor: pointer;
            /* เมาส์เป็น pointer */
        }

        /* hover ปุ่ม */
        button:hover {
            background: #08376b;
            /* สีเข้มขึ้น */
        }
    </style>
</head>

<body>

    <!-- หัวข้อ -->
    <h2 h2 style="text-align: center; padding-top: 20px; font-size: 35px; font-weight: bold;">✏️ Edit Product</h2>

    <!-- ปุ่มกลับ -->
    <a href="manage_products.php" class="back-home">🔙 กลับไปจัดการสินค้า</a>
    <div class="wrapper">
        <!-- กล่องฟอร์ม -->
        <div class="card">
            <!-- ฟอร์มแก้ไข -->
            <form method="POST">
                <!-- ชื่อสินค้า -->
                <label>ชื่อสินค้า:</label>
                <input type="text" name="p_name"
                    value="<?= $product['p_name'] ?>" required><br>

                <!-- รายละเอียด -->
                <label>รายละเอียด:</label>
                <textarea name="p_detail"><?= $product['p_detail'] ?></textarea><br>

                <!-- ราคา -->
                <label>ราคา:</label>
                <input type="number" name="p_price" step="0.01"
                    value="<?= $product['p_price'] ?>" required><br>

                <!-- จำนวน -->
                <label>จำนวน:</label>
                <input type="number" name="p_total"
                    value="<?= $product['p_total'] ?>" required><br>

                <label>หมวดหมู่:</label>
                <select name="c_ID" required>
                    <option value="">-- เลือกหมวดหมู่ --</option>

                    <?php while ($row = $categories2->fetch_assoc()) { ?>
                        <option value="<?= $row['c_ID'] ?>"
                            <?= ($row['c_ID'] == $product['c_ID']) ? 'selected' : '' ?>>

                            <?= $row['c_name'] ?>
                        </option>
                    <?php } ?>
                </select><br>

                <!-- ปุ่ม submit -->
                <button type="submit">อัปเดตสินค้า</button>

            </form>

        </div>
    </div>

</body>

</html>
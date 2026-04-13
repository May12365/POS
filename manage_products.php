<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// ดึงรายการหมวดหมู่
$sql_cat = "SELECT * FROM Categories";
$categories = $conn->query($sql_cat);
// ดึงหมวดหมู่ใหม่สำหรับฟอร์ม
$categories2 = $conn->query("SELECT * FROM Categories");

// กรองสินค้าตามหมวดหมู่
$filter_c_ID = isset($_GET['filter_c_ID']) ? $_GET['filter_c_ID'] : '';
$sql = "SELECT Product.*, Categories.c_name FROM Product LEFT JOIN Categories ON Product.c_ID = Categories.c_ID";
if ($filter_c_ID != '') {
    $sql .= " WHERE Product.c_ID = '$filter_c_ID'";
}
$products = $conn->query($sql);

// เพิ่มสินค้า
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $p_name = $_POST['p_name'];
    $p_detail = $_POST['p_detail'];
    $p_price = $_POST['p_price'];
    $p_total = $_POST['p_total'];
    $c_ID = $_POST['c_ID'];

    $sql = "INSERT INTO Product (p_name, p_detail, p_price, p_total, c_ID) VALUES ('$p_name', '$p_detail', '$p_price', '$p_total', '$c_ID')";
    $conn->query($sql);
    header("Location: manage_products.php");
    exit();
}

// ลบสินค้า
if (isset($_GET['delete'])) {
    $p_ID = $_GET['delete'];
    $conn->query("DELETE FROM Product WHERE p_ID='$p_ID'");
    header("Location: manage_products.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Products</title>
    <style>
        body {
            background: linear-gradient(to right, #769FCD, #B9D7EA);
            /* สีพื้นหลัง */
        }

        /* =========================
   WRAPPER หลัก (ตัวควบคุม layout)
========================= */
        .wrapper {
            display: flex;
            /* ทำให้ลูกเรียงแนวนอน */
            gap: 20px;
            /* ระยะห่างระหว่างกล่อง */
            width: 90%;
            margin: 20px auto;
            /* จัดกลาง */
            align-items: flex-start;
            /* ให้หัวเท่ากันด้านบน */
        }

        /* =========================
   กล่องซ้าย + ขวา
========================= */
        .container1,
        .container2 {
            flex: 1;
            /* ให้ทั้งสองกล่องกว้างเท่ากัน */
            background-color: #F7FBFC;
            padding: 20px;
            border-radius: 10px;
            /*กำหนดความโค้งมนให้กับมุมของ Elements*/
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);

            max-height: 200px;
            overflow-y: auto;
            /* เลื่อนเมื่อข้อมูลเยอะ */
        }

        /* =========================
   FORM STYLE
========================= */
        input,
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin: 6px 0 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* ปุ่ม */
        button {
            width: 100%;
            padding: 10px;
            background: #0D4C92;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #08376b;
        }


        /* ปรับแถบเลื่อน */
        .table-container {
            max-height: 250px;
            overflow-y: auto;
            border: 1px solid #ccc;
            padding: 5px;
            border: none;
            border-radius: 4px;
            margin-top: 10px;
            background-color: #F7FBFC;
            width: 95%;
            /* กำหนดความกว้าง */
            margin: auto;
        }

        /* ปรับแถบเลื่อนให้เล็กลง */
        .table-container::-webkit-scrollbar {
            width: 6px;
            /* กำหนดความกว้างของแถบเลื่อน */
        }

        .table-container::-webkit-scrollbar-thumb {
            background-color: #888;
            /* สีของแถบเลื่อน */
            border-radius: 10px;
            /* ทำมุมโค้งให้แถบเลื่อน */
        }

        .table-container::-webkit-scrollbar-thumb:hover {
            background-color: #555;
            /* สีของแถบเลื่อนเมื่อเอาเมาส์ไปวาง */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #F7FBFC;
        }

        th,
        td {
            padding: 6px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #0D4C92;
            color: white;
        }

        .back-home {
            position: absolute;
            top: 18px;
            right: 20px;
            font-size: 15px;
            padding: 8px 15px;
            border: 2px solid #0D4C92;
            /* กำหนดกรอบ */
            border-radius: 5px;
            /* ทำให้มุมโค้ง */
            background-color: white;
            /* สีพื้นหลัง */
            color: #0D4C92;
            /* สีตัวอักษร */
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .back-home:hover {
            background-color: #0D4C92;
            color: white;
        }
    </style>


</head>

<body>
    <h2 style="text-align: center; padding-top: 20px; font-size: 35px; font-weight: bold;">📦 Manage Products</h2>
    <a href="index.php" class="back-home">🔙 กลับหน้าหลัก</a>

    <div class="wrapper">

        <div class="container1">
            <h3>กรองสินค้าตามหมวดหมู่</h3>

            <form method="GET">
                <label>เลือกหมวดหมู่:</label>
                <select name="filter_c_ID" onchange="this.form.submit()">
                    <option value="">-- แสดงทั้งหมด --</option>
                    <?php while ($row = $categories->fetch_assoc()) { ?>
                        <option value="<?= $row['c_ID'] ?>" <?= (isset($_GET['filter_c_ID']) && $_GET['filter_c_ID'] == $row['c_ID']) ? 'selected' : '' ?>>
                            <?= $row['c_name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </form>


        </div>

        <div class="container2">
            <h3>เพิ่มสินค้าใหม่</h3>
            <form method="POST">
                <label>ชื่อสินค้า:</label>
                <input type="text" name="p_name" required>

                <label>รายละเอียด:</label>
                <textarea name="p_detail"></textarea>

                <label>ราคา:</label>
                <input type="number" name="p_price" step="0.01" required>

                <label>จำนวน:</label>
                <input type="number" name="p_total" required>

                <label>หมวดหมู่:</label>
                <select name="c_ID" required>
                    <option value="">-- เลือกหมวดหมู่ --</option>

                    <?php while ($row = $categories2->fetch_assoc()) { ?>
                        <option value="<?= $row['c_ID'] ?>">
                            <?= $row['c_name'] ?>
                        </option>
                    <?php } ?>
                </select><br>

                <button type="submit" name="add_product">เพิ่มสินค้า</button>
            </form>
        </div>

    </div>

    <div class="table-container">
        <h3>รายการสินค้า</h3>
        <table>
            <tr>
                <th>รหัส</th>
                <th>ชื่อสินค้า</th>
                <th>รายละเอียด</th>
                <th>ราคา</th>
                <th>จำนวน</th>
                <th>หมวดหมู่</th>
                <th>การจัดการ</th>
            </tr>
            <?php while ($row = $products->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['p_ID'] ?></td>
                    <td><?= $row['p_name'] ?></td>
                    <td><?= $row['p_detail'] ?></td>
                    <td><?= number_format($row['p_price'], 2) ?> บาท</td>
                    <td><?= $row['p_total'] ?></td>
                    <td><?= $row['c_name'] ?></td>
                    <td>
                        <a href="edit_product.php?p_ID=<?= $row['p_ID'] ?>">✏️ แก้ไข</a> |
                        <a href="manage_products.php?delete=<?= $row['p_ID'] ?>" onclick="return confirm('ลบสินค้านี้?')">🗑️ ลบ</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>

</html>
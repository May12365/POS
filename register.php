<?php 
session_start();
include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // ✅ ป้องกัน SQL Injection (แบบมือโปร)
    $stmt = $conn->prepare("INSERT INTO Users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);

    if ($stmt->execute()) {
    $message = "สมัครสมาชิกสำเร็จ!";
    
    // สั่ง redirect หลัง 0.5 วินาที
    echo "<script>
        setTimeout(function(){
            window.location.href = 'login.php';
        }, 500);
    </script>";
    } else {
        $message = "เกิดข้อผิดพลาด: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>

<style>
body {
    background: linear-gradient(to right, #769FCD, #B9D7EA);
    font-family: Arial, sans-serif;
}

/* กล่องกลาง */
.center {
    width: 30%;
    background: #F7FBFC;
    border: 2px solid #769FCD;
    padding: 30px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* จัดกลาง */
.a {
    text-align: center;
}

h2 {
    font-size: 32px;
    margin-bottom: 20px;
}

label {
    font-size: 16px;
    display: block;
    margin-top: 10px;
    text-align: left;
}

input, select {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

/* ปุ่ม */
.submit {
    background-color: #0D4C92;
    color: white;
    padding: 10px;
    width: 100%;
    border: none;
    margin-top: 15px;
    cursor: pointer;
    border-radius: 5px;
}

.submit:hover {
    background-color: #083b70;
}

/* ลิงก์ */
.link {
    margin-top: 15px;
    display: block;
    text-decoration: none;
    color: #0D4C92;
}

.link:hover {
    text-decoration: underline;
}
</style>

</head>

<body>

<div class="center">
    <div class="a">
        <h2>Register</h2>

        <?php if ($message) echo "<p style='color:green;'>$message</p>"; ?>

        <form method="POST">
            <label>Username</label>
            <input type="text" name="username" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <label>Role</label>
            <select name="role">
                <option value="staff">Staff</option>
                <option value="admin">Admin</option>
            </select>

            <button class="submit">Register</button>
        </form>

        <!-- ลิงก์ไปหน้า Login -->
        <a class="link" href="login.php">มีบัญชีแล้ว? ไป Login</a>

    </div>
</div>

</body>
</html>
 <?php
$host = "localhost"; // Địa chỉ máy chủ cơ sở dữ liệu
$user = "root"; // Tên người dùng cơ sở dữ liệu
$password = ""; // Mật khẩu cơ sở dữ liệu
$dbname = "duanhom1"; // Tên cơ sở dữ liệu

// Kết nối với cơ sở dữ liệu MySQL
$conn = new mysqli($host, $user, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

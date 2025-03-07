<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "duannhom1"; // Thay 'database_name' bằng tên cơ sở dữ liệu của bạn

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
// Truy vấn dữ liệu từ bảng hóa đơn
$sql = "SELECT * FROM chitiethoadon";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết hóa đơn</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Chi tiết hóa đơn</h2>

<table>
    <tr>
        <th>Mã Hóa Đơn</th>
        <th>ID Sản Phẩm</th>
        <th>Mã Khách Hàng</th>
        <th>Số lượng</th>
        <th>Thành tiền</th>
    </tr>

    <?php
    // Kiểm tra nếu có dữ liệu
    if ($result->num_rows > 0) {
        // Xuất dữ liệu từng dòng
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["MaHD"] . "</td>
                    <td>" . $row["IDSanPham"] . "</td>
                    <td>" . $row["MaKH"] . "</td>
                    <td>" . $row["SL"] . "</td>
                    <td>" . $row["ThanhTien"] . "</td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>Không có dữ liệu</td></tr>";
    }
    ?>
</table>

</body>
</html>

<?php
// Đóng kết nối
$conn->close();
?>

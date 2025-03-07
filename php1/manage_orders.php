<?php
include 'db.php'; // Kết nối cơ sở dữ liệu
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #73dff4;
        }
        .form-container, .order-list {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .btn {
            background-color: #73dff4;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }
        .btn:hover {
            background-color: #4bb3c8;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        .form-input {
            padding: 8px;
            margin: 10px 0;
            width: 100%;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>

<h1>Quản Lý Chi Tiết Hóa Đơn</h1>

<!-- Form to add new order details -->
<div class="form-container">
    <h2>Thêm Hóa Đơn</h2>
    <form action="manage_orders.php" method="POST">
        <input type="text" name="MaHD" class="form-input" placeholder="Order ID" required>
        <input type="text" name="IDSanPham" class="form-input" placeholder="Product ID" required>
        <input type="text" name="MaKH" class="form-input" placeholder="Customer ID">
        <input type="number" name="SL" class="form-input" placeholder="Quantity" required>
        <input type="number" name="ThanhTien" class="form-input" placeholder="Total Price" required>
        <button type="submit" name="add_order_detail" class="btn">Thêm Hóa Đơn</button>
    </form>
</div>

<?php
// Add order detail
if (isset($_POST['add_order_detail'])) {
    $MaHD = $_POST['MaHD'];
    $IDSanPham = $_POST['IDSanPham'];
    $SL = $_POST['SL'];
    $ThanhTien = $_POST['ThanhTien'];

    $sql = "INSERT INTO chitiethoadon (MaHD, IDSanPham, MaKH, SL, ThanhTien) 
            VALUES ('$MaHD', '$IDSanPham','$SL', '$ThanhTien')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Order detail added successfully!</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>

<!-- List of order details -->
<div class="order-list">
    <h2>Danh Sách Chi Tiết Hóa Đơn</h2>
    <table>
        <thead>
            <tr>
                <th>Mã Hóa Đơn</th>
                <th>Mã Sản Phẩm</th>
                <th>Tên khách Hàng</th>
                <th>Số Lượng</th>
                <th>Thành Tiền</th>
                <th>Chức Năng</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Get all order details
            $sql = "SELECT * FROM chitiethoadon";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['MaHD'] . "</td>
                            <td>" . $row['IDSanPham'] . "</td>
                            <td>" . $row['MaKH'] . "</td>
                            <td>" . $row['SL'] . "</td>
                            <td>" . $row['ThanhTien'] . "</td>
                            <td>
                                <a href='edit_order.php?MaHD=" . $row['MaHD'] . "' class='btn'>Edit</a>
                                <a href='manage_orders.php?delete_order=true&MaHD=" . $row['MaHD'] . "' class='btn'>Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No orders found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
// Delete category
if (isset($_GET['delete_category']) && isset($_GET['IDDanhMuc'])) {
    $maDM = $_GET['IDDanhMuc'];

    // Bảo vệ dữ liệu đầu vào
    $maDM = $conn->real_escape_string($maDM);

    // Thực thi câu lệnh xóa
    $sql = "DELETE FROM danhmucsanpham WHERE IDDanhMuc='$maDM'";

    if ($conn->query($sql) === TRUE) {
        // Hiển thị thông báo thành công và reload trang
        echo "<script>alert('Danh mục đã được xóa thành công!');</script>";
        echo "<script>window.location.href='manage_categories.php';</script>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>


</body>
</html>

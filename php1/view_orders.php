<?php
include 'db.php'; // Kết nối cơ sở dữ liệu

// Lấy tất cả các đơn hàng
$sql = "SELECT DISTINCT MaHD FROM chitiethoadon";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #73dff4;
        }
        .order-table, th, td {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            padding: 10px;
            border-radius: 8px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
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
    </style>
</head>
<body>

<h1>Xem Hóa Đơn</h1>

<?php
// Nếu có đơn hàng
if ($result->num_rows > 0) {
    while ($order = $result->fetch_assoc()) {
        $maHD = $order['MaHD'];

        echo "<h3>Mã Hóa Đơn: $maHD</h3>";

        // Lấy các sản phẩm trong đơn hàng
        $orderDetailsSql = "SELECT c.MaHD, c.IDSanPham, c.SL, c.ThanhTien, s.TenSp, s.Gia 
                            FROM chitiethoadon c 
                            JOIN sanpham s ON c.IDSanPham = s.IDSanPham 
                            WHERE c.MaHD = '$maHD'";

        $orderDetailsResult = $conn->query($orderDetailsSql);

        if ($orderDetailsResult->num_rows > 0) {
            echo "<table class='order-table'>";
            echo "<thead><tr>
                    <th>Tên Sản Phẩm</th>
                    <th>Giá</th>
                    <th>Số Lượng</th>
                    <th>Tất Toán</th>
                  </tr></thead><tbody>";

            $totalOrderPrice = 0;
            while ($orderDetail = $orderDetailsResult->fetch_assoc()) {
                $totalOrderPrice += $orderDetail['ThanhTien'];

                echo "<tr>
                        <td>" . $orderDetail['TenSp'] . "</td>
                        <td>" . number_format($orderDetail['Gia'], 0, ',', '.') . " VND</td>
                        <td>" . $orderDetail['SL'] . "</td>
                        <td>" . number_format($orderDetail['ThanhTien'], 0, ',', '.') . " VND</td>
                      </tr>";
            }

            echo "</tbody></table>";
            echo "<h4>Tất Toán: " . number_format($totalOrderPrice, 0, ',', '.') . " VND</h4>";
        } else {
            echo "<p>Không tìm thấy sản phẩm nào cho đơn hàng này.</p>";
        }
    }
} else {
    echo "<p>Không tìm thấy đơn hàng nào.</p>";
}

$conn->close();
?>

</body>
</html>

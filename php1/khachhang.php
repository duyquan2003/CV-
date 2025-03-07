<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Khách Hàng</title>
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
        .customer-list {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
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
        th {
            background-color: #73dff4;
            color: white;
        }
        .no-data {
            text-align: center;
            font-style: italic;
            color: #888;
        }
    </style>
</head>
<body>
    <h1>Danh Sách Khách Hàng</h1>
    <div class="customer-list">
        <table>
            <thead>
                <tr>
                    <th>ID_KH</th>
                    <th>Họ Tên</th>
                    <th>Email</th>
                    <th>Điện Thoại</th>
                    <th>Địa Chỉ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT ID_KH, HoTen, Email, DienThoai, DiaChi FROM khachhang";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['ID_KH'] . "</td>
                                <td>" . $row['HoTen'] . "</td>
                                <td>" . $row['Email'] . "</td>
                                <td>" . $row['DienThoai'] . "</td>
                                <td>" . $row['DiaChi'] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='no-data'>Không có dữ liệu</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

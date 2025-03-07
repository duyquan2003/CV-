<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Product & Order Management</title>
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
        .container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        .card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 250px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-10px);
        }
        .card a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #73dff4;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .card a:hover {
            background-color: #4bb3c8;
        }
        .card h3 {
            margin-bottom: 15px;
            font-size: 18px;
        }
        .card p {
            color: #777;
        }
    </style>
</head>
<body>

<h1>Chào Mừng Đến Với Trang Quản Lý</h1>

<div class="container">
    <!-- Card for Product Management -->
    <div class="card">
        <h3>Quản Lý Sản Phẩm</h3>
        <p>Quản Lý và Xem Sản Phẩm</p>
        <a href="manage_products.php">Sản Phẩm</a>
    </div>

    <!-- Card for Order Management -->
    <div class="card">
        <h3>Quản Lý Chi Tiết Hóa Đơn</h3>
        <p>Quản Lý Đơn Hàng và Chi Tiết Hóa Đơn</p>
        <a href="manage_orders.php">Chi Tiết Hóa Đơn</a>
    </div>
    <div class="card">
        <h3>Xem Tất DSKH Quen</h3>
        <p>Kiểm Tra Lại TT Khách Hàng </p>
        <a href="khachhangquen.php">Xem danh sách khách hàng</a>
    </div>

    <div class="card">
        <h3>Xem Tất Cả Khách Hàng</h3>
        <p>Kiểm Tra Lại TT Khách Hàng</p>
        <a href="khachhang.php">Xem danh sách khách hàng</a>
    </div>
    <!-- Card for View All Orders -->
    <div class="card">
        <h3>Xem Tất Cả Đơn Hàng</h3>
        <p>Kiểm Tra Lại Các Dơn Hàng Đã Đặt</p>
        <a href="view_orders.php">Xem Các Đơn hàng</a>
    </div>
    
    <div class="card">
        <h3>Danh mục sản phẩm</h3>
        <p>Kiểm tra lại danh mục sản phẩm</p>
        <a href="dmsp.php">Xem Các Danh Mục Sản Phẩm</a>
    </div>
</div>

</body>
</html>

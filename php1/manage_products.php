<?php
include 'db.php'; // Kết nối cơ sở dữ liệu

// Hàm xử lý upload ảnh
function uploadImage($file) {
    $targetDir = "uploads/"; // Thư mục lưu ảnh
    $targetFile = $targetDir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Kiểm tra xem tệp có phải là ảnh không
    if (getimagesize($file["tmp_name"]) === false) {
        echo "File không phải là ảnh.";
        return false;
    }

    // Kiểm tra loại tệp ảnh (chỉ cho phép jpg, png, jpeg, gif)
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Chỉ cho phép tải lên các tệp ảnh JPG, JPEG, PNG & GIF.";
        return false;
    }

    // Kiểm tra kích thước ảnh (giới hạn 5MB)
    if ($file["size"] > 5000000) {
        echo "Ảnh quá lớn. Vui lòng tải lên ảnh có kích thước nhỏ hơn 5MB.";
        return false;
    }

    // Di chuyển tệp ảnh vào thư mục "uploads"
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $targetFile; // Trả về đường dẫn ảnh
    } else {
        echo "Lỗi trong quá trình tải ảnh lên.";
        return false;   
    }
}

// Xử lý thêm sản phẩm
if (isset($_POST['add_product'])) {
    $idSanPham = $_POST['IDSanPham'];
    $tenSp = $_POST['TenSp'];
    $gia = $_POST['Gia'];
    $tinhTrang = $_POST['TinhTrang'];
    $soLuong = $_POST['SoLuong'];
    $thongTin = $_POST['ThongTin'];

    // Xử lý ảnh
    $image = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = uploadImage($_FILES['image']); // Lấy đường dẫn ảnh
    }

    if ($image !== false) {
        $sql = "INSERT INTO sanpham (IDSanPham, TenSp, Gia, TinhTrang, SoLuong, ThongTin, image) 
                VALUES ('$idSanPham', '$tenSp', '$gia', '$tinhTrang', '$soLuong', '$thongTin', '$image')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Product added successfully!</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
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
        .form-container, .product-list {
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

<h1>Quản Lý Sản Phẩm</h1>

<!-- Form to add new product -->
<div class="form-container">
    <h2>Thêm Sản Phẩm</h2>
    <form action="manage_products.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="IDSanPham" class="form-input" placeholder="Mã Sản Phẩm" required>
        <input type="text" name="TenSp" class="form-input" placeholder="Tên Sản Phẩm" required>
        <input type="number" name="Gia" class="form-input" placeholder="Giá" required>
        <input type="text" name="TinhTrang" class="form-input" placeholder="Tình Trạng" required>
        <input type="number" name="SoLuong" class="form-input" placeholder="Số Lượng" required>
        <textarea name="ThongTin" class="form-input" placeholder="Thông Tin " required></textarea>
        
        <!-- Input field for image upload -->
        <input type="file" name="image" class="form-input" required>
        
        <button type="submit" name="add_product" class="btn">Thêm sản phẩm</button>
    </form>
</div>

<!-- List of products -->
<div class="product-list">
    <h2>Danh Sách Sản phẩm</h2>
    <table>
        <thead>
            <tr>
                <th>Mã Sản Phẩm</th>
                <th>Tên Sản Phẩm</th>
                <th>Giá</th>
                <th>Tình Trạng</th>
                <th>Số Lượng</th>
                <th>Ảnh Sản Phẩm</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Get all products
            $sql = "SELECT * FROM sanpham";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['IDSanPham'] . "</td>
                            <td>" . $row['TenSp'] . "</td>
                            <td>" . $row['Gia'] . "</td>
                            <td>" . $row['TinhTrang'] . "</td>
                            <td>" . $row['SoLuong'] . "</td>
                            <td><img src='" . $row['image'] . "' width='100'></td>
                            <td>
                                <a href='edit_product.php?IDSanPham=" . $row['IDSanPham'] . "' class='btn'>Edit</a>
                                <a href='manage_products.php?delete_product=true&IDSanPham=" . $row['IDSanPham'] . "' class='btn'>Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No products found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
// Delete category
if (isset($_GET['delete_category']) && isset($_GET['IDSanPham'])) {
    $maDM = $_GET['IDSanPham'];

    // Bảo vệ dữ liệu đầu vào
    $maDM = $conn->real_escape_string($maSP);

    // Thực thi câu lệnh xóa
    $sql = "DELETE FROM sanpham WHERE IDDanhMuc='$maSP'";

    if ($conn->query($sql) === TRUE) {
        // Hiển thị thông báo thành công và reload trang
        echo "<script>alert('Sản Phẩm đã được xóa thành công!');</script>";
        echo "<script>window.location.href='manage_products.php';</script>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>


</body>
</html>

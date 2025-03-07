<?php
include 'db.php'; // Kết nối cơ sở dữ liệu
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
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
        .form-container, .category-list {
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

<h1>Quản Lý Danh Mục Sản Phẩm</h1>

<!-- Form to add new category -->
<div class="form-container">
    <h2>Thêm Danh Mục</h2>
    <form action="manage_categories.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="IDDanhMuc" class="form-input" placeholder="Mã Danh Mục" required>
        <input type="text" name="TenDanhMuc" class="form-input" placeholder="Tên Danh Mục" required>
        <input type="file" name="ImgDM" class="form-input" required>
        <button type="submit" name="add_category" class="btn">Thêm Danh Mục</button>
    </form>
</div>

<?php
// Add new category
if (isset($_POST['add_category'])) {
    $maDM = $_POST['IDDanhMuc'];
    $tenDM = $_POST['TenDanhMuc'];

    // Handle image upload
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["ImgDM"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $uploadOk = 1;

    // Check if file is an image
    $check = getimagesize($_FILES["ImgDM"]["tmp_name"]);
    if ($check === false) {
        echo "<p>File is not an image.</p>";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "<p>Sorry, file already exists.</p>";
        $uploadOk = 0;
    }

    // Check file size (limit to 5MB)
    if ($_FILES["ImgDM"]["size"] > 5000000) {
        echo "<p>Sorry, your file is too large.</p>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
        echo "<p>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk === 0) {
        echo "<p>Sorry, your file was not uploaded.</p>";
    } else {
        if (move_uploaded_file($_FILES["ImgDM"]["tmp_name"], $targetFile)) {
            $sql = "INSERT INTO danhmucsanpham (IDDanhMuc, TenDanhMuc, ImgDM) 
                    VALUES ('$maDM', '$tenDM', '$targetFile')";

            if ($conn->query($sql) === TRUE) {
                echo "<p>Category added successfully!</p>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        } else {
            echo "<p>Sorry, there was an error uploading your file.</p>";
        }
    }
}
?>

<!-- List of categories -->
<div class="category-list">
    <h2>Danh Sách Danh Mục</h2>
    <table>
        <thead>
            <tr>
                <th>ID Danh Mục</th>
                <th>Tên Danh Mục</th>
                <th>Hình Ảnh</th>
                <th>Chức Năng</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Get all categories
            $sql = "SELECT * FROM danhmucsanpham";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['IDDanhMuc'] . "</td>
                            <td>" . $row['TenDanhMuc'] . "</td>
                            <td><img src='" . $row['ImgDM'] . "' alt='Image' style='width:100px;'></td>
                            <td>
                                <a href='edit_category.php?IDDanhMuc=" . $row['IDDanhMuc'] . "' class='btn'>Edit</a>
                                <a href='manage_categories.php?delete_category=true&IDDanhMuc=" . $row['IDDanhMuc'] . "' class='btn'>Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No ---categories found</td></tr>";
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
        echo "<script>window.location.href='dmsp.php';</script>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>


</body>
</html>

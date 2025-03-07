<?php
$conn = new mysqli('localhost', 'root', '', 'masv_examphp1');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $brand_id = $_POST['brand_id'];

    // Validate
    $errors = [];
    
    if ($_FILES['image']['error'] == 0) {
        $image_type = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (!in_array($image_type, ['jpg', 'png'])) {
            $errors[] = "Chỉ cho phép ảnh jpg, png.";
        }
        if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
            $errors[] = "Kích thước ảnh phải <= 2MB.";
        }
    } else {
        $errors[] = "Vui lòng chọn ảnh.";
    }
    
    if (!is_numeric($price) || $price <= 0) {
        $errors[] = "Giá phải là số dương.";
    }
    if (!is_numeric($quantity) || $quantity <= 0) {
        $errors[] = "Số lượng phải là số dương.";
    }

    if (empty($errors)) {
        // Upload ảnh
        $image_path = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);

        $stmt = $conn->prepare("INSERT INTO products (product_name, image, price, quantity, description, brand_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssdisi', $product_name, $image_path, $price, $quantity, $description, $brand_id);
        $stmt->execute();

        header('Location: index.php');
        exit;
    }
}


// Lấy danh sách hãng
$brands = $conn->query("SELECT * FROM brands");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thêm sản phẩm mới</title>
    <link rel="stylesheet" href="">
</head>
<body>
    <h1>Thêm sản phẩm mới</h1>
    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="product_name">Tên sản phẩm:</label>
        <input type="text" name="product_name" required><br>

        <label for="image">Hình ảnh:</label>
        <input type="file" name="image" accept="image/*" required><br>

        <label for="price">Giá:</label>
        <input type="text" name="price" required><br>

        <label for="quantity">Số lượng:</label>
        <input type="text" name="quantity" required><br>

        <label for="description">Mô tả:</label>
        <textarea name="description"></textarea><br>

        <label for="brand_id">Hãng:</label>
        <select name="brand_id" required>
            <?php while ($row = $brands->fetch_assoc()): ?>
                <option value="<?php echo $row['brand_id']; ?>"><?php echo $row['brand_name']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <input type="submit" value="Thêm sản phẩm">
    </form>
</body>
</html>

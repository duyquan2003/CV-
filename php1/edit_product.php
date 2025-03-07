<?php
$conn = new mysqli('localhost', 'root', '', 'masv_examphp1');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$product_id = $_GET['id'];
$product = $conn->query("SELECT * FROM products WHERE product_id = $product_id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $brand_id = $_POST['brand_id'];

    // Validate
    $errors = [];

    if (!empty($_FILES['image']['name'])) {
        $image_type = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (!in_array($image_type, ['jpg', 'png'])) {
            $errors[] = "Chỉ cho phép ảnh jpg, png.";
        }
        if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
            $errors[] = "Kích thước ảnh phải <= 2MB.";
        }
    }

    if (!is_numeric($price) || $price <= 0) {
        $errors[] = "Giá phải là số dương.";
    }
    if (!is_numeric($quantity) || $quantity <= 0) {
        $errors[] = "Số lượng phải là số dương.";
    }

    if (empty($errors)) {
        // Nếu có ảnh mới, upload ảnh
        if (!empty($_FILES['image']['name'])) {
            $image_path = 'uploads/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
        } else {
            $image_path = $product['image']; // giữ lại ảnh cũ
        }

        $stmt = $conn->prepare("UPDATE products SET product_name = ?, image = ?, price = ?, quantity = ?, description = ?, brand_id = ? WHERE product_id = ?");
        $stmt->bind_param('ssdisii', $product_name, $image_path, $price, $quantity, $description, $brand_id, $product_id);
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
    <title>Chỉnh sửa sản phẩm</title>
</head>
<body>
    <h1>Chỉnh sửa sản phẩm</h1>
    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="product_name">Tên sản phẩm:</label>
        <input type="text" name="product_name" value="<?php echo $product['product_name']; ?>" required><br>

        <label for="image">Hình ảnh:</label>
        <input type="file" name="image" accept="image/*"><br>
        <img src="<?php echo $product['image']; ?>" width="100" alt="Current image"><br>

        <label for="price">Giá:</label>
        <input type="text" name="price" value="<?php echo $product['price']; ?>" required><br>

        <label for="quantity">Số lượng:</label>
        <input type="text" name="quantity" value="<?php echo $product['quantity']; ?>" required><br>

        <label for="description">Mô tả:</label>
        <textarea name="description"><?php echo $product['description']; ?></textarea><br>

        <label for="brand_id">Hãng:</label>
        <select name="brand_id" required>
            <?php while ($row = $brands->fetch_assoc()): ?>
                <option value="<?php echo $row['brand_id']; ?>" <?php echo $row['brand_id'] == $product['brand_id'] ? 'selected' : ''; ?>>
                    <?php echo $row['brand_name']; ?>
                </option>
            <?php endwhile; ?>
        </select><br>

        <input type="submit" value="Cập nhật sản phẩm">
    </form>
</body>
</html>

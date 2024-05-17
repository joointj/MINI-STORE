<?php
include "connection.php"; // Assuming "connection.php" establishes a secure connection

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Sanitize user input to prevent SQL injection
    $productname = mysqli_real_escape_string($con, $_POST['productname']);
    $color = mysqli_real_escape_string($con, $_POST['color']);
    $price = (float)$_POST['price']; // Cast to float for numerical values

    // Handle image upload (replace with your image handling logic)
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/"; // Replace with your image upload directory
        $target_file = $target_dir . uniqid() . '.' . pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a real image (optional)
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            // Allow certain file formats (optional)
            $allowed_types = ["jpg", "jpeg", "png", "gif"];
            if (in_array($imageFileType, $allowed_types)) {
                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES["image"]["tmp_name"], __DIR__ . "/" . $target_file)) {
                    $image = $target_file; // Store the image path in the database
                } else {
                    echo "Sorry, there was an error uploading your image.";
                    exit();
                }
            } else {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                exit();
            }
        } else {
            echo "File is not an image.";
            exit();
        }
    } else {
        // Handle cases where no image is uploaded (set image to NULL or default value)
        $image = NULL; // Or provide a default image path
    }

    // Get the last ID in the database
    $last_id_query = "SELECT MAX(ID) AS last_id FROM products";
    $result = mysqli_query($con, $last_id_query);
    $row = mysqli_fetch_assoc($result);
    $last_id = $row['last_id'];

    // Set the new product ID
    $new_product_id = $last_id ? $last_id + 1 : 1;

    // Prepare SQL statement for security
    $sql = "INSERT INTO products (ID, ProductName, Color, Price, Image) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "issss", $new_product_id, $productname, $color, $price, $image);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) == 1) {
        mysqli_close($con); // Close connection
        // Redirect to product.php
        header('Location: product.php');
        exit();
    } else {
        echo "Error adding product: " . mysqli_error($con);
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            padding: 20px;
            border-radius: 10px;
        }
        .form-group label {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <h2 class="card-title">Add Product</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="productname">Product Name:</label>
                <input type="text" class="form-control" id="productname" name="productname" required>
            </div>
            <div class="form-group">
                <label for="color">Color:</label>
                <input type="text" class="form-control" id="color" name="color">
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Add Product</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

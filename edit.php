<!DOCTYPE html>
<html>
<head>
  <title>Update Product Record</title>
  <link rel="stylesheet" href="edit.css"> <!-- Link to external CSS file -->
</head>
<body>

<div class="container">
  <h2 class="title">Update Product Record</h2>
  <?php
  include "connection.php";

  // Check if ID is present in the query string and is numeric
  if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve product data with prepared statement for security
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id); // Bind ID as integer
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result->num_rows == 1) {
      $data = mysqli_fetch_array($result);

      // Form handling with proper error handling
      if (isset($_POST['update'])) {
        $productname = mysqli_real_escape_string($con, $_POST['productname']); // Sanitize input
        $color = mysqli_real_escape_string($con, $_POST['color']); // Sanitize input
        $price = (float)$_POST['price']; // Cast to float for numerical values

        // Update product with prepared statement for security
        $sql = "UPDATE products SET productname = ?, color = ?, price = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $productname, $color, $price, $id); // Bind parameters
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) == 1) {
          mysqli_close($con); // Close connection
          header("location:product.php"); // Redirect to all records page
        } else {
          echo "<div class='error'>Error updating product: " . mysqli_error($con) . "</div>";
        }

        mysqli_stmt_close($stmt); // Close prepared statement (good practice)
      }

      // Display form with pre-filled data
      ?>
      <form method="POST" class="update-form">
        <div class="form-group">
          <label for="productname">Product Name:</label>
          <input type="text" name="productname" value="<?php echo $data['productname']; ?>" required>
        </div>
        <div class="form-group">
          <label for="color">Color:</label>
          <input type="text" name="color" value="<?php echo $data['color']; ?>">
        </div>
        <div class="form-group">
          <label for="price">Price:</label>
          <input type="text" name="price" value="<?php echo $data['price']; ?>">
        </div>
        <button type="submit" name="update" class="update-btn">Update</button>
      </form>
      <?php
    } else {
      echo "<div class='error'>Invalid product ID or product not found.</div>";
    }

    mysqli_free_result($result); // Free result set (good practice)
  } else {
    echo "<div class='error'>Missing or invalid product ID.</div>";
  }

  mysqli_close($con); // Close connection outside the conditional block for consistency
  ?>
</div>

</body>
</html>

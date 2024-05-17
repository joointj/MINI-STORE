<!DOCTYPE html>
<html>
<head>
    <title>Product</title>
    <link rel="stylesheet" href="product.css"> 
</head>
<body>
    <h1>Product Details</h1>
    <table border="2">
        <tr>
            <td>Id</td>
            <td>Product Name</td>
            <td>Color</td>
            <td>Price</td>
            <td>Image</td>
            <td>Edit</td>
            <td>Delete</td>
        </tr>
        <?php
        include "connection.php";
        $records = mysqli_query($con, "SELECT * FROM products");
        while ($data = mysqli_fetch_array($records)) {
            ?>
            <tr>
                <td><?php echo $data['id']; ?></td>
                <td><?php echo $data['productname']; ?></td>
                <td><?php echo $data['color']; ?></td>
                <td><?php echo $data['price']; ?></td>
                <td><img src="<?php echo $data['image']; ?>" height="50px" width="50px"/></td>
                <td><a href="edit.php?id=<?php echo $data['id']; ?>">Edit</a></td>
                <td><a href="delete.php?id=<?php echo $data['id']; ?>">Delete</a></td>
            </tr>
            <?php
        }
        mysqli_close($con);
        ?>
    </table>
    <?php
    // PHP code to handle button click
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
        // Redirect to add.php
        header("Location: add.php");
        exit();
    }
    ?>
    <form method="POST">
        <input type="submit" class="custom-button" name="add" value="Add Data">
    </form>
</body>
</html>

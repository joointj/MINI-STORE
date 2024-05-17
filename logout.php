<!DOCTYPE html>
<html>
<head>
    <title>logout</title>
    <link rel="stylesheet" href="loginstyle2.css">
</head>
<body>
    <div class="container">
        <h1>You're already Logged in</h1>
        <h2 style="color:red">Do you want to log out?</h2>
        <form method="POST">
            <button type="submit" name="logout" class="btn" id="logout">Logout</button>
        </form>
    </div>
</body>
</html>

<?php
if(isset($_POST['logout'])) {
    header("Location: http://localhost/project/");
    exit;
}
?>

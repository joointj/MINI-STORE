<?php
include 'connection.php'; 

// Initialize $error as an empty array
$errors = array();

if (!isset($_SESSION)) {
    session_start();
} 

if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($con, $_POST['userlog']);
    $password = mysqli_real_escape_string($con, $_POST['pslog']);

    if (empty($username)){
        $errors[] = "Username is required";
    }

    if (empty($password)){
        $errors[] = "Password is required";
    }

    // Check if there are any errors
    if (empty($errors)){
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($con, $query);

        if(mysqli_num_rows($result) == 1){
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "Welcome, you are logged in";
            // Redirect user to homepage
            header('location: welcome.php');
            exit; // Add exit after header to prevent further execution
        } else {
            $errors[] = "Incorrect username or password";
        }
    }
}

if (!empty($errors)) {
     header('location:wrong.php');
}
?>

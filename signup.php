<?php
include 'connection.php'; 

if (!isset($_SESSION)) {
    session_start();
} 

$error = array(); 

if(isset($_POST['signup'])){ 
    $username = mysqli_real_escape_string($con, $_POST['username']); 
    $email = mysqli_real_escape_string($con, $_POST['email']); 
    $password = mysqli_real_escape_string($con, $_POST['password']); 
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']); 

    if(empty($username)){ 
        array_push($error, "Username is required");  
    } 
    if(empty($email)){ 
        array_push($error, "Email is required"); 
    } 
    if(empty($password)){ 
        array_push($error, "Password is required"); 
    } 
    if(empty($cpassword)){ 
        array_push($error, "Confirm is required"); 
    } 
    if($password != $cpassword){ 
        array_push($error, "Passwords do not match");
        echo "Passwords do not match"; 
    } 

    // Check if username or email already exists
    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($con, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    if ($user) {
      if ($user['username'] === $username and $user['email'] === $email) {
          array_push($error, "Username and Email are already used. Please choose another one.");
      } elseif ($user['username'] === $username) {
          array_push($error, "Username already used. Please choose another one.");
      } elseif ($user['email'] === $email) {
          array_push($error, "Email already exists. Please Login.");
      }
  }

    if(count($error) == 0){ 
        $sql = "INSERT INTO users (username, email, password, cpassword) VALUES ('$username', '$email', '$password', '$cpassword')"; 
        mysqli_query($con, $sql);
        header("Location: welcome.php");
        exit();

    } 
} 
?>

<!DOCTYPE html> 
<html lang="en"> 
<head> 
  <meta charset="UTF-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <title>Sign Up</title> 
  <link rel="stylesheet" href="style.css"> 
</head> 
<body> 
  <div class="container"> 
    <h2 id="head">Sign Up</h2>

    <form method="POST"> 
      <div class="form-group"> 
        <label for="username">Username:</label> 
        <input type="text" id="username" name="username" required> 
      </div> 
      <div class="form-group"> 
        <label for="email">Email:</label>  
        <input type="email" id="email" name="email" required> 
      </div> 
      <div class="form-group"> 
        <label for="password">Password:</label> 
        <input type="password" id="password" name="password" required> 
      </div> 
      <div class="form-group"> 
        <label for="rep pass">Repeat Password:</label> 
        <input type="password" id="password" name="cpassword" required> 
      </div> 
      <button type="submit" name="signup">Sign Up</button> 
      <?php
    if (!empty($error)) {
        echo '<div class="error">';
        foreach ($error as $err) {
            echo '<p style="color:red">' . $err . '</p>';
        }
        echo '</div>';
    }
    ?>
      <p>I am a member!<a href="Login.php">Login</a></p>
    </form> 
    
  </div> 
</body> 
</html>

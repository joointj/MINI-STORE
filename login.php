<!DOCTYPE html>
<html>
<head>
      <title>login</title>
      <link rel="stylesheet" href="loginstyle2.css">
</head>
    <div class="container">
       <h1>Welcome to our store!</h1>
       <h2>Login</h2>
       <form method="post" action="logform.php">

              <div class="inp"><label>username</label>
              <input type="text" name="userlog" required></div>

              <div class="inp"><label>password</label>
              <input type="password" name="pslog"></div>

              <div class="inp">
              <button type="submit" name="login" class="btn">Login</button>
              </div>
<p>not yet a member?<a href="http://localhost/project/signup.php">sign up</a></p>
</form>
    </div>
</body>
</html>
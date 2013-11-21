<?php

// PLOTKA'S LOGIN_SECURE_AUTH.PHP
// ==============================

session_start();

// Connect to the database
try {
  $dbname = 'lecture18';
  $user = 'root';
  $pass = '';
  $dbconn = new PDO('mysql:host=localhost;dbname='.$dbname, $user, $pass);
}
catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}


// Check login
if (isset($_POST['login']) && $_POST['login'] == 'Login') {

// validate user, setup session variables and check to see if an admin here

    if ($user['is_admin']==true) {
      header('Location: register_auth.php');
      exit();
    }
  } else {
    $err = 'Incorrect username or password.';
  }
}



// Logout
if (isset($_SESSION['username']) && isset($_POST['logout']) && $_POST['logout'] == 'Logout') {
// end your session here
  $err = 'You have been logged out.';
}


?>
<!doctype html>
<html>
<head>
  <title>Login</title>
</head>
<body>
  <?php if (isset($_SESSION['username'])): ?>
  <h1>Welcome, <?php echo htmlentities($_SESSION['username']) ?></h1>
  <form method="post" action="login_secure_auth.php">
    <input name="logout" type="submit" value="Logout" />
  </form>
  <?php else: ?>
  <h1>Login</h1>
  <?php if (isset($err)) echo "<p>$err</p>" ?>
  <form method="post" action="login_secure_auth.php">
    <label for="username">Username: </label><input type="text" name="username" />
    <label for="pass">Password: </label><input type="password" name="pass" />
    <input name="login" type="submit" value="Login" />
  </form>
  <?php endif; ?>
</body>
</html>

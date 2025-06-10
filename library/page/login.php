<?php
session_start();
require 'db.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->execute([$username]);
  $user = $stmt->fetch();
  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    header("Location: index.php");
    exit();
  } else {
    $error = "Invalid credentials.";
  }
}
?>
<form method="post">
  <input name="username" required placeholder="Username"><br>
  <input name="password" type="password" required placeholder="Password"><br>
  <button type="submit">Login</button>
  <p>Don't have an account? <a href="register.php">Register</a></p>
  <?php if (!empty($error)) echo "<p>$error</p>"; ?>
</form>

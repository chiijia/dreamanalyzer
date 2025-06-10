<?php
require 'db.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
  try {
    $stmt->execute([$username, $password]);
    header("Location: login.php");
  } catch (PDOException $e) {
    $error = "Username already taken.";
  }
}
?>
<form method="post">
  <input name="username" required placeholder="Username"><br>
  <input name="password" type="password" required placeholder="Password"><br>
  <button type="submit">Register</button>
  <p>Already have an account? <a href="login.php">Login</a></p>
  <?php if (!empty($error)) echo "<p>$error</p>"; ?>
</form>

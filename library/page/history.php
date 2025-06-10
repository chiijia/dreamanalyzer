<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
$stmt = $conn->prepare("SELECT * FROM dreams WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$dreams = $stmt->fetchAll();
?>
<h2>Your Dream History</h2>
<a href="index.php">Back</a> | <a href="logout.php">Logout</a>
<ul>
<?php foreach ($dreams as $dream): ?>
  <li>
    <strong><?= htmlspecialchars($dream['created_at']) ?></strong><br>
    <?= nl2br(htmlspecialchars($dream['description'])) ?><br>
    <em>Keywords: <?= htmlspecialchars($dream['keywords']) ?></em>
  </li>
<?php endforeach; ?>
</ul>

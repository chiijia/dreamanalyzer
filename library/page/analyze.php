<?php
session_start();
header("Content-Type: application/json");
require 'db.php';
if (!isset($_SESSION['user_id'])) {
  echo json_encode([]);
  exit();
}
$keywords = [
  "water" => "Represents emotions and the subconscious.",
  "flying" => "Indicates a desire for freedom or escape.",
  "falling" => "May symbolize loss of control or fear.",
  "snake" => "Can represent hidden fears or transformation.",
  "teeth" => "Linked to anxiety about appearance or powerlessness.",
  "death" => "Usually reflects change, not literal death.",
  "school" => "Indicates learning or unresolved past issues.",
  "chase" => "Symbolizes avoidance or stress in real life.",
  "mirror" => "Represents self-reflection or identity."
];
$dream = strtolower($_POST['dream']);
$matched = [];
$foundKeywords = [];
foreach ($keywords as $key => $meaning) {
  if (strpos($dream, $key) !== false) {
    $matched[] = "🌀 '$key': $meaning";
    $foundKeywords[] = $key;
  }
}
$stmt = $conn->prepare("INSERT INTO dreams (user_id, description, keywords) VALUES (?, ?, ?)");
$stmt->execute([$_SESSION['user_id'], $_POST['dream'], implode(",", $foundKeywords)]);
echo json_encode($matched);
?>

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dream Analyzer</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="container">
    <h1>🌙 Dream Analyzer</h1>
    <p>Welcome, <?= htmlspecialchars($_SESSION['username']) ?> | <a href="logout.php">Logout</a> | <a href="history.php">View History</a></p>
    <textarea id="dreamInput" placeholder="Describe your dream here..."></textarea>
    <button id="analyzeBtn">Analyze</button>
    <div id="resultContainer">
      <h2>Interpretation</h2>
      <ul id="results"></ul>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const analyzeBtn = document.getElementById("analyzeBtn");
      const textarea = document.getElementById("dreamInput");
      const results = document.getElementById("results");

      analyzeBtn.addEventListener("click", analyzeDream);

      function analyzeDream() {
        const dreamText = textarea.value.trim();
        results.innerHTML = ""; // 清空之前結果

        if (!dreamText) {
          results.innerHTML = "<li>Please enter a dream description.</li>";
          return;
        }

        // 顯示載入中
        const loading = document.createElement("li");
        loading.textContent = "🔍 Analyzing your dream...";
        results.appendChild(loading);

        fetch("analyze.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body: "dream=" + encodeURIComponent(dreamText)
        })
        .then(res => {
          if (!res.ok) throw new Error("Network response was not ok");
          return res.json();
        })
        .then(data => {
          results.innerHTML = "";
          if (data.length === 0) {
            results.innerHTML = "<li>No interpretations found. Try different keywords.</li>";
          } else {
            data.forEach(item => {
              const li = document.createElement("li");
              li.textContent = item;
              results.appendChild(li);
            });
          }
        })
        .catch(error => {
          results.innerHTML = `<li>Error: ${error.message}</li>`;
        });
      }
    });
  </script>
</body>
</html>

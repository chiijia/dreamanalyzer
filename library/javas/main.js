document.addEventListener("DOMContentLoaded", () => {
    const analyzeBtn = document.querySelector("button");
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
  
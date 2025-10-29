<?php
session_start();
$last_result = $_SESSION['last_result'] ?? null;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>さんちゃんのリアクション🐶</title>
  <link rel="stylesheet" href="css/quiz.css">
  <style>
    body {
      text-align: center;
      background: #f9fff9;
      font-family: "Noto Sans JP", sans-serif;
      transition: transform 0.2s ease;
      overflow-x: hidden;
    }

    .feedback-box {
      background: #fff;
      border-radius: 20px;
      padding: 40px;
      max-width: 600px;
      margin: 60px auto;
      box-shadow: 0 4px 12px rgba(0,128,0,0.1);
    }

    img {
      width: 250px;
      border-radius: 20px;
      margin-top: 20px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      opacity: 0;
      transform: scale(0.8);
      transition: all 0.8s ease;
    }

    img.show {
      opacity: 1;
      transform: scale(1);
    }

    button {
      background: linear-gradient(135deg, #98ecb1 0%, #6fdba1 100%);
      color: #fff;
      border: none;
      border-radius: 40px;
      padding: 10px 25px;
      cursor: pointer;
      transition: 0.3s;
      margin-top: 30px;
    }

    button:hover {
      background: #57c97b;
      transform: scale(1.05);
    }

    /* 🎊 紙吹雪 */
    .confetti {
      position: fixed;
      width: 8px;
      height: 8px;
      top: -10px;
      border-radius: 50%;
      animation: fall linear forwards;
      z-index: 100;
    }
    @keyframes fall {
      to {
        transform: translateY(100vh) rotate(720deg);
        opacity: 0;
      }
    }

    /* ✨ キラキラ光エフェクト */
    .sparkle {
      position: fixed;
      width: 6px;
      height: 6px;
      background: radial-gradient(circle, #ffffff 0%, transparent 70%);
      border-radius: 50%;
      opacity: 0;
      animation: sparkle 3s ease-in-out infinite;
      pointer-events: none;
      z-index: 110;
    }
    @keyframes sparkle {
      0% { transform: scale(0); opacity: 0; }
      30% { transform: scale(1.3); opacity: 1; }
      100% { transform: scale(0); opacity: 0; }
    }

    /* 💢 不正解時ブルブル */
    body.shake {
      animation: shakeScreen 0.4s ease-in-out;
    }
    @keyframes shakeScreen {
      0%,100% { transform: translate(0, 0); }
      25% { transform: translate(-5px, 4px); }
      50% { transform: translate(5px, -4px); }
      75% { transform: translate(-3px, 6px); }
    }

    /* 💬 怒りコメント（フェードイン） */
    .angry-comment {
      color: #ff6b6b;
      font-weight: bold;
      margin-top: 15px;
      font-size: 1.1em;
      opacity: 0;
      animation: fadeIn 1s forwards;
    }
    @keyframes fadeIn {
      to { opacity: 1; }
    }
  </style>
</head>
<body>
  <div class="feedback-box">
    <?php if ($last_result === 'correct'): ?>
      <h2>🎉 正解！さんちゃんご機嫌です！</h2>
      <img id="sanchan" src="images/sanchan_happyhappy.png" alt="正解のさんちゃん">
    <?php elseif ($last_result === 'wrong'): ?>
      <h2>💦 残念…さんちゃんおこっ💢</h2>
      <img id="sanchan" src="images/sanchan_angry.png" alt="不正解のさんちゃん">
      <p class="angry-comment">「ぷんっ💢 次はがんばってよね！」</p>
    <?php else: ?>
      <h2>🐶 さんちゃんが準備中です…</h2>
    <?php endif; ?>

    <form action="index.php" method="get">
      <button type="submit">次の問題へ ▶</button>
    </form>
  </div>

  <script>
    window.addEventListener('load', () => {
      const img = document.getElementById('sanchan');
      if (img) setTimeout(() => img.classList.add('show'), 200);

      const isCorrect = <?= json_encode($last_result === 'correct'); ?>;
      const isWrong = <?= json_encode($last_result === 'wrong'); ?>;

      if (isCorrect) {
        launchConfetti();
        launchSparkles();
      }

      if (isWrong) {
        document.body.classList.add('shake');
        setTimeout(() => document.body.classList.remove('shake'), 600);
      }
    });

    // 🎊 ゆっくり紙吹雪
    function launchConfetti() {
      const colors = ['#a8f1bb', '#6fdba1', '#ffecb3', '#ffe4e1', '#b8f3c2'];
      const confettiCount = 100;
      for (let i = 0; i < confettiCount; i++) {
        const confetti = document.createElement('div');
        confetti.classList.add('confetti');
        confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
        confetti.style.left = Math.random() * 100 + 'vw';
        confetti.style.animationDuration = 5 + Math.random() * 4 + 's';
        confetti.style.opacity = 0.6 + Math.random() * 0.4;
        document.body.appendChild(confetti);
        setTimeout(() => confetti.remove(), 9000);
      }
    }

    // ✨ きらきら光エフェクト
    function launchSparkles() {
      for (let i = 0; i < 50; i++) {
        const sparkle = document.createElement('div');
        sparkle.classList.add('sparkle');
        sparkle.style.left = Math.random() * 100 + 'vw';
        sparkle.style.top = Math.random() * 100 + 'vh';
        sparkle.style.animationDelay = Math.random() * 3 + 's';
        document.body.appendChild(sparkle);
        setTimeout(() => sparkle.remove(), 5000);
      }
    }
  </script>
</body>
</html>

<?php
session_start();

$score = $_SESSION['score'] ?? 0;
$total = 10;
$wrong_answers = $_SESSION['wrong_answers'] ?? [];

// 結果ページ表示後にリセット
session_destroy();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>さんちゃんクイズ結果🐾</title>
  <style>
    body {
      font-family: "Noto Sans JP", sans-serif;
      text-align: center;
      background-color: #f9fff9;
      padding: 40px;
    }
    .result-box {
      background: #fff;
      display: inline-block;
      padding: 30px 40px;
      border-radius: 15px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }
    .score {
      font-size: 24px;
      font-weight: bold;
      margin: 20px 0;
    }
    ul {
      text-align: left;
      display: inline-block;
      margin-top: 20px;
    }
    li {
      margin-bottom: 15px;
      background: #f6fff6;
      border-left: 5px solid #86e4a8;
      padding: 10px;
      border-radius: 8px;
    }

    .progress-area {
  position: relative;
  width: 90%;
  max-width: 600px;
  margin: 40px auto;
  height: 30px;
}

.progress-line {
  position: absolute;
  top: 12px;
  left: 0;
  width: 100%;
  height: 6px;
  background: linear-gradient(90deg, #a2f1b6, #6fdba1);
  border-radius: 50px;
  box-shadow: inset 0 1px 3px rgba(0,0,0,0.15);
}

/* 🐶 さんちゃん座りポーズ */
.sanchan-sit {
  position: absolute;
  bottom: 5px;
  right: -20px; /* ←バーの端にちょこんと座る */
  width: 70px;
  opacity: 0;
  transform: translateY(20px);
  animation: sitDown 1.5s ease-out forwards;
}

/* ふわっと座るアニメーション */
@keyframes sitDown {
  0% {
    opacity: 0;
    transform: translateY(40px) rotate(-10deg);
  }
  60% {
    opacity: 1;
    transform: translateY(-8px) rotate(5deg);
  }
  100% {
    opacity: 1;
    transform: translateY(0) rotate(0);
  }
}

  </style>
</head>
<body>
  <div class="result-box">
    <h2>🐶 さんちゃんクイズ結果 🐶</h2>
    <p class="score"><?= $score ?> / <?= $total ?> 点</p>

    <?php if ($score >= 8): ?>
      <p>🎉 パーフェクト！さんちゃん博士！</p>
    <?php elseif ($score >= 6): ?>
      <p>✨ よくできました！さんちゃんもご満悦🐾</p>
    <?php else: ?>
      <p>💦 さんちゃん「まだまだ修行が必要だね…」</p>
    <?php endif; ?>

    <?php if (!empty($wrong_answers)): ?>
      <h3>🐾 間違えた問題と正解</h3>
      <ul>
        <?php foreach ($wrong_answers as $wrong): ?>
          <li>
            <strong>Q：</strong><?= htmlspecialchars($wrong['question'], ENT_QUOTES, 'UTF-8') ?><br>
            ❌ あなたの答え：<?= htmlspecialchars($wrong['your_answer'], ENT_QUOTES, 'UTF-8') ?><br>
            ✅ 正解：<?= htmlspecialchars($wrong['correct'], ENT_QUOTES, 'UTF-8') ?>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <button onclick="location.href='index.php'">もう一度挑戦する</button>
  </div>

  <div class="progress-area">
  <div class="progress-line"></div>
  <img src="images/sanchan_sit.png" alt="さんちゃん座りポーズ" class="sanchan-sit">
</div>

</body>
</html>

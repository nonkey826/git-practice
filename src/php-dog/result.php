<?php
session_start();

$score = $_SESSION['score'] ?? 0;
$total = 5;
$wrong_answers = $_SESSION['wrong_answers'] ?? [];

// 🟡 このタイミングで destroy すると、値がまだHTMLに渡る前なのでOK！
session_destroy();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>🐶 さんちゃんクイズ結果 🐾</title>
  <style>
    body {
      font-family: "Noto Sans JP", "Rounded Mplus 1c", sans-serif;
      background: linear-gradient(135deg, #fffaf5, #fdf6ff);
      color: #444;
      text-align: center;
      padding: 40px;
    }

    .result-box {
      background-color: #fff;
      display: inline-block;
      padding: 40px 50px;
      border-radius: 20px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      border: 4px solid #ffe1ef;
      max-width: 700px;
      transition: transform 0.3s ease;
    }

    .result-box:hover {
      transform: scale(1.02);
    }

    h2 {
      font-size: 28px;
      margin-bottom: 15px;
      color: #ff8fab;
    }

    .score {
      font-size: 26px;
      font-weight: bold;
      color: #ff5c8a;
      margin-bottom: 15px;
    }

    .message {
      font-size: 18px;
      line-height: 1.7;
      margin-bottom: 20px;
    }

    .wrong-list {
      text-align: left;
      background-color: #fffafc;
      border-radius: 15px;
      padding: 20px;
      margin-top: 30px;
      border: 2px dashed #ffb6c1;
    }

    .wrong-list h3 {
      color: #ff6b9d;
      font-size: 20px;
      margin-bottom: 10px;
      text-align: center;
    }

    .wrong-list li {
      margin-bottom: 18px;
      list-style-type: "🐾 ";
      line-height: 1.6;
    }

    button {
      background-color: #ff94c2;
      color: #fff;
      border: none;
      border-radius: 25px;
      padding: 12px 30px;
      cursor: pointer;
      font-size: 18px;
      font-weight: bold;
      margin-top: 25px;
      box-shadow: 0 3px 8px rgba(255, 148, 194, 0.4);
      transition: all 0.2s ease;
    }

    button:hover {
      background-color: #ffb6c1;
      transform: scale(1.05);
    }

    footer {
      margin-top: 40px;
      font-size: 14px;
      color: #999;
    }
  </style>
</head>

<body>
  <div class="result-box">
    <h2>🐶 さんちゃんクイズ結果 🐶</h2>
    <p class="score"><?= $score ?> / <?= $total ?> 点</p>

    <?php if ($score === 10): ?>
      <p>🎉 パーフェクト！あなたは さんちゃんピレニーズ博士！</p>

    <?php elseif ($score >= 8): ?>
      <p>✨ すごい！さんちゃん愛が伝わってきます🐾</p>

    <?php elseif ($score >= 6): ?>
      <p>💪 なかなかやるね！でも さんちゃんはまだ納得してないかも？</p>

    <?php else: ?>
      <p>😴 さんちゃん「まだまだ修行が必要だね…」</p>
    <?php endif; ?>

    <?php if (!empty($wrong_answers)): ?>
      <div class="wrong-list">
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
      </div>
    <?php endif; ?>

    <button onclick="location.href='index.php'">もう一度挑戦する</button>
  </div>
</body>
</html>

<!-- <?php
session_destroy();
?> -->

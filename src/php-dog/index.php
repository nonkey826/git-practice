<?
session_start();
require_once('config/pyr_data.php');

// 初回アクセス時の初期化
if (!isset($_SESSION['score'])) {
  $_SESSION['score'] = 0;
  $_SESSION['count'] = 0;
  $_SESSION['used_questions'] = []; // ← ここで必ず初期化！
}

// 10問終わったら結果ページへ
if ($_SESSION['count'] >= 10) {
  header('Location: result.php');
  exit;
}

// 🔹 未出題の問題だけ抽出（2番目の引数が必ず配列になるよう保証）
$available_indexes = array_diff(array_keys($pyr_data), $_SESSION['used_questions'] ?? []);

// 🔹 もし全て出題済みなら結果ページへ
if (empty($available_indexes)) {
  header('Location: result.php');
  exit;
}

// 🔹 未出題からランダム選択
$random_index = $available_indexes[array_rand($available_indexes)];
$question = $pyr_data[$random_index];

// 🔹 出題済みに追加
$_SESSION['used_questions'][] = $random_index;

// 🔹 現在の問題を保存
$_SESSION['current_answer'] = $question['answer'];
$_SESSION['current_question'] = $question['description'];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>🐾 さんちゃんクイズ 🐶</title>
  <style>
    body {
      font-family: "Noto Sans JP", "Rounded Mplus 1c", sans-serif;
      background: linear-gradient(135deg, #fffaf5, #fdf6ff);
      color: #444;
      text-align: center;
      padding: 40px;
    }

    h1 {
      color: #ff8fab;
      font-size: 32px;
      margin-bottom: 10px;
    }

    .sub {
      color: #ffb6c1;
      margin-bottom: 30px;
      font-size: 16px;
    }

    .quiz-box {
      background-color: #fff;
      max-width: 650px;
      margin: 0 auto;
      padding: 35px 40px;
      border-radius: 20px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      border: 4px solid #ffe1ef;
      text-align: left;
      transition: transform 0.3s ease;
    }

    .quiz-box:hover {
      transform: scale(1.02);
    }

    .question {
      font-size: 20px;
      margin-bottom: 20px;
      color: #ff6b9d;
      font-weight: bold;
    }

    label {
      display: block;
      margin-bottom: 12px;
      padding: 10px;
      border: 2px solid #ffd7e0;
      border-radius: 10px;
      transition: background 0.2s, transform 0.2s;
      cursor: pointer;
    }

    label:hover {
      background-color: #fff2f7;
      transform: scale(1.03);
    }

    input[type="radio"] {
      margin-right: 8px;
      transform: scale(1.2);
      accent-color: #ff94c2;
    }

    .submit-box {
      text-align: center;
      margin-top: 25px;
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
      box-shadow: 0 3px 8px rgba(255, 148, 194, 0.4);
      transition: all 0.2s ease;
    }

    button:hover {
      background-color: #ffb6c1;
      transform: scale(1.05);
    }

    footer {
      margin-top: 40px;
      color: #999;
      font-size: 14px;
    }
  </style>
</head>

<body>
  <h1>🐶 さんちゃんクイズ 🐾</h1>
  <p class="sub">第 <?= $_SESSION['count'] + 1 ?> 問目（全10問）</p>

  <div class="quiz-box">
    <p class="question">Q. <?= htmlspecialchars($question['description'], ENT_QUOTES, 'UTF-8') ?></p>

    <form action="check.php" method="post">
      <?php foreach ($question['choices'] as $choice): ?>
        <label>
          <input type="radio" name="option" value="<?= htmlspecialchars($choice, ENT_QUOTES, 'UTF-8') ?>" required>
          <?= htmlspecialchars($choice, ENT_QUOTES, 'UTF-8') ?>
        </label>
      <?php endforeach; ?>

      <div class="submit-box">
        <button type="submit">🐾 回答する 🐾</button>
      </div>
    </form>
  </div>

  <footer>
    <p>© さんちゃんクイズプロジェクト</p>
  </footer>
</body>
</html>

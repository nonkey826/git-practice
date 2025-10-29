<?php
session_start();
require_once(__DIR__ . '/config/pyr_data.php');

// ✅ セッションの初期化を確実に
if (!isset($_SESSION['score'])) {
  $_SESSION['score'] = 0;
}
if (!isset($_SESSION['count'])) {
  $_SESSION['count'] = 0;
}
if (!isset($_SESSION['used_questions']) || !is_array($_SESSION['used_questions'])) {
  $_SESSION['used_questions'] = []; // ← ここがポイント！
}

// 10問終わったら結果ページへ
if ($_SESSION['count'] >= 10) {
  header('Location: result.php');
  exit;
}

// 出題済みを除いてランダム取得
$unused_questions = array_diff(array_keys($pyr_data), $_SESSION['used_questions']);
if (empty($unused_questions)) {
  $_SESSION['used_questions'] = [];
  $unused_questions = array_keys($pyr_data);
}

$question_key = array_rand($unused_questions);
$question = $pyr_data[$question_key];

$_SESSION['used_questions'][] = $question_key;
$_SESSION['current_answer'] = $question['answer']; 
$_SESSION['current_question'] = $question['description'];

// 🐾 進捗％と現在の問題番号
$current_question = $_SESSION['count'] + 1;
$total_questions = 10;
$progress_percent = (($_SESSION['count']) / $total_questions) * 100;

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>グレートピレニーズ クイズ</title>
  <link rel="stylesheet" href="css/quiz.css">
  <style>
    /* 🐾 プログレスバー本体 */
    .progress-container {
      width: 90%;
      max-width: 600px;
      background: #e6f7eb;
      border-radius: 50px;
      margin: 25px auto 40px;
      height: 18px;
      box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
      position: relative;
      /* overflow: hidden; */
      overflow: visible; /* ←ここを変更！中身が隠れないようにする */
    }

    .progress-bar {
      height: 18px;
      border-radius: 50px;
      background: linear-gradient(90deg, #a2f1b6, #6fdba1);
      width: <?= $progress_percent ?>%;
      transition: width 0.6s ease;
      z-index: 1; /* 足跡より下 */
    }

    /* 🐾 足跡アイコン */
    .paw {
      position: absolute;
      top: -25px;
      left: calc(<?= $progress_percent ?>% - 15px);
      font-size: 1.6em;
      color: #76c893;
      transform: rotate(-10deg);
      animation: walk 1.2s ease-in-out infinite alternate;
    }

    @keyframes walk {
      0% { transform: translateY(0) rotate(-10deg); }
      50% { transform: translateY(-4px) rotate(-12deg); }
      100% { transform: translateY(0) rotate(-8deg); }
    }

    .progress-text {
      font-size: 15px;
      color: #4a4a4a;
      margin-bottom: 5px;
    }

  </style>
</head>

<body>
  <h1>🐾 グレートピレニーズ クイズ 🐾</h1>
  <p class="progress-text">第 <?= $current_question ?> 問（全 <?= $total_questions ?> 問）</p>

  <!-- 🌿 プログレスバー -->
  <div class="progress-container">
    <div class="progress-bar"></div>
    <div class="paw">🐾</div>
  </div>

  <div class="quiz__content">
    <p><strong>Q.</strong> <?= htmlspecialchars($question['description'], ENT_QUOTES, 'UTF-8') ?></p>

    <form action="check.php" method="post">
      <?php foreach ($question['choices'] as $choice): ?>
        <label>
          <input type="radio" name="option" value="<?= htmlspecialchars($choice, ENT_QUOTES, 'UTF-8') ?>" required>
          <?= htmlspecialchars($choice, ENT_QUOTES, 'UTF-8') ?>
        </label><br>
      <?php endforeach; ?>

      <div class="quiz-form__button">
        <button class="quiz-form__button-submit" type="submit">回答する</button>
      </div>
    </form>
  </div>
</body>
</html>

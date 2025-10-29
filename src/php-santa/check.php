<?php
session_start();

// ユーザーの回答と正解を取得
$user_answer = $_POST['option'];
$correct = $_SESSION['current_answer'] ?? '';
$question_text = $_SESSION['current_question'] ?? '';

// 不正解リストがまだなければ初期化
if (!isset($_SESSION['wrong_answers'])) {
  $_SESSION['wrong_answers'] = [];
}

// 採点処理
if ($user_answer === $correct) {
  $_SESSION['score']++;
  $_SESSION['last_result'] = 'correct';
} else {
  $_SESSION['last_result'] = 'wrong';

  // ❌ 不正解を記録
  $_SESSION['wrong_answers'][] = [
    'question' => $question_text,
    'your_answer' => $user_answer,
    'correct' => $correct
  ];
}

// 問題カウントを進める
$_SESSION['count']++;

// 全10問終了したら結果へ
if ($_SESSION['count'] >= 10) {
  header('Location: result.php');
  exit;
}

// まだ続く場合 → フィードバックページへ
header('Location: feedback.php');
exit;
?>

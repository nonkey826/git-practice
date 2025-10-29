<?php
session_start();

// ユーザーの回答と正解を取得
$user_answer = $_POST['option'];
$correct = $_SESSION['current_answer'];
$question_text = $_SESSION['current_question']; // 問題文も保存

// 採点
if ($user_answer === $correct) {
  $_SESSION['score']++;
} else {
  // ❌ 不正解のときだけ記録する！
  if (!isset($_SESSION['wrong_answers'])) {
    $_SESSION['wrong_answers'] = [];
  }
  $_SESSION['wrong_answers'][] = [
    'question' => $question_text,
    'your_answer' => $user_answer,
    'correct' => $correct
  ];
}

$_SESSION['count']++;

// 5問終わったら結果ページへ
if ($_SESSION['count'] >= 10) {
  header('Location: result.php');
  exit;
}

// 続く場合は次の問題へ
header('Location: index.php');
exit;
?>

<?php
require_once('functions/search_city_time.php');

$tokyo = searchCityTime('東京');
$city = isset($_GET['city']) ? htmlspecialchars($_GET['city'], ENT_QUOTES) : null;
$comparison = $city ? searchCityTime($city) : null;
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>World Clock</title>
  <link rel="stylesheet" href="css/sanitize.css">
  <link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/result.css">
</head>

<body>

<main>

<header class="header">
    <div class="header__inner">
      <a class="header__logo" href="/php02/index.php">
        World Clock
      </a>
    </div>
  </header>
    <div class="result-cards">
<!-- 東京 -->
<div class="result-card">
  <img class="result-card__img" src="img/national_flag_img/<?= $tokyo['img'] ?>" alt="東京の国旗">
  <p><?= $tokyo['name'] ?>の時刻：<?= $tokyo['time'] ?></p>
</div>

<!-- 選ばれた都市 -->
<div class="result-card">
  <img class="result-card__img" src="img/national_flag_img/<?= $comparison['img'] ?>" alt="<?= $comparison['name'] ?>の国旗">
  <p><?= $comparison['name'] ?>の時刻：<?= $comparison['time'] ?></p>
</div>
</div>
<div class="centered">
<p><?= $comparison['name'] ?>の時刻：<?= $comparison['time'] ?></p>
<p>東京との時差：<?= $comparison['diff'] ?>時間</p>
</div>
  </main>

  
</body>

</html>

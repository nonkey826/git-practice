<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>世界時計</title>

<link rel="stylesheet" href="css/sanitize.css">
<link rel="stylesheet" href="css/common.css">
<link rel="stylesheet" href="css/index.css">

</head>
<body>
    <header class="header">
    <div class="header__inner">
      <a class="header__logo" href="/php02/index.php">
        World Clock
      </a>
    </div>
  </header>

  <main>
  <div class="search-form__content">
<div class="search-form__heading">
       <h2 class="search-form__content-title">日本と世界の時間を比較</h2>


<?php
        date_default_timezone_set('Asia/Tokyo');
        $time = date("H:i:s");
        $date = date("Y年m月d日");
        $weekday = date("l");
        $weekdays = [
          "Monday" => "月曜日",
          "Tuesday" => "火曜日",
          "Wednesday" => "水曜日",
          "Thursday" => "木曜日",
          "Friday" => "金曜日",
          "Saturday" => "土曜日",
          "Sunday" => "日曜日"
        ];
        $weekday_jp = $weekdays[$weekday];
        
      ?>
<!-- <div class="clock-box">
  <p class="clock-time">現在の時刻：<?= $time ?></p>
  <p class="clock-date">今日の日付：<?= $date ?>（<?= $weekday_jp ?>）</p>
</div> -->

<div id="js-clock" class="clock-box"></div>


<form class="search-form" action="result.php" method="get">
   <div class="search-form__item">
    <select class="search-form__item-select" name="city">
       <option value="シドニー">シドニー</option>
  
       <option value="上海">上海</option>
       <option value="モスクワ">モスクワ</option>
       <option value="ロンドン">ロンドン</option>
       <option value="ヨハネスブルグ">ヨハネスブルグ</option>
       <option value="ニューヨーク">ニューヨーク</option>
     </select>
   </div>
   <div class="search-form__button">
    <button class="search-form__button-submit" type="submit">検索</button>
   </div>
</form>
</form>

</div>
</div>
 </main>
    <script>
  function updateClock() {
    const now = new Date();
    const time = now.toLocaleTimeString('ja-JP');
    const date = now.toLocaleDateString('ja-JP', { year: 'numeric', month: 'long', day: 'numeric' });
    const weekday = now.toLocaleDateString('ja-JP', { weekday: 'long' });

    document.getElementById('js-clock').innerHTML = `
      <p class="clock-time">現在の時刻：${time}</p>
      <p class="clock-date">今日の日付：${date}（${weekday}）</p>
    `;
  }

  setInterval(updateClock, 1000); // 毎秒更新
  updateClock(); // 最初の1回
</script>

</body>
</html>
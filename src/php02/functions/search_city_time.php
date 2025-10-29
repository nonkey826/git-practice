<?php



function searchCityTime($city_name)
{
  require(__DIR__ . '/../config/cities.php');

  $flags = [
    "東京" => "japan.jpg",
    "シドニー" => "australia.jpg",
    "上海" => "china.png",
    "モスクワ" => "russia.jpg",
    "ロンドン" => "uk.jpg",
    "ヨハネスブルグ" => "south_africa.jpg",
    "ニューヨーク" => "usa.jpg"
  ];

  foreach ($cities as $city) {
    // if ($city['name'] === $city_name) {
    //   $date_time = new DateTime('', new DateTimeZone($city['time_zone']));
      

    if ($city['name'] === $city_name) {
      $date_time = new DateTime('', new DateTimeZone($city['time_zone']));
      $time = $date_time->format('Y年m月d日 H:i:s');
      $tokyo_time = new DateTime('', new DateTimeZone('Asia/Tokyo'));

      // 時差（秒単位）を計算
      $diff_seconds = $date_time->getOffset() - $tokyo_time->getOffset();
      $diff_hours = $diff_seconds / 3600;

      $weekdays = [
        "Monday" => "月曜日",
        "Tuesday" => "火曜日",
        "Wednesday" => "水曜日",
        "Thursday" => "木曜日",
        "Friday" => "金曜日",
        "Saturday" => "土曜日",
        "Sunday" => "日曜日"
      ];
      $weekday = $weekdays[$date_time->format('l')];

         return [
        "name" => $city['name'],
        "time" => $time . "（" . $weekday . "）",
        "img" => $city['img'],
        "diff" => $diff_hours // ← ここがポイント！
      ];
    }
  }

  return [
    "name" => $city_name,
    "time" => "取得できませんでした",
    "img" => "unknown.png",
    "diff" => $diff_hours // ← これが追加
  ];
}

// function searchCityTime($city_name)
// {
//   require(__DIR__ . '/../config/cities.php');

//   foreach ($cities as $city) {
//     if ($city['name'] === $city_name) {
//       $date_time = new DateTime('', new DateTimeZone($city['time_zone']));
//       $time = $date_time->format('H:i');
//       $city['time'] = $time;
//       return $city;
//     }
//   }

//   return null; 
// }


// function searchCityTime($city) {
//   $timezones = [
//     "東京" => "Asia/Tokyo",
//     "シドニー" => "Australia/Sydney",
//     "上海" => "Asia/Shanghai",
//     "モスクワ" => "Europe/Moscow",
//     "ロンドン" => "Europe/London",
//     "ヨハネスブルグ" => "Africa/Johannesburg",
//     "ニューヨーク" => "America/New_York"
//   ];

//   $flags = [
//     "東京" => "japan.png",
//     "シドニー" => "australia.png",
//     "上海" => "china.png",
//     "モスクワ" => "russia.png",
//     "ロンドン" => "uk.png",
//     "ヨハネスブルグ" => "south_africa.png",
//     "ニューヨーク" => "usa.png"
//   ];

//   $weekdays = [
//     "Monday" => "月曜日",
//     "Tuesday" => "火曜日",
//     "Wednesday" => "水曜日",
//     "Thursday" => "木曜日",
//     "Friday" => "金曜日",
//     "Saturday" => "土曜日",
//     "Sunday" => "日曜日"
//   ];

//   if (!array_key_exists($city, $timezones)) {
//     return [
//       "name" => $city,
//       "time" => "取得できませんでした",
//       "img" => "unknown.png"
//     ];
//   }

//   date_default_timezone_set($timezones[$city]);
//   $time = date("Y年m月d日 H:i:s");
//   $weekday = $weekdays[date("l")];

//   return [
//     "name" => $city,
//     "time" => $time . "（" . $weekday . "）",
//     "img" => $flags[$city]
//   ];
// }


<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/var/autoload.php';
$path = key($_GET);


$fn = './client/pages/'.$path.'/index.php';


$titles = [
  "statistics" => "Statistics",
  "payouts" => "Payouts",
  "settings" => "Settings",
  "manuals" => "Manuals",
  "login" => "Authorization",
  "signup" => "Sign up",
  "content" => "Content",
  "admin" => "Admin Panel",
];

if ($titles[$path]) {
  $title = $titles[$path];
  if ($_GET['content_type']) {
    $_GET['content_type'][0] = strtoupper($_GET['content_type'][0]);
    $ctype = $_GET['content_type'];
    $result = $db->query("SELECT * FROM `categories` WHERE `title_eng` = '$ctype'");
    if ($result->num_rows > 0) {
      $contentType = $_GET['content_type'];
      $contentFilter = $result->fetch_assoc()['id'];
    }
  }
} else {
  $title = '404';
}


if (empty($_SESSION['user'])) {
  if ($path == 'signup') {
    require './client/components/header.php';
    require $fn;
  } else if ($path == 'login') {
    require './client/components/header.php';
    require $fn;
  } else {
    header('Location: /login');
  }
} else {
  if ($_SESSION['user']) {
    $emailAddress = $_SESSION['user'];
    $res = $db->query("SELECT * FROM `users` WHERE `email` = '$emailAddress'");
    if ($res->num_rows > 0 ) {
        $user = $res->fetch_assoc();
        $userApiToken = $user['api_access_token'];
        $userIframeToken = $user['iframe_token'];
        $userTypeId = $user['user_type_id'];
        $userType = $db->query("SELECT `name` FROM `user_types` WHERE `id` = '$userTypeId'")->fetch_assoc()['name'];
        $userEmail = $user['email'];
        $userTg = $user['telegram_username'];
        $userBlockTime = $user['block_time'];
        $userWallet = $user['wallet'];
    }
  }
  $timeNow = time();
  if ($userBlockTime) {
    if ($timeNow < $userBlockTime) {
      header('Location: /login');
      unset($_SESSION['user']);
    }
  }
  if ($path == '') {
    //uncomment this to make index page available
    //$fn = './client/pages/index/index.php';
    //require './client/components/header.php';
    header('Location: /content');
    (file_exists($fn)) ? require $fn : require './client/pages/404/index.php';
  } elseif ($path == 'admin') {
    if ($userType == 'admin') {
      require './client/components/header.php';
      (file_exists($fn)) ? require $fn : require './client/pages/404/index.php';
    } else {
      header('Location: /content');
    }
  } else {
    require './client/components/header.php';
    (file_exists($fn)) ? require $fn : require './client/pages/404/index.php';
  }
}

?>


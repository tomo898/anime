<?php
session_start();
require_once(ROOT_PATH .'/Controllers/AnimeController.php');
$anime = new AnimeController();
$anime->contactsdelete();
?>
<!DOCTYPE html>
<html lang="jp" >
  <head>
    <meta charset="utf-8">
    <title>Lesson Sample Site</title>
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/js/style.js"></script>
  </head>
  <body>
    <div class="body">
      <div class="login-container">
        <div class="login-title">
          <p>削除しました</p>
        </div>
        <div class="my-link">
          <a href="mypage.php">マイページへ</a>
        </div>
      </div>
    </div>
  </body>
</html>

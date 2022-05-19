<?php
session_start();
require_once(ROOT_PATH .'/Controllers/AnimeController.php');
$anime = new AnimeController();
$user = $_SESSION['user_id'];
$animes = $anime -> mypage($user);
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
    <?php include('header.php'); ?>
    <div class="index-con">
      <div class="nav">
        <div class="nav-box">
          <a href="index.php">最新レビュー</a>
        </div>
        <div class="nav-box underline">
          <p>マイページ</p>
        </div>
        <div class="nav-box">
          <a href="iine.php">いいね一覧</a>
        </div>
      </div>
    </div>
    <?php foreach ($animes['reviews'] as $reviews): ?>
      <div class="index-body3">
        <div class="index-body2">
          <div class="index-img">
            <img src='<?=$reviews['file_path'] ?>' class="in-img">
          </div>
          <div class="index-main">
            <div class="boxtop">
              <div class="boxtop2">
                <div class="boxtop3">
                  <p>満足度：</p>
                  <p><?=$reviews['recommended'] ?></p>
                  <p class="anime-title"><?=$reviews['title'] ?></p>
                </div>

              </div>
              <div class="point">
                <div class="point-1">
                  <p>ストーリー</p>
                  <p class="point-2"><?=$reviews['story_pt'] ?></p>
                </div>
                <div class="point-1">
                  <p>作画</p>
                  <p class="point-2"><?=$reviews['pictures_pt'] ?></p>
                </div>
                <div class="point-1">
                  <p>音楽</p>
                  <p class="point-2"><?=$reviews['music_pt'] ?></p>
                </div>
                <div class="point-1">
                  <p>キャラクター</p>
                  <p class="point-2"><?=$reviews['character_pt'] ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="myoverview">
          <p>感想・概要</p>
          <p class=""><?= nl2br($reviews['overview']) ?></p>
        </div>
        <div class="btn-box">
          <a class="delete-btn" href="delete.php?id=<?php echo $reviews['id'] ?>">削除</a>
          <p class="white"><a class="edit-btn" href="edit.php?id=<?php echo $reviews['id'] ?>">編集</a></p>
        </div>
      </div>
    <?php endforeach; ?>
  </body>
</html>

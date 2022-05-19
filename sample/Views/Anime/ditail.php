<?php
session_start();
require_once(ROOT_PATH .'/Controllers/AnimeController.php');
$anime = new AnimeController();
$user = $_SESSION['user_id'];
$animes = $anime -> reviewsFindId($_GET['id']);
$good = $anime -> favolite($user,$animes['review']['id']);

if(isset($_POST["favorite"])){
  header("Location: index.php");
};

if(isset($_POST['user'])){
    $anime -> favolite2($user,$animes);
    var_dump($_POST['user']);
};


?>

<!DOCTYPE html>
<html lang="jp" >
  <head>
    <meta charset="utf-8">
    <title>Lesson Sample Site</title>
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="/js/style.js"></script>
    <script>
    function count(){
  var thisCount = $("#count").html();
      thisCount = Number(thisCount);
      thisCount = thisCount + 1;
  $("#count").html(thisCount);
};

$(document).on('click','.i',function(e){
    e.stopPropagation();
    var $this = $(this);
        var user = 'いいね' ;
    $.ajax({
        type: 'POST',
        url: 'ditail.php?id=<?php echo $_GET['id'] ?>',
        data: { user: user}
    }).done(function(data){

    }).fail(function() {

    });
  });
    </script>
  </head>
  <body>
    <?php include('header.php'); ?>
    <div class="index-con">
      <div class="nav">
        <div class="underline nav-box">
          <p>詳細ページ</p>
        </div>
      </div>
    </div>
    <div class="index-body3">
      <div class="index-body2">
        <div class="index-img">
          <img src='<?=$animes['review']['file_path'] ?>' class="in-img">
        </div>
        <div class="index-main">
          <div class="boxtop">
            <div class="boxtop4">
              <div class="boxtop3">
                <p>満足度：</p>
                <p><?=$animes['review']['recommended'] ?></p>
                <p class="anime-title"><?=$animes['review']['title'] ?></p>
              </div>
              <div class="i-box">
                <div class="ii">
                  <input type="button" value="いいね" onClick="count();" class="i" name='user'>
                </div>
                <div class="">
                  <p id="count"><?php
                      $good = $anime -> index2($animes['review']['id'],$animes['review']['user_id']);
                      echo $good["goods"];
                      ?></p>
                </div>
              </div>
            </div>
            <div class="point">
              <div class="point-1">
                <p>ストーリー</p>
                <p class="point-2"><?=$animes['review']['story_pt'] ?></p>
              </div>
              <div class="point-1">
                <p>作画</p>
                <p class="point-2"><?=$animes['review']['pictures_pt'] ?></p>
              </div>
              <div class="point-1">
                <p>音楽</p>
                <p class="point-2"><?=$animes['review']['music_pt'] ?></p>
              </div>
              <div class="point-1">
                <p>キャラクター</p>
                <p class="point-2"><?=$animes['review']['character_pt'] ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="myoverview">
        <p>感想・概要</p>
        <p class=""><?= nl2br($animes['review']['overview']) ?></p>
      </div>

      <div class="f-box">
        <form class="favorite_count" action="#" method="post">
          <input type="hidden" name="post_id">
          <input type="submit" name="favorite" class="favorite_btn" value="戻る">
        </form>
      </div>
    </div>
  </body>
</html>

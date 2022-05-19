<?php
session_start();
require_once(ROOT_PATH .'/Controllers/AnimeController.php');
$anime = new AnimeController();
$updateId = $anime -> reviewsFindId($_GET['id']);
$id = $updateId['review']['id'];
if(!empty($updateId['review']['title'])) {
   $post['title'] = $updateId['review']['title'];
}
if(!empty($updateId['review']['overview'])) {
   $post['overview'] = $updateId['review']['overview'];
}
//バリデーション
$error['title']='';
$error['recommended']='';
$error['story_pt']='';
$error['pictures_pt']='';
$error['music_pt']='';
$error['character_pt']='';
$error['category']='';
$error['overview']='';
$error['img']= '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $file = $_FILES['img'];
  $filename = basename($file['name']);
  $tmp_path = $file['tmp_name'];
  $file_err = $file['error'];
  $filesize = $file['size'];
  $upload_dir ='./img/';
  $upload_dir2 ='/img/';
  $save_filename = date('YmdHis').$filename;
  $save_path = $upload_dir.$save_filename;
  $save_path2 = $upload_dir2.$save_filename;
  $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  if ($post['title'] ==='') {
    $error['title'] = 'bk';
  }
  if ( !preg_match( '/^[1-5]+$/', $post['recommended'] )){
    $error['recommended'] = 'bk';
  }
  if ( !preg_match( '/^[1-5]+$/', $post['story_pt'] )){
    $error['story_pt'] = 'bk';
  }
  if ( !preg_match( '/^[1-5]+$/', $post['pictures_pt'] )){
    $error['pictures_pt'] = 'bk';
  }
  if ( !preg_match( '/^[1-5]+$/', $post['music_pt'] )){
    $error['music_pt'] = 'bk';
  }
  if ( !preg_match( '/^[1-5]+$/', $post['character_pt'] )){
    $error['character_pt'] = 'bk';
  }
//画像バリデーション
  if( $filesize > 1048576 || $file_err == 2){
    $error['img'] = 'bk';
  }
  $allow_ext = array('jpg', 'jpeg', 'png');
  $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
  if (!in_array(strtolower($file_ext), $allow_ext)) {
    $error['img'] = 'bk';
  }
  if(!is_uploaded_file($tmp_path)){
    $error['img'] = 'bk';
  }
  if ( $post['category']!='SF/ファンタジー' && $post['category']!='コメディ' && $post['category']!='恋愛' && $post['category']!='日常' && $post['category']!='ロボット' && $post['category']!='バトル/アクション' && $post['category']!='スポーツ' && $post['category']!='その他'){
    $error['category'] = 'bk';
  }

  if (empty($error['title']) && empty($error['recommended']) && empty($error['story_pt']) && empty($error['pictures_pt']) && empty($error['music_pt']) && empty($error['character_pt']) && empty($error['category']) && empty($error['img'])){
    move_uploaded_file($tmp_path, $save_path);
    $anime -> reviewsFindIdEdit($filename, $save_path2);
    header("Location: mypage.php");
    exit;
  }
};
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
    <div class="post-tl">
      <p>投稿</p>
    </div>
    <div class="container">
      <form class="newpost-body" action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <div class="newpost-container">
          <div class="file">
            <div class="">
              <input type="hidden" name="MAX_FILE_SIZE" value="1048576">
              <input type="file" name="img" value="image/*">
            </div>
            <div class="">
              <?php if($error['title']==="bk") :?>
                <p class="error">画像を選択してください。<br>もしくは画像ファイルが大きすぎます。</p>
              <?php endif; ?>
            </div>
          </div>
          <div class="post-main">
            <div class="post-ditail">
              <div class="p-tl">
                <p>タイトル：</p>
              </div>
              <div class="p-box">
                <input type="text" class="newpost-box" id="title" name="title" value="<?php if( !empty($post['title']) ){ echo htmlspecialchars($post['title'],ENT_QUOTES, "UTF-8"); } ?>">
                <?php if($error['title']==="bk") :?>
                  <p class="error">タイトルは必須入力です。</p>
                <?php endif; ?>
              </div>
            </div>
            <div class="post-ditail2">
              <div class="p-select">
                <div class="p-tl">
                  <p>満足度：</p>
                </div>
                <select class="p-box2" name="recommended">
                  <option value="" selected>選択してください</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
                <?php if($error['recommended']==="bk") :?>
                  <p class="error">選択してください。</p>
                <?php endif; ?>
              </div>
              <div class="p-select">
                <div class="p-tl">
                  <p>ストーリー：</p>
                </div>
                <select class="p-box2" name="story_pt">
                  <option value="" selected>選択してください</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
                <?php if($error['story_pt']==="bk") :?>
                  <p class="error">選択してください。</p>
                <?php endif; ?>
              </div>
              <div class="p-select">
                <div class="p-tl">
                  <p>作画：</p>
                </div>
                <select class="p-box2" name="pictures_pt">
                  <option value="" selected>選択してください</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
                <?php if($error['pictures_pt']==="bk") :?>
                  <p class="error">選択してください。</p>
                <?php endif; ?>
              </div>
              <div class="p-select">
                <div class="p-tl">
                  <p>音楽：</p>
                </div>
                <select class="p-box2" name="music_pt">
                  <option value="" selected>選択してください</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
                <?php if($error['music_pt']==="bk") :?>
                  <p class="error">選択してください。</p>
                <?php endif; ?>
              </div>
              <div class="p-select">
                <div class="p-tl">
                  <p>キャラクター：</p>
                </div>
                <select class="p-box2" name="character_pt">
                  <option value="" selected>選択してください</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
                <?php if($error['character_pt']==="bk") :?>
                  <p class="error">選択してください。</p>
                <?php endif; ?>
              </div>
              <div class="p-select">
                <div class="p-tl">
                  <p>カテゴリー：</p>
                </div>
                <select class="p-box2" name="category">
                  <option value="" selected>選択してください</option>
                  <option value="SF/ファンタジー">SF/ファンタジー</option>
                  <option value="コメディ">コメディ</option>
                  <option value="恋愛">恋愛</option>
                  <option value="日常">日常</option>
                  <option value="ロボット">ロボット</option>
                  <option value="バトル/アクション">バトル/アクション</option>
                  <option value="スポーツ">スポーツ</option>
                  <option value="推理/ホラー">推理/ホラー</option>
                  <option value="その他">その他</option>
                </select>
                <?php if($error['category']==="bk") :?>
                  <p class="error">選択してください。</p>
                <?php endif; ?>
              </div>
              <div class="overview-tl">
                <p>概要・感想</p>
              </div>
              <textarea class="overview" name="overview" id="overview"><?php if( !empty($post['overview']) ){ echo htmlspecialchars($post['overview'],ENT_QUOTES, "UTF-8"); } ?></textarea>
            </div>
          </div>
        </div>
        <div class="btn-box">
          <input type="button" onclick="history.back()" class="btn-back" value="キャンセル">
          <input type="submit" name="login-btn" class="next-btn" value="投稿">
        </div>
      </form>
    </div>
  </body>
</html>

<?php
session_start();

require_once(ROOT_PATH .'/Controllers/AnimeController.php');
$anime = new AnimeController();
//バリデーション
$error['id']='';
$error['name']='';
$error['password']='';
$error['passwordConf']='';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  if ($post['id'] ==='') {
    $error['id'] = 'bk';
  }
  if ($post['name'] ==='') {
    $error['name'] = 'bk';
  }
  if (!preg_match("/\A[a-z\d]{8,100}+\z/i",$post['password'])) {
    $error['password'] = 'bk';
  }
  if ($post['password'] !== $post['passwordConf']) {
    $error['passwordConf'] = 'bk';
  }
  if (empty($error['id']) && empty($error['name']) && empty($error['password']) && empty($error['passwordConf']) ){
    $errorUserId = $anime -> newUser($_POST['id']);
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
    <div class="body">
      <div class="newUser-container">
        <div class="login-title">
          <p>新規登録</p>
        </div>
        <div class="ditail">
          <p class="detail">＊すべて必須項目です</p>
          <p class="detail">＊パスワードは8文字以上の英数字で</p>
        </div>
        <div class="login-form">
          <form class="login-formbox" action="" method="post">
            <div class="new-input">
              <?php if($error['id']==="bk") :?>
                <p class="error">IDは必須入力です。</p>
              <?php endif; ?>
              <?php if(isset($errorUserId['failed'])): ?>
                <p class="error"><?=$errorUserId['failed']?></p>
              <?php endif; ?>
              <input type="text" name="id" class="input" placeholder="ID" value="<?php if( !empty($post['id']) ){ echo htmlspecialchars($post['id'],ENT_QUOTES, "UTF-8"); } ?>">
            </div>
            <div class="new-input">
              <?php if($error['name']==="bk") :?>
                <p class="error">ニックネームは必須入力です。</p>
              <?php endif; ?>
              <input type="text" name="name" class="input" placeholder="ニックネーム" value="<?php if( !empty($post['name']) ){ echo htmlspecialchars($post['name'],ENT_QUOTES, "UTF-8"); } ?>">
            </div>
            <div class="new-input">
              <?php if($error['password']==="bk") :?>
                <p class="error">パスワードは8文字以上の英数字で入力してください。</p>
              <?php endif; ?>
              <input type="password" name="password" class="input" placeholder="パスワード" value="<?php if( !empty($post['password']) ){ echo htmlspecialchars($post['password'],ENT_QUOTES, "UTF-8"); } ?>">
            </div>
            <div class="new-input">
              <?php if($error['passwordConf']==="bk") :?>
                <p class="error">パスワードと異なっています。</p>
              <?php endif; ?>
              <input type="password" name="passwordConf" class="input" placeholder="確認用パスワード" value="<?php if( !empty($post['passwordConf']) ){ echo htmlspecialchars($post['passwordConf'],ENT_QUOTES, "UTF-8"); } ?>">
            </div>
            <div class="btn-box">
              <input type="button" onclick="history.back()" class="btn-back" value="キャンセル">
              <input type="submit" name="login-btn" class="next-btn" value="登録">
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>

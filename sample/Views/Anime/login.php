<?php
session_start();
require_once(ROOT_PATH .'/Controllers/AnimeController.php');
$anime = new AnimeController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  $loginError = $anime -> login($post["id"], $post["password"]);
}
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
          <p>ログイン</p>
        </div>
        <div >
          <?php if(isset($loginError['failed'])): ?>
            <p class="error-log"><?=$loginError['failed']?></p>
          <?php endif; ?>
        </div>
        <div class="login-form">
          <form class="login-formbox" action="" method="post">
            <p>
              <input type="text" name="id" class="input" placeholder="ID" value="<?php if( !empty($_POST['id']) ){ echo htmlspecialchars($_POST['id'],ENT_QUOTES, "UTF-8"); } ?>">
            </p>
            <p>
              <input type="password" name="password" class="input" placeholder="パスワード" value="<?php if( !empty($_POST['password']) ){ echo htmlspecialchars($_POST['password'],ENT_QUOTES, "UTF-8"); } ?>">
            </p>
            <div class="lo-btnbox">
              <input type="submit" name="login-btn" class="login-btn" value="ログイン">
            </div>
          </form>
        </div>
        <div class="kochira">
          <p>アカウントをお持ちでない方は<a href="newuser.php">こちら</a></p>
        </div>
        <div class="kochira">
          <p>パスワードを忘れた方は<a href="passwordreset.php">こちら</a></p>
        </div>
      </div>
    </div>
  </body>
</html>

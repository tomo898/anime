<?php
require_once(ROOT_PATH .'/Models/Users.php');
require_once(ROOT_PATH .'/Models/Reviews.php');
require_once(ROOT_PATH .'/Models/goods.php');
class AnimeController {
  private $request;//リクエストパラメータ（GET,POST)
  private $Users;

  public function __construct() {
    $this->request['get'] = $_GET;
    $this->request['post'] = $_POST;

    //モデルオブジェクトの生成
    $this->Users = new Users();
    $dbh = $this->Users->get_db_handler();
    $this->Reviews = new Reviews($dbh);
    $this->Goods = new Goods($dbh);
  }

//新規登録 同アカウントチェック
  public function newUser($id) {
  $error = [];
  $newUser = $this->Users->checkuser($id);
  if($newUser != false) {
    $error['failed'] = 'すでに同じIDがあります。';
    return $error;
  } else {
    $this -> user();
    header('Location: newusercomp.php');
    exit;
  }
  }

//ユーザー登録
  public function user() {
  $userCreat = $this->Users->userCreat();
  return $userCreat;
  }

//ログイン機能
  public function login($id, $password) {
  $error = [];
  $login = $this->Users->checkuser($id);
  if($login != false) {
    if(password_verify($password, $login["password"])) {
      $_SESSION['user_id'] = $login['user_id'];
      $_SESSION['name'] = $login['name'];
      header('Location: index.php');
    } else {
      $error['failed'] = 'パスワードが正しくありません。';
      return $error;
    }
  } else {
    $error['failed'] = 'IDが正しくありません。';
    return $error;
  }
  }

//パスワードリセット
  public function reset($id) {
  $error = [];
  $user = $this->Users->checkuser($id);
  if($user != false) {
    $this -> Users -> reset($id);
    header('Location: passwordresetcomp.php');
  } else {
    $error['failed'] = 'IDが正しくありません。';
    return $error;
  }
  }

//投稿
  public function Update($filename, $save_path) {
  $update = $this->Reviews->update($filename, $save_path);
  return $update;
  }

//一覧
  public function index() {
  $page = 0;
  if(isset($this->request['get']['page'])) {
    $page = $this->request['get']['page'];
  }
  $reviews = $this->Reviews->findAll($page);
  $reviews_count = $this->Reviews->countAll();
  $animes = [
    'reviews' => $reviews,
    'pages' => $reviews_count / 20,
  ];
  return $animes;
  }

  //一覧いいね
    public function index2($id ,$user_id) {
    $goods_count = $this->Goods->countiine($id,$user_id);
    $good = [
      'goods' => $goods_count
    ];
    return $good;
    }

//マイページ一覧
  public function mypage($user) {
  $page = 0;
  if(isset($this->request['get']['page'])) {
    $page = $this->request['get']['page'];
  }
  $reviews = $this->Reviews->findmypage($user);
  $reviews_count = $this->Reviews->countmypage();
  $animes = [
    'reviews' => $reviews,
    'pages' => $reviews_count / 20
  ];
  return $animes;
  }

//編集取得
  public function reviewsFindId(){
  if(empty($this->request['get']['id']))  {
  echo '指定のパラメータが不正です。このページを表示できません。';
  exit;
  }
  $updateId = $this->Reviews->findById($this->request['get']['id']);
  $animes = [
    'review' => $updateId
  ];
  return $animes;
}

//編集
  public function reviewsFindIdEdit($filename, $save_path2){
  $editId = $this->Reviews->editId($filename, $save_path2);
  return $editId;
  }

//削除
  public function contactsdelete(){
  if(empty($this->request['get']['id']))  {
    echo '指定のパラメータが不正です。このページを表示できません。';
    exit;
  }
    $delete = $this->Reviews->delete($this->request['get']['id']);
  }

//いいね
  public function favolite($user,$post_id){
  $good = $this->Goods->check_favolite_duplicate($user,$post_id);
  return $good;
  }

//いいね
  public function favolite2($user,$animes){
    $goods = $this->Goods->check_favolite_duplicate3($user,$animes);
  }

//いいね一覧
  public function iine($user){
  $goods = $this->Goods->iineview($user);
  $animes = [
    'reviews' => $goods
  ];
  return $animes;
  }
}

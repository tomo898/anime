<?php
require_once(ROOT_PATH .'/Models/Db.php');

class Users extends Db{
  private $table = 'users';

  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }

//ユーザーチェック
  public function checkuser($id) {
  $sql = "SELECT * FROM users WHERE user_id = :user_id ";
  $sth = $this->dbh->prepare($sql);
  $sth->bindParam(':user_id', $id, PDO::PARAM_STR);
  $sth->execute();
  $result = $sth->fetch(PDO::FETCH_ASSOC);
  return $result;
  }

//ユーザー登録
  public function userCreat() {
    $this -> dbh -> beginTransaction();//トランザクション
    $created_at = date('Y/m/d H:i:s');
    $sql ='INSERT INTO users (user_id,name,password) VALUES (:user_id, :name, :password)';
    $sth = $this->dbh->prepare($sql);
    try {
      $sth -> bindParam(':user_id',$_POST['id'], PDO::PARAM_STR);
      $sth -> bindParam(':name', $_POST['name'], PDO::PARAM_STR);
      $sth -> bindParam(':password', password_hash($_POST['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
      $sth->execute();
      $this -> dbh -> commit();
    } catch(PDOException $e){
      $this -> dbh -> rollBack();
      exit($e);
    }
  }

//ログイン
  public function checkLogin($id) {
    $sql = "SELECT * FROM users WHERE user_id = :user_id ";
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':user_id', $id, PDO::PARAM_STR);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

//パスワードリセット
  public function reset($id) {
    $this -> dbh -> beginTransaction();//トランザクション
    $sql ='UPDATE users SET password=:password WHERE user_id = :id';
    $sth = $this->dbh->prepare($sql);
    try {
      $sth -> bindParam(':id',$id, PDO::PARAM_STR);
      $sth -> bindParam(':password', password_hash($_POST['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
      $sth->execute();
      $this -> dbh -> commit();
    } catch(PDOException $e){
      $this -> dbh -> rollBack();
      exit($e);
    }
  }

}

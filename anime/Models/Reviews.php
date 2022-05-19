<?php
require_once(ROOT_PATH .'/Models/Db.php');

class Reviews extends Db{
  private $table = 'reviews';

  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }
//投稿
  public function update($filename, $save_path) {
  $this -> dbh -> beginTransaction();//トランザクション
  $created_at = date('Y/m/d H:i:s');
  $sql ='INSERT INTO reviews (user_id, title, recommended, story_pt, pictures_pt, music_pt, character_pt, category, overview, file_name, file_path) VALUES (:user_id, :title, :recommended, :story_pt, :pictures_pt, :music_pt, :character_pt, :category, :overview, :file_name, :file_path)';
  $sth = $this->dbh->prepare($sql);
  try {
    $sth -> bindParam(':user_id', $_SESSION['user_id'] , PDO::PARAM_STR);
    $sth -> bindParam(':title', $_POST['title'], PDO::PARAM_STR);
    $sth -> bindParam(':recommended', $_POST['recommended'], PDO::PARAM_INT);
    $sth -> bindParam(':story_pt', $_POST['story_pt'], PDO::PARAM_INT);
    $sth -> bindParam(':pictures_pt', $_POST['pictures_pt'], PDO::PARAM_INT);
    $sth -> bindParam(':music_pt', $_POST['music_pt'], PDO::PARAM_INT);
    $sth -> bindParam(':character_pt', $_POST['character_pt'], PDO::PARAM_INT);
    $sth -> bindParam(':category', $_POST['category'], PDO::PARAM_STR);
    $sth -> bindParam(':overview', $_POST['overview'], PDO::PARAM_STR);
    $sth -> bindParam(':file_name', $filename, PDO::PARAM_STR);
    $sth -> bindParam(':file_path', $save_path, PDO::PARAM_STR);
    $sth->execute();
    $this -> dbh -> commit();
  } catch(PDOException $e){
    $this -> dbh -> rollBack();
    exit($e);
  }
  }

//一覧
  public function findAll($page = 0):Array {
  $sql = 'SELECT * FROM reviews  ORDER BY id DESC';
  $sql .= ' LIMIT 20 OFFSET '.(20*$page);
  $sth = $this->dbh->prepare($sql);
  $sth->execute();
  $result = $sth->fetchAll(PDO::FETCH_ASSOC);
  return $result;
  }

//カウント
  public function countAll():Int {
  $sql = 'SELECT count(*) as count FROM reviews';
  $sth = $this->dbh->prepare($sql);
  $sth->execute();
  $count = $sth->fetchColumn();
  return $count;
}

//マイページ一覧
  public function findmypage($user):Array {
  $sql = 'SELECT * FROM reviews WHERE user_id = :user_id ORDER BY id DESC ';
  $sth = $this->dbh->prepare($sql);
  $sth->bindParam(':user_id', $user, PDO::PARAM_STR);
  $sth->execute();
  $result = $sth->fetchAll(PDO::FETCH_ASSOC);
  return $result;
  }

//マイページカウント
  public function countmypage():Int {
  $sql = 'SELECT count(*) as count FROM reviews ';
  $sth = $this->dbh->prepare($sql);
  $sth->execute();
  $count = $sth->fetchColumn();
  return $count;
}

//データ取得(id)
  public function findById($id) {
    $sql = 'SELECT * FROM reviews Where id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result;
  }


//データ編集(id)
  public function editId($filename, $save_path2) {
    $this -> dbh -> beginTransaction();//トランザクション
    $created_at = date('Y/m/d H:i:s');
    $sql ='UPDATE reviews SET user_id=:user_id, title=:title, recommended=:recommended, story_pt=:story_pt, pictures_pt=:pictures_pt , music_pt=:music_pt, character_pt=:character_pt, category=:category, overview=:overview, file_name=:file_name, file_path=:file_path WHERE id=:id ';
    $sth = $this->dbh->prepare($sql);
    try {
      $sth -> bindParam(':user_id', $_SESSION['user_id'] , PDO::PARAM_STR);
      $sth -> bindParam(':title', $_POST['title'], PDO::PARAM_STR);
      $sth -> bindParam(':recommended', $_POST['recommended'], PDO::PARAM_INT);
      $sth -> bindParam(':story_pt', $_POST['story_pt'], PDO::PARAM_INT);
      $sth -> bindParam(':pictures_pt', $_POST['pictures_pt'], PDO::PARAM_INT);
      $sth -> bindParam(':music_pt', $_POST['music_pt'], PDO::PARAM_INT);
      $sth -> bindParam(':character_pt', $_POST['character_pt'], PDO::PARAM_INT);
      $sth -> bindParam(':category', $_POST['category'], PDO::PARAM_STR);
      $sth -> bindParam(':overview', $_POST['overview'], PDO::PARAM_STR);
      $sth -> bindParam(':file_name', $filename, PDO::PARAM_STR);
      $sth -> bindParam(':file_path', $save_path2, PDO::PARAM_STR);
      $sth -> bindParam(':id', $_POST['id'], PDO::PARAM_INT);
      $sth -> execute();
      $this -> dbh -> commit();
    } catch(PDOException $e){
      $this -> dbh -> rollBack();
      exit($e);
    }
  }

  //データ削除(id)
  function delete($id) {
    $sql = 'DELETE FROM reviews Where id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
  }

  public function iineview2($goods) {
    $sql = 'SELECT * FROM reviews Where id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $goods['id'], PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
}

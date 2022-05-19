<?php
require_once(ROOT_PATH .'/Models/Db.php');

class Goods extends Db{
    private $table = 'goods';

    public function __construct($dbh = null) {
      parent::__construct($dbh);
    }

    function check_favolite_duplicate($user,$post_id){
    $sql = "SELECT * FROM goods WHERE user_id = :user_id AND review_id = :post_id";
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':user_id', $user, PDO::PARAM_STR);
    $sth->bindParam(':post_id', $post_id, PDO::PARAM_STR);
    $sth->execute();
    $favorite = $sth->fetch(PDO::FETCH_ASSOC);
    return $favorite;
  }

    function check_favolite_duplicate2($user,$post_id){
        $sql = "DELETE FROM goods WHERE :user_id = user_id AND :post_id = review_id";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':user_id', $user, PDO::PARAM_STR);
        $sth->bindParam(':post_id', $post_id, PDO::PARAM_STR);
        $sth->execute();
        $favorite = $sth->fetch(PDO::FETCH_ASSOC);
        return $favorite;
    }

    function check_favolite_duplicate3($user,$animes){
        $sql = "INSERT INTO goods(user_id,review_id,title,recommended,story_pt,pictures_pt,music_pt,character_pt,overview,file_path) VALUES(:user_id,:post_id,:title,:recommended,:story_pt,:pictures_pt,:music_pt,:character_pt,:overview,:file_path)";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':user_id', $user, PDO::PARAM_STR);
        $sth->bindParam(':post_id', $animes['review']['id'], PDO::PARAM_INT);
        $sth -> bindParam(':title', $animes['review']['title'], PDO::PARAM_STR);
        $sth -> bindParam(':recommended', $animes['review']['recommended'], PDO::PARAM_INT);
        $sth -> bindParam(':story_pt', $animes['review']['story_pt'], PDO::PARAM_INT);
        $sth -> bindParam(':pictures_pt', $animes['review']['pictures_pt'], PDO::PARAM_INT);
        $sth -> bindParam(':music_pt', $animes['review']['music_pt'], PDO::PARAM_INT);
        $sth -> bindParam(':character_pt', $animes['review']['character_pt'], PDO::PARAM_INT);
        $sth -> bindParam(':overview', $animes['review']['overview'], PDO::PARAM_STR);
        $sth -> bindParam(':file_path', $animes['review']['file_path'], PDO::PARAM_STR);
        $sth->execute();
        $favorite = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $favorite;
    }

    function iineview($user){
    $sql = "SELECT * FROM goods WHERE user_id = :user_id";
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':user_id', $user, PDO::PARAM_STR);
    $sth->execute();
    $favorite = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $favorite;
  }

  public function countiine($id,$user_id):Int {
  $sql = 'SELECT count(*) as count FROM goods WHERE :user_id = user_id AND :post_id = review_id';
  $sth = $this->dbh->prepare($sql);
  $sth->bindParam(':user_id', $user_id, PDO::PARAM_STR);
  $sth->bindParam(':post_id', $id, PDO::PARAM_STR);
  $sth->execute();
  $count = $sth->fetchColumn();
  return $count;
}
}

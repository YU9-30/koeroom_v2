<?php
require ("../private/auth.php");//データベース接続のための情報
$err_msg = "";
if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  try {
    $dbh = new PDO($dsn,$user,$password,$options);
    $sql = 'select * from koeroom_db where username = :name';
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':name' => $username));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = null;
    $dbh = null;
    if(password_verify($password, $result['password'])){
        header('location: https://koeroom.herokuapp.com/');
        exit;
    }else{
        echo "ログイン認証に失敗しました";
    }
  }catch (PDOExeption $e) {
    echo $e->getMessage();
    exit;
  }
}
?>
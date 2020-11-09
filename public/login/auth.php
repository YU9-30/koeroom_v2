<?php

$err_msg = "";
if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  try {
    $db = new PDO("mysql:host=" . $server . "; dbname=".$database."; charset=utf8", $user, $pass );
    $sql = 'select * from koeroom_db where username = :name';
    $stmt = $db->prepare($sql);
    $stmt->execute(array(':name' => $username));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = null;
    $db = null;
    if(password_verify($password, $result['password'])){
        header('location: https://voiceroom.yu-9.work/');
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
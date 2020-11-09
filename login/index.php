<?php
include('../include/php/voiceroom_base.php');
require ("../private/auth.php");//データベース接続のための情報
$err_msg = "";
if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  try {
    $dbh = new PDO($dsn,$user,$password,$options);
    $sql = 'select * from' . $db['dbname'] . '.koeroom_db where username = :name';
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':name' => $username));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = null;
    $dbh = null;
    echo $password;
    echo password_verify($password, $result['password']);
    if(password_verify($password, $result['password'])){
        $_SESSION['username'] = $username;
        $_SESSION['auth'] = true;
        header('location: ../index.php');
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
<!doctype html>
<html lang="ja">

<head>
  <?php include('../include/php/head.php'); ?>
</head>

<body>
  
  <div id="include-header">
    <?php include('../include/php/header.php'); ?>
  </div>
    <div class="container">
        <div class="columns is-mobile is-centered  is-marginless">
            <div class="column mt-5 is-6">
                <form action="" method="post">
                    <div class="field">
                        <p class="control has-icons-left has-icons-right">
                            <input class="input" type="text" placeholder="Email" name="username">
                            <span class="icon is-small is-left">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <span class="icon is-small is-right">
                                <i class="fas fa-check"></i>
                            </span>
                        </p>
                    </div>
                    <div class="field">
                        <p class="control has-icons-left">
                            <input class="input" type="password" placeholder="Password" name="password">
                            <span class="icon is-small is-left">
                                <i class="fas fa-lock"></i>
                            </span>
                        </p>
                    </div>
                    <div class="buttons is-centered ">
                            <button class="button is-primary" name="login">
                                Login
                            </button>
                     </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
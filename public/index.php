<?php
include( '/public/include/php/voiceroom_base.php');
$err_msg = "";
if (isset($_POST['create'])) {
  $roomid = $_POST['roomid'];
  $username = $_SESSION['username'];
  try {
    $db = new PDO("mysql:host=" . $server . "; dbname=".$database."; charset=utf8", $user, $pass );
    $sql = 'update koeroom_db set roompass = :roomid  where username = :name';
    $stmt = $db->prepare($sql);
    $stmt->execute(array(':name' =>$_SESSION['username'],':roomid' =>$roomid));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = null;
    $db = null;
    header('location: https://voiceroom.yu-9.work/room/?roomadmin='. $username .'&roomid=' . $roomid);
  }catch (PDOExeption $e) {
    echo $e->getMessage();
    exit;
  }
}
?>
<!doctype html>
<html lang="ja">

<head>
  <?php include( 'public/include/php/head.php'); ?>
</head>

<body>
  
  <div id="include-header">
    <?php include( $_SERVER['DOCUMENT_ROOT'] . '/public/include/php/header.php'); ?>
  </div>
  
  <div class="container">
    <div class="columns is-mobile is-marginless is-centered">
      <div class="column is-centered mt-5 is-8">
        /**/
        <?php if($_SESSION['auth']){ ?>
          <form action="" method="post">
            <div class="control mb-2 is-centered">
              <input class="input" type="text" placeholder="room id" name="roomid">
            </div>
            <div class="buttons is-centered ">
                <button id="js-join-trigger" class="button" name="create">Roomを作成</button>
            </div>
          </form>
        <?php } else { ?>
        <form action="./room" method="get">
          <div class="field">
            <label class="label">Room Admin</label>
            <div class="control">
              <input class="input" type="text" placeholder="tarou" name="roomadmin">
            </div>
          </div>
          <div class="field">
            <label class="label">Room ID</label>
            <div class="control">
              <input class="input" type="text" name="roomid">
            </div>
          </div>
          <div class="buttons is-centered mt-2">
                <button class="button" type="submit">参加する</button>
            </div>
        </form>
        <?php } ?>
      </div>
    </div>
    <div class="columns is-mobile is-marginless is-centered is-primary">
      <div class="column my-1 is-8">
        <article class="message is-primary">
          <div class="message-header">
            <p>ようこそKoeroomへ</p>
          </div>
          <div class="message-body">
          <p>
            KoeroomはWebブラウザを利用した通話アプリケーションです。
            ログインすることで部屋を立てることができます。部屋のURLをシェアすることで
            他のユーザーが参加して通話を行うことができます。 
          </p>
          </div>
        </article>
      </div>
    </div>
    

    <footer class="footer py-2">
      <div class="content has-text-centered">
        <p>koeroom</p>
      </div>
    </footer>

  </div>
</body>

</html>
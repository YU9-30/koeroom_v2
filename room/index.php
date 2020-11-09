<?php
include('../include/php/voiceroom_base.php');
require ("../private/auth.php");
$err_msg = "";

  $username = $_GET['roomadmin'];
  $roompass = $_GET['roomid'];
  try {
    $db = new PDO("mysql:host=" . $server . "; dbname=" .$database. "; charset=utf8", $user, $pass);
    $sql = 'SELECT * FROM' . $database . '.koeroom_db WHERE username = :name';
    $stmt = $db->prepare($sql);
    $stmt->execute(array(':name' => $username));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = null;
    $db = null;
    
  }catch (PDOExeption $e) {
    echo $e->getMessage();
    exit;
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
    <div class="columns is-desktop is-centered is-marginless">
      <div class="column is-centered has-text-centered mt-5">
        <?php if ($result['roompass'] == $roompass){ ?>
        
            <p>Room ID</p><p id="js-room-id" class="mb-1"><?php echo $result['roompass'] ?></p>
            <div class="mb-5">
              <a href="https://twitter.com/share" class="twitter-share-button" data-text="Koeroomで通話しませんか？URLをクリックすることで部屋に入室できます">Tweet</a>
              <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>  
            </div>
            <div class="buttons is-centered ">
              <div class="buttons">
                <button id="js-join-trigger" class="button">参加</button>
                <button id="js-leave-trigger" class="button is-danger">退出</button>
              </div>
            </div>
      </div>
    </div>

    <div class="columns is-mobile is-centered is-marginless">
      <div class="column is-full has-text-centered mt-5">
        <div class="room hidden">
          <div>
            <video class="is-hidden" id="js-local-stream"></video>
          </div>
          <div class="remote-streams is-hidden" id="js-remote-streams"></div>
        </div>
        <div id="msg_filed" class="has-text-left">
          <pre class="messages" id="js-messages"></pre>
        </div>
        <div class="field has-addons">
          <div class="control">
            <input class="input" type="text" placeholder="名前" id="js-local-Name">
          </div>
          <div class="control is-expanded">
            <input class="input is-primary" type="text" id="js-local-text" placeholder="メッセージ">
          </div>
          <div class="control">
            <button id="js-send-trigger" class="button is-primary">送る</button>
          </div>
        </div>
        <strong id="js-alertmsg" class="has-text-danger"></strong>
      </div>
    </div>

    <footer class="footer py-2">
      <div class="content has-text-centered">
        <p class="meta" id="js-meta"></p><br>
        <p>Mode:<span id="js-room-mode"></span>で接続中</p>
      </div>
    </footer>
    <?php }else{ echo $result['roompass']; echo '1:'. $roompass;?>
        <p>Roomが見つかりません</p>
    <?php } ?>
            
  </div>
  <script src="https://cdn.webrtc.ecl.ntt.com/skyway-latest.js"></script>
  <script src="/include/js/key1334.js"></script>
  <script src="/include/js//script.js"></script>
</body>

</html>
<?php
    $db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
    $server = $db["host"];
    $database = substr($db["path"], 1);
    $user = $db['user'];
    $pass = $db['pass'];
    $options = array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::MYSQL_ATTR_USE_BUFFERED_QUERY =>true,
    );
?>

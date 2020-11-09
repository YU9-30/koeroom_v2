<?php
    $url = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
    $server = $url["host"];
    $database = substr($url["path"], 1);
    $user = $url['user'];
    $pass = $url['pass'];
    $options = array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::MYSQL_ATTR_USE_BUFFERED_QUERY =>true,
    );
?>

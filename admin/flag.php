<?php
  require_once("../lib/config/conf.php");
  require_once("../lib/db.php");

  if (isset($_GET['set']) && isset($_GET['id'])) {
    $mydb = new DB();
    echo $mydb->setFlag($_GET['id'], $_GET['set']);
  }
?>
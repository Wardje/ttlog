<?php

  require_once("lib/config/conf.php");
  require_once("lib/db.php");
  require_once("lib/utilfuncs.php");

  if (isId() && isName()) {
    if (! isTTCookie()) {
      $mydb = new DB();
      $mydb->addLog(getId(), getName(), getIp());
    }
  }

?>
<?php

  function isName() { return isset($_GET['name']); }
  function isId() { return isset($_GET['id']); }
  function getName() { return $_GET['name']; }
  function getId() { return $_GET['id']; }
  function getIp() { return $_SERVER['REMOTE_ADDR']; }
  function encryptNameIp($id, $name, $ip) { return md5($id . $name . $ip); }
  
  function isTTCookie() {
    global $CONF;
    return (isset($_COOKIE[$CONF['cookie_name']]) &&
            $_COOKIE[$CONF['cookie_name']] == encryptNameIp(getId(), getName(), getIp()));
  }

  function setTTCookie() {
    global $CONF;
    return setcookie($CONF['cookie_name'],
                      encryptNameIp(getId(), getName(), getIp()),
                      time() + 60 * $CONF['cookie_timeout']);
  }

?>
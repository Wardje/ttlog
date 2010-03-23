<?php
require_once("lib/config/conf.php");
require_once("lib/db.php");

$mydb = new DB();
$mydb->createTables();

?>

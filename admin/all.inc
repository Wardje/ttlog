<?php
  $mydb = new DB();
  $result = $mydb->getAll();
  showResultTable($result);
?>
<?php
  $mydb = new DB();
  $result = $mydb->getAll(getSort());
  showResultTable($result, getPage(), getSearch());
?>
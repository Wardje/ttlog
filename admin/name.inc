<?php $q = getSearch(); ?>
<form method="get" action="">
  <p>
    <input type="hidden" name="p" value="<?php echo getPage(); ?>" />
    <input type="text" name="q" value="<?php echo $q; ?>" />
    <input type="submit" value="Search User" />
  </p>
</form>
<?php
  if ($q) {
    $mydb = new DB();
    $result = $mydb->getByName($q);
    showResultTable($result);
  }
?>
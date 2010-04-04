<?php
  require_once("../lib/config/conf.php");
  require_once("../lib/db.php");
  require_once("../lib/adminutils.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>The Titans - IP Log</title>
    <meta http-equiv="Content-Type" content="application/xhtml+xml;charset=utf-8" />
    <meta name="author" content="Ward Muylaert" />
    <link rel="stylesheet" type="text/css" href="css/default.css" />
    <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="js/flagged.js"></script>
  </head>
  <body>
    <div id="page">
      <div id="menu">
        <ul>
          <li><a href="?">Home</a></li>
          <li><a href="?p=name">Name</a></li>
          <li><a href="?p=id">ID</a></li>
          <li><a href="?p=ip">IP</a></li>
          <li><a href="?p=all">All</a></li>
        </ul>
      </div>
      <div id="body">
        <h1><?php echo getPage(); ?></h1>
<?php require_once(getPage() . ".inc"); ?>

      </div>
    </div>
  </body>
</html>

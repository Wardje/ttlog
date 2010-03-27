<?php
  /**
   * ipinfo.php
   * Goes to
   * http://ipinfodb.com/ip_query.php?ip=__IP_HERE__&timezone=true
   * then prints out the result
   */

  echo file_get_contents("http://ipinfodb.com/ip_query.php?ip="
	. $_GET['ip']
	. "&timezone=false");

?>

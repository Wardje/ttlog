<?php
  function getPage() {
    switch ($_GET['p']) {
      case "name":
      case "ip":
      case "id":
      case "all":
        return $_GET['p'];
      default:
        return "home";
    }
  }

  function getSearch() {
    return $_GET['q'];
  }

  function getSort() {
    return $_GET['s'];
  }

  function makeValidId($id) {
    return intval($id);
  }

  function showResultTable($resultArray, $page, $search) {
    echo "<table id='iptable'>
  <tr>
    <th><a href='?p={$page}&amp;q={$search}&amp;s=name'>User</a></th>
    <th><a href='?p={$page}&amp;q={$search}&amp;s=ip'>IP</a></th>
    <th><a href='?p={$page}&amp;q={$search}&amp;s=time'>Time</a></th>
    <th>Flagged</th>
  </tr>\n";
    foreach ($resultArray as $row) {
      echo "<tr>\n";
      echo "<td><a href='?p=id&amp;q={$row['id']}'>{$row['name']}</a></td>\n";
      echo "<td><a href='?p=ip&amp;q={$row['ip']}'>{$row['ip']}</a></td>\n";
      echo "<td>{$row['time']}</td>\n";
      echo "<td>\n";
        // <a> tag to more or less gracefully degrade for old browsers
        echo "<a href='flag.php?id={$row['id']}&amp;set=" . ($row['flagged']?0:1) . "' onclick='javascript: return false;'>\n";
        echo "<img onclick='javascript: changeFlagged(this);' class='"
          . ($row['flagged']?'flagged ':'')
          . "user-" . $row['id']
          . "' src='img/flagged-{$row['flagged']}.png'"
	  . " alt='{$row['flagged']}' />\n";
        echo "</a>\n";
      echo "</td>\n";
      echo "</tr>\n";
    }
    echo "</table>";
  }
?>

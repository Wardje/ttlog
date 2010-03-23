<table>
  <tr>
    <th>User</th>
    <th>IP</th>
    <th>Time</th>
  </tr>
<?php
  $mydb = new DB();
  $result = $mydb->getAll();
  foreach ($result as $row) {
    echo "<tr>\n";
    echo "<td><a href='?p=id&q={$row['id']}'>{$row['name']}</a></td>\n";
    echo "<td><a href='?p=ip&q={$row['ip']}'>{$row['ip']}</a></td>\n";
    echo "<td>{$row['time']}</td>\n";
    echo "</tr>\n";
  }
?>
</table>
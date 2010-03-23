<?php $q = getSearch(); ?>
<form method="get">
  <input type="hidden" name="p" value="<?php echo getPage(); ?>" />
  <input type="text" name="q" value="<?php echo $q; ?>" />
  <input type="submit" value="Search ID" />
</form>
<?php
  if ($q) {
    echo "<table>
  <tr>
    <th>User</th>
    <th>IP</th>
    <th>Time</th>
  </tr>";
    $mydb = new DB();
    $result = $mydb->getById($q);
    foreach ($result as $row) {
      echo "<tr>\n";
      echo "<td><a href='?p=id&q={$row['id']}'>{$row['name']}</a></td>\n";
      echo "<td><a href='?p=ip&q={$row['ip']}'>{$row['ip']}</a></td>\n";
      echo "<td>{$row['time']}</td>\n";
      echo "</tr>\n";
    }
    echo "</table>";
  }
?>
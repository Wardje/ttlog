<?php

class DB {
  private $dblink = NULL;

  function __construct() {
    self::_connect();
  }

  private function _connect() {
    global $CONF;
    // Should I use pconnect instead?
    // Should I throw error instead?
    $this->dblink = mysql_connect(
      $CONF['dbhost'],
      $CONF['dbuser'],
      $CONF['dbpass'])
      or die("Unable to connect to db");

    mysql_select_db($CONF['dbname'], $this->dblink)
      or die("Unable to select database {$CONF['dbname']}");
  }

  /**
   * This should only be called once ever, to create the tables for the database.
   * Note that no FOREIGN KEY is used for iplogs table, this is because
   * the default MySQL tables do not support this. However, this is planned for
   * MySQL 6.
   */
  function createTables() {
    $id_name_table = "CREATE TABLE users (
      id INT NOT NULL PRIMARY KEY,
      name VARCHAR(32) NOT NULL,
      flagged BOOL DEFAULT 0
    )";
    $id_ip_time = "CREATE TABLE iplogs (
      id INT NOT NULL,
      ip VARCHAR(40) NOT NULL,
      time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (id, ip)
    )";

    if (0 == mysql_num_rows( mysql_query("SHOW TABLES LIKE 'users'"))) {
      mysql_query($id_name_table, $this->dblink);
    }

    if (0 == mysql_num_rows( mysql_query("SHOW TABLES LIKE 'iplogs'"))) {
      mysql_query($id_ip_time, $this->dblink);
    }
  }

  /**
   * Insert a log into the database
   */
  function addLog($id, $name, $ip) {
    self::updateName(intval($id), $name);
    self::updateIp(intval($id), $ip);
  }


  function setFlag($id, $flag = 0) {
    $updateQuery = sprintf("UPDATE users SET flagged = %s WHERE id = %s",
                            ($flag ? 1 : 0),
                            intval($id));
    mysql_query($updateQuery, $this->dblink);
    return mysql_affected_rows($this->dblink);
  }

  /**
   * Update/insert a name associated with a certain id
   * @return 0 on failure
   * @return 1 on insert
   * @return 2 on update
   */
  function updateName($id, $name) {
    // http://dev.mysql.com/doc/refman/5.1/en/insert-on-duplicate.html
    $insertQuery = sprintf("INSERT INTO users (id, name) VALUES (%s, '%s') ON DUPLICATE KEY UPDATE name='%s'",
                                $id,
                                mysql_real_escape_string($name),
                                mysql_real_escape_string($name));
    mysql_query($insertQuery, $this->dblink);
    return mysql_affected_rows($this->dblink);
  }

  /**
   * Updates timestamp for id-ip combo or inserts if no such entry exists
   * @return 0 on failure
   * @return 1 on insert
   * @return 2 on update
   */
  function updateIp($id, $ip) {
    $insertQuery = sprintf("INSERT INTO iplogs (id, ip) VALUES (%s, '%s') ON DUPLICATE KEY UPDATE time=NULL",
                                $id,
                                mysql_real_escape_string($ip));
    mysql_query($insertQuery, $this->dblink);
    return mysql_affected_rows($this->dblink);
  }

  /**
   * TODO These functions are VERY similar, isolate those parts!
   */
  
  function getById($id, $sortOrder = "time") {
    $sortBy = "ORDER BY iplogs.time DESC";
    // Switch so future stuff can get added easier!
    switch ($sortOrder) {
      case "ip":
        $sortBy = "ORDER BY iplogs.ip";
    }

    $searchQuery = "SELECT users.name,iplogs.id,iplogs.ip,iplogs.time,users.flagged
                    FROM users,iplogs
                    WHERE users.id = {$id} AND users.id = iplogs.id
                    {$sortBy}";
    $result = mysql_query($searchQuery, $this->dblink);
    $returnArray = array();
    while ($tmp = mysql_fetch_assoc($result)) {
      $returnArray[] = $tmp;
    }

    return $returnArray;
  }

  function getByName($name, $sortOrder = "name") {
    $sortBy = "ORDER BY users.name ASC, iplogs.time DESC";
    switch ($sortOrder) {
      case "time":
        $sortBy = "ORDER BY iplogs.time DESC";
        break;
      case "ip":
        $sortBy = "ORDER BY iplogs.ip, users.name";
    }

    $searchQuery = "SELECT users.name,iplogs.id,iplogs.ip,iplogs.time,users.flagged
                    FROM users,iplogs
                    WHERE users.name LIKE '%" . mysql_real_escape_string($name) . "%'
                      AND users.id = iplogs.id
                    {$sortBy}";
    $result = mysql_query($searchQuery, $this->dblink);
    $returnArray = array();
    while ($tmp = mysql_fetch_assoc($result)) {
      $returnArray[] = $tmp;
    }

    return $returnArray;
  }

  function getByIp($ip, $sortOrder = "ip") {
    $sortBy = "ORDER BY iplogs.ip ASC, users.name ASC";
    switch ($sortOrder) {
      case "time":
        $sortBy = "ORDER BY iplogs.time DESC";
        break;
      case "name":
        $sortBy = "ORDER BY users.name, iplogs.ip";
    }

    $searchQuery = "SELECT users.name,iplogs.id,iplogs.ip,iplogs.time,users.flagged
                    FROM users,iplogs
                    WHERE iplogs.ip LIKE '"
                        . str_replace('*', '%', mysql_real_escape_string($ip)) . "'
                      AND users.id = iplogs.id
                    {$sortBy}";
    $result = mysql_query($searchQuery, $this->dblink);
    $returnArray = array();
    while ($tmp = mysql_fetch_assoc($result)) {
      $returnArray[] = $tmp;
    }

    return $returnArray;
  }

  function getAll($sortOrder = "time") {
    $sortBy = "ORDER BY iplogs.time DESC";
    switch ($sortOrder) {
      case "name":
        $sortBy = "ORDER BY users.name, iplogs.ip";
        break;
      case "ip":
        $sortBy = "ORDER BY iplogs.ip, users.name";
        break;
      case "id":
        $sortBy = "ORDER BY iplogs.id ASC";
    }

    $searchQuery = "SELECT users.name,iplogs.id,iplogs.ip,iplogs.time,users.flagged
                    FROM users,iplogs
                    WHERE users.id = iplogs.id
                    LIMIT 1000
                    {$sortBy}";
    $result = mysql_query($searchQuery, $this->dblink);
    $returnArray = array();
    while ($tmp = mysql_fetch_assoc($result)) {
      $returnArray[] = $tmp;
    }

    return $returnArray;
  }
}

?>

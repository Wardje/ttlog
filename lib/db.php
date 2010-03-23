<?php

class DB
{
  private $dblink = NULL;

  function _connect() {
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
    var $id_name_table = "CREATE TABLE users (
      id INT NOT NULL PRIMARY KEY,
      name VARCHAR(32) NOT NULL
    )";
    var $id_ip_time = "CREATE TABLE iplogs (
      id INT NOT NULL,
      ip VARCHAR(40) NOT NULL,
      time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (id, ip)
    )";

    if (0 == mysql_num_rows( mysql_query("SHOW TABLES LIKE 'users'"))) {
      mysql_query($id_name_table, $this->dblink);
    }

    if (0 == mysql_num_rows( mysql_query("SHOW TABLES LIKE 'users'"))) {
      mysql_query($id_ip_time, $this->dblink);
    }
  }

  /**
   * Insert a log into the database
   */
  function addLog($id, $name, $ip) {
    self::updateName($id, $name);
    self::updateIp($id, $ip);
  }

  /**
   * Update/insert a name associated with a certain id
   * @return 0 on failure
   * @return 1 on insert
   * @return 2 on update
   */
  function updateName($id, $name) {
    // http://dev.mysql.com/doc/refman/5.1/en/insert-on-duplicate.html overpowers:
    //var $updateQuery = sprintf("UPDATE users SET name='%s' WHERE id=%s", mysql_real_escape_string($name), $id);
    //var $insertQuery = sprintf("INSERT INTO users (id, name)

    var $insertQuery = sprintf("INSERT INTO users (id, name) VALUES (%s, '%s') ON DUPLICATE KEY UPDATE name='%s'",
                                $id,
                                mysql_real_escape_string($name),
                                mysql_real_escape_string($name));
    mysql_query($insertQuery, $this->dblink);
    return mysql_affected_rows($this-dblink);
  }

  /**
   * Updates timestamp for id-ip combo or inserts if no such entry exists
   * @return 0 on failure
   * @return 1 on insert
   * @return 2 on update
   */
  function updateIp($id, $ip) {
    /*
    var $updateQuery = sprintf("UPDATE iplogs SET time=NULL WHERE id=%s and ip='%s'", $id, $ip);
    var $insertQuery = sprintf("INSERT INTO iplogs (id, ip) VALUES (%s, '%s')", $id, $ip);

    // Is there a 'prettier' way to go about this?
    mysql_query($updateQuery, $this->dblink);
    if (mysql_affected_rows($this->dblink) < 1) {
      mysql_query($insertQuery, $this->dblink);
      if (mysql_affected_rows($this->dblink))
    }
    // */

    var $insertQuery = sprintf("INSERT INTO iplogs (id, ip) VALUES (%s, '%s') ON DUPLICATE KEY UPDATE time=NULL",
                                $id,
                                $ip);
    mysql_query($insertQuery, $this->dblink);
    return mysql_affected_rows($this->dblink);
  }

  /**
   * TODO Functions to retrieve data from the database
   */
}

?>

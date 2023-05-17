<?php

class Db {
  var $no_error = 0;
  var $connection;
  var $query_id = 0;
  var $query_count = 0;
  var $query_time = 0;
  var $query_array = array();
  var $table_fields = array();

  function Db($db_host, $db_user, $db_password = "", $db_name = "", $db_pconnect = 0) {
    // $connect_handle = ($db_pconnect) ? "mysql_pconnect" : "mysql_connect";
    // if (!$this->connection = $connect_handle($db_host, $db_user, $db_password)) {
    //   $this->error("Could not connect to the database server ().", 1);
    // }
    // if ($db_name != "") {
    //   if (!@mysql_select_db($db_name)) {
    //     @mysql_close($this->connection);
    //     $this->error("Could not select database ($db_name).", 1);
    //   }
    // }
    //print_r(array($db_host, $db_user, $db_password));
    $link = mysql_connect('localhost', 'boule_iolsty', 'iv4QHUw8kjdLKw');
    if (!$link) {
        die('Not connected : ' . mysql_error());
    }

    // make foo the current db
    $db_selected = mysql_select_db('boule_boulesis', $link);
    if (!$db_selected) {
        die ('Can\'t use boule_boulesis : ' . mysql_error());
    }
    $this->connection =  $link;
    return $this->connection;
  }

  function close() {
    if ($this->connection) {
      if ($this->query_id) {
        @mysql_free_result($this->query_id);
      }
      return @mysql_close($this->connection);
    }
    else {
      return false;
    }
  }

  function query($query = "") {
    unset($this->query_id);
    if ($query != "") {
      if ((defined("PRINT_QUERIES") && PRINT_QUERIES == 1) || (defined("PRINT_STATS") && PRINT_STATS == 1)) {
        $startsqltime = explode(" ", microtime());
      }
      if (!$this->query_id = @mysql_query($query, $this->connection)) {
        $this->error("<b>Bad SQL Query</b>: ".htmlentities($query)."<br /><b>".mysql_error()."</b>");
      }
      if ((defined("PRINT_QUERIES") && PRINT_QUERIES == 1) || (defined("PRINT_STATS") && PRINT_STATS == 1)) {
        $endsqltime = explode(" ", microtime());
        $totalsqltime = round($endsqltime[0]-$startsqltime[0]+$endsqltime[1]-$startsqltime[1],3);
        $this->query_time += $totalsqltime;
        $this->query_count++;
      }
      if (defined("PRINT_QUERIES") && PRINT_QUERIES == 1) {
        $query_stats = htmlentities($query);
        $query_stats .= "<br><b>Querytime:</b> ".$totalsqltime;
        $this->query_array[] = $query_stats;
      }
      return $this->query_id;
    }
  }

  function fetch_array($query_id = -1, $assoc = 0) {
    if ($query_id != -1) {
      $this->query_id = $query_id;
    }
    if ($this->query_id) {
      return ($assoc) ? mysql_fetch_assoc($this->query_id) : mysql_fetch_array($this->query_id);
    }
  }
  
  function fetch_object($query_id = -1) {
    if ($query_id != -1) {
      $this->query_id = $query_id;
    }
    if ($this->query_id) {
      return mysql_fetch_object($this->query_id);
    }
  }


  function free_result($query_id = -1) {
    if ($query_id != -1) {
      $this->query_id = $query_id;
    }
    return @mysql_free_result($this->query_id);
  }

  function query_firstrow($query = "") {
    if ($query != "") {
      $this->query($query);
    }
    $result = $this->fetch_array($this->query_id);
    $this->free_result();
    return $result;
  }

  function get_numrows($query_id = -1) {
    if ($query_id != -1) {
      $this->query_id = $query_id;
    }
    return mysql_num_rows($this->query_id);
  }

  function get_insert_id() {
    return ($this->connection) ? @mysql_insert_id($this->connection) : 0;
  }
  
  function get_next_id($column = "", $table = "") {
    if (!empty($column) && !empty($table)) {
      $sql = "SELECT MAX($column) AS max_id
              FROM $table";
      $row = $this->query_firstrow($sql);
      return (($row['max_id'] + 1) > 0) ? $row['max_id'] + 1 : 1;
    }
    else {
      return NULL;
    }
  }

  function get_numfields($query_id = -1) {
    if ($query_id != -1) {
      $this->query_id = $query_id;
    }
    return @mysql_num_fields($this->query_id);
  }

  function get_fieldname($query_id = -1, $offset) {
    if ($query_id != -1) {
      $this->query_id = $query_id;
    }
    return @mysql_field_name($this->query_id, $offset);
  }

  function get_fieldtype($query_id = -1, $offset) {
    if ($query_id != -1) {
      $this->query_id = $query_id;
    }
    return @mysql_field_type($this->query_id, $offset);
  }

  function affected_rows() {
    return ($this->connection) ? @mysql_affected_rows($this->connection) : 0;
  }

  function is_empty($query = "") {
    if ($query != "") {
      $this->query($query);
    }
    return (!mysql_num_rows($this->query_id)) ? 1 : 0;
  }

  function not_empty($query = "") {
    if ($query != "") {
      $this->query($query);
    }
    return (!mysql_num_rows($this->query_id)) ? 0 : 1;
  }
  
  function get_table_fields($table) {
    if (!empty($this->table_fields[$table])) {
      return $this->table_fields[$table];
    }
    $this->table_fields[$table] = array();
    $result = $this->query("SHOW FIELDS FROM $table");
    while ($row = $this->fetch_array($result)) {
      $this->table_fields[$table][$row['Field']] = $row['Type'];
    }
    return $this->table_fields[$table];
  }

  function error($errmsg, $halt = 0) {
    if (!$this->no_error) {
//      echo "<br /><font color='#FF0000'><b>DB Error</b></font>: ".$errmsg."<br />";
      if ($halt) {
        exit;
      }
    }
  }
} // end of class
?>
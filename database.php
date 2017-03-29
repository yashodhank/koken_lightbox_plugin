<?php

class Database {
  public static $connection;

  function __construct () {
    $this->connect();
  }
  //
  function connect () {
    // Try and connect to the database, if a connection has not been established yet
    if(!isset(self::$connection)) {
         // Load configuration as an array. Use the actual location of your configuration file
        $config = parse_ini_file('config.ini');
        self::$connection = mysqli_connect($config['host'], $config['username'], $config['password'], $config['database']);
    }

    // If connection was not successful, handle the error
    if(self::$connection === false) {
        // Handle error - notify administrator, log to a file, show an error screen, etc.
        return mysqli_connect_error();
    }
    return self::$connection;
  }

  function query ($query) {
    $result = mysqli_query(self::$connection, $query);
    return $result;
  }

  function select ($query) {
    $rows = array();
    $result = $this->query($query);

    // If query failed, return `false`
    if($result === false) {
        return false;
    }

    // If query was successful, retrieve all the rows into an array
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
  }

  function selectOne ($query) {
    $rows = array();
    $result = $this->query($query);

    // If query failed, return `false`
    if($result === false) {
        return false;
    }

    // If query was successful, retrieve only the first rows and return it
    return mysqli_fetch_assoc($result);
  }

}
?>

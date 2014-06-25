<?php

require_once "rb.php";

class DB{
  public static function getProps() { // un-comment one of these
    return self::mysqlProps();
    //return self::sqliteProps();
  }

  private static $_initialized = false;

  public static function init() {
    $props = self::getProps();
    if (self::$_initialized) {
      return $props;
    }
    if ($props['db'] == 'mysql') {
      R::setup($props['url'], $props['username'], $props['password']);
    } 
    elseif ($props['db'] == 'sqlite') {
      R::setup($props['url']);
    }
    R::freeze(true);
    self::$_initialized = true;
    return $props;
  }

  private static function mysqlProps() {
    $host = 'localhost';
    $dbname = 'phpstore';
    $username = 'guest';
    $password = '';
    $url = "mysql:host=$host;dbname=$dbname";
    return array(
        'db' => 'mysql',
        'dbname' => $dbname,
        'username' => $username,
        'password' => $password,
        'host' => $host,
        'url' => $url,
    );
  }

  private static function sqliteProps() {
    $dbname = __DIR__ . DIRECTORY_SEPARATOR .
            'db' . DIRECTORY_SEPARATOR . 'database.sqlite';
    return array(
        'db' => 'sqlite',
        'dbname' => $dbname,
        'url' => "sqlite:$dbname",
    );
  }
}

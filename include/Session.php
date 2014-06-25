<?php
session_start();

define( "SECRET", "-set-this-to-make-sessions-secure-" );
define( "HASH", md5(__DIR__ . SECRET) );
define( "KEY", "sess_" . HASH );

class Session {
  public function __set($name,$value) {
    $_SESSION[KEY][$name] = $value;
  }
  public function & __get($name) {
    return $_SESSION[KEY][$name];
  }
  public function __toString() {
    return isset($_SESSION[KEY]) ? print_r($_SESSION[KEY],true) : "null";
  }
  public function __isset($name) {
    return isset($_SESSION[KEY][$name]);
  }
  public function __unset($name) {
    unset($_SESSION[KEY][$name]);
  }
  public function unsetAll() {
    unset($_SESSION[KEY]);
  }
}

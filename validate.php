<?php
require_once "include/Session.php";
$session = new Session();

require_once "include/DB.php";
DB::init();
 
$params = (object) $_REQUEST;

$username = trim($params->username);
$user = R::findOne("user", "name=?", array($username));

if (!isset($user)) {
  $session->message = "Failed (username)";
  header( "location: login.php" );
}
elseif (sha1($params->password) === $user->password) {  // correct
  $session->user = (object) $user->getProperties();
  unset($session->user->email);    // don't carry these
  unset($session->user->password); // fields in session
  header( "location: ." );
}
else {
  $session->username = $params->username;
  $session->message = "Failed (password)";
  header( "location: login.php" );
}

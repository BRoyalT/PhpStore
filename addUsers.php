<?php 
require_once "include/DB.php";
$props = DB::init();
echo "\naddUsers -- url: {$props['url']}\n\n";

$user_data = array(
  array( "john",    "arachnid@oracle.com", "john" ),
  array( "kirsten", "buffalo@go.com",      "kirsten" ),
  array( "bill",    "digger@gmail.com",    "bill" ),
  array( "mary",    "elephant@wcupa.edu",  "mary" ),
  array( "joan",    "kangaroo@upenn.edu",  "joan"),
  array( "alice",   "feline@yahoo.com",    "alice" ),
  array( "carla",   "badger@esu.edu",      "carla", 1), // superuser
  array( "dave",    "warthog@temple.edu",  "dave", 1),  // superuser
);

foreach($user_data as $data) {
  // If 4th field not there, this would generate a notice, but
  // it is "expected," so we deliberately ignore it with the @.
  @list($username, $email, $password, $level) = $data;
  $user = R::dispense('user');
  $user->name = $username;
  $user->email = $email;
  $user->password = sha1($password);
  $user->level = isset($level) ? $level : 0;
  try {
    $id = R::store($user);
    echo "#$id: $username\n";
  }
  catch(Exception $ex) {
    echo $ex->getMessage(), "\n";
  }
}

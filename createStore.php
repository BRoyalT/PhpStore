<?php
if (isset($_SERVER['REQUEST_URI'])) {
  echo "<pre>\n";  // if web access allowed and used
}

require_once "setup/init.php";
chdir(__DIR__);
require_once "addItems.php";
require_once "addUsers.php";
require_once "addOrders.php";

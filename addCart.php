<!--Ricardo Neiderer
    CSC 417-80
    4/17/14-->

<?php

require_once "include/Session.php";
$session = new Session();

$params = (object) $_REQUEST;

if(preg_match("/^[1-9][0-9]{0,3}$/",$params->quantity)){
    $session->cart[$params->id] = (int) $params->quantity;
    header("location: cart.php?id=$params->id");
} else {
    $session->message = "Invalid value";
    header("location: showItem.php?item_id=$params->id");
}


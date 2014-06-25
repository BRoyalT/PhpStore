<?php

require_once "include/DB.php";

define("SECONDS_PER_DAY", 3600 * 24);

$props = DB::init();
echo "\naddJoins -- url: {$props['url']}\n\n";

$now = time();

$alice = R::findOne('user','name=?',array("alice"));
$john = R::findOne('user','name=?',array("john"));
$bill = R::findOne('user','name=?',array("bill"));
$dave = R::findOne('user','name=?',array("dave"));

$item1 = R::load('item', 1);
$item3 = R::load('item',3);
$item5 = R::load('item', 5);
$item6 = R::load('item', 6);
$item13 = R::load('item', 13);
$item15 = R::load('item', 15);
$item22 = R::load('item', 22);
$item26 = R::load('item', 26);
$item31 = R::load('item', 31);

$user = $alice;
$order = R::dispense('order');
$order->user_id = $user->id;
$order->created_at = $now - 5 * SECONDS_PER_DAY;
$order->link('item_order', 
        array('quantity' => 2,'price'=>$item1->price))->item = $item1;
$order->link('item_order', 
        array('quantity' => 3,'price'=>$item5->price))->item = $item5;
$id = R::store($order);
echo "#$id: $user->name\n";

$user = $alice;
$order = R::dispense('order');
$order->user_id = $user->id;
$order->created_at = $now - 4 * SECONDS_PER_DAY;
$order->link('item_order', 
        array('quantity' => 3,'price'=>$item13->price))->item = $item13;
$order->link('item_order', 
        array('quantity' => 1,'price'=>$item22->price))->item = $item22;
$id = R::store($order);
echo "#$id: $user->name\n";

$user = $alice;
$order = R::dispense('order');
$order->user_id = $user->id;
$order->created_at = $now - 1 * SECONDS_PER_DAY;
$order->link('item_order', 
        array('quantity' => 4,'price'=>$item3->price))->item = $item3;
$order->link('item_order', 
        array('quantity' => 1,'price'=>$item31->price))->item = $item31;
$id = R::store($order);
echo "#$id: $user->name\n";

$user = $bill;
$order = R::dispense('order');
$order->user_id = $user->id;
$order->created_at = $now - 2 * SECONDS_PER_DAY;
$order->link('item_order', 
        array('quantity' => 1,'price'=>$item22->price))->item = $item22;
$order->link('item_order', 
        array('quantity' => 2,'price'=>$item26->price))->item = $item26;
$id = R::store($order);
echo "#$id: $user->name\n";

$user = $bill;
$order = R::dispense('order');
$order->user_id = $user->id;
$order->created_at = $now - 0 * SECONDS_PER_DAY;
$order->link('item_order', 
        array('quantity' => 1,'price'=>$item1->price))->item = $item1;
$order->link('item_order', 
        array('quantity' => 3,'price'=>$item3->price))->item = $item3;
$order->link('item_order', 
        array('quantity' => 1,'price'=>$item5->price))->item = $item5;
$order->link('item_order', 
        array('quantity' => 2,'price'=>$item6->price))->item = $item6;
$id = R::store($order);
echo "#$id: $user->name\n";

$user = $dave;
$order = R::dispense('order');
$order->user_id = $user->id;
$order->created_at = $now - 3 * SECONDS_PER_DAY;
$order->link('item_order', 
        array('quantity' => 3,'price'=>$item22->price))->item = $item22;
$order->link('item_order', 
        array('quantity' => 1,'price'=>$item31->price))->item = $item31;
$id = R::store($order);
echo "#$id: $user->name\n";


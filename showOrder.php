<!--Ricardo Neiderer
    CSC 417-80
    4/18/14-->

<?php
require_once "include/Session.php";
$session = new Session();
require_once "include/DB.php";
DB::init();

$params = (object) $_REQUEST;

$isLoggedIn = false;
$isSuperUser = false;
if (isset($session->user)){
    $userId = $session->user->id;
    $isLoggedIn = true;
    $isSuperUser = $session->user->level > 0;
}

$order = R::load('order', $params->id);
$user = R::load('user', $order->user_id);

if (isset($params->delete)){
    foreach($order->sharedItem as $item_id => $item){
        unset($order->sharedItem[$item->id]);
    }
    R::trash($order);
    header("location: cart.php");
}

?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<title>Show Order</title>
<link rel="stylesheet" type="text/css" href="css/superfish.css" />
<link rel="stylesheet" type="text/css" href="css/layout.css" />
<link rel="stylesheet" type="text/css" href="css/table-display.css" />
<style type="text/css">
.action {
  display: inline-block;
  margin: 10px 0;
  border: solid 1px black;
  padding: 15px;
}
.super {
  display: inline-block;
  margin: 10px 0;
  padding: 10px;
  border: solid 2px red;
}
.super form {
  display: inline-block;
  margin: 0 10px;
}
</style>
</head>

<body>
<div class="container">
<div class="header"><?php require_once "include/header.php" ?></div>
<div class="navigation"><?php require_once "include/navigation.php" ?></div>
<div class="content"><!-- content -->

<h2>Order</h2>

<table>
  <tr> <th>id:</th> <td><?php echo $order->id?></td> </tr>
  <tr> <th>ordered by:</th> <td><?php echo $user->name?></td> </tr>
  <tr> <th>ordered on:</th> <td><?php echo date('Y-m-d-h', $order->created_at)?></td> </tr>
  <tr><th>items:</th></tr>
  <?php foreach($order->sharedItem as $item_id => $item):?>
  <tr><td><?php echo $item->name?></td><td><?php echo $item->category?></td>
      <td><?php echo $item->price?></td></tr>
  <?php endforeach ?>
</table>

    <?php if ($isSuperUser): ?>
    <br />
    <div class='super'>
      <form action="showOrder.php" method="post">
        <input type='hidden' name='id' value="<?php echo $order->id?>" />
        <button type="submit" name="delete">Delete Order</button>
      </form>
    </div>
    <?php endif ?>
</div><!-- content -->
</div><!-- container -->

<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="js/superfish.min.js"></script>
<script type="text/javascript" src="js/init.js"></script>
<script type="text/javascript">
$(function(){
  $("button[name='delete']").click(function(){
    return confirm("Are you sure?");
  });
});
</script>

</body>
</html>

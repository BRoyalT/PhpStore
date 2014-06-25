<!--Ricardo Neiderer
    CSC 417-80
    4/17/14-->

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
    if ($isSuperUser){
        $orders = R::find('order', "1 order by created_at");
        $user;
        $creationTime;
    } else {
        $orders = R::find('order', "user_id='$userId' order by created_at");
        $creationTime;
    }
}

if(!isset($session->cart)){
    $session->cart = array();
}


if (isset($params->generateOrder)){
    $newOrder = R::dispense('order');
    $newOrder->user_id = $session->user->id;
    $newOrder->created_at = time();
    $itemIds = array_keys($session->cart);
    foreach($itemIds as $orderItemId){
        $orderItem = R::load('item', $orderItemId);
        $newOrder->link('item_order', array('quantity'=> $session->cart[$orderItemId], 
            'price' => $orderItem->price))->item = $orderItem;
    }
    R::store($newOrder);
    foreach($itemIds as $key){
        unset($session->cart[$key]);
    }
    $session->message = "Order generated.";
}

if (isset($params->clearItems)) {
    foreach(array_keys($session->cart) as $key){
    unset($session->cart[$key]);
    }
    $session->message = "Successful clear.";
} 

if (isset($params->updateCart)&&!is_null($params->change)){
$changes = $params->change;
$ids = array_keys($session->cart);
for($i=0; $i<count($changes); $i++){
    if($changes[$i]>0){
        $session->cart[$ids[$i]] = $changes[$i];  
    }   
}
$session->message = "Cart updated.";
} 

if (isset($params->updateCart) && !is_null($params->delete)) {
$toBeDeleted = $params->delete;
foreach ($toBeDeleted as $del) {
    unset($session->cart[$del]);
}
$session->message = "Cart updated.";
} 

$selectedItemsIds = array_keys($session->cart);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <title>My Cart</title>
        <link rel="stylesheet" type="text/css" href="css/superfish.css" />
        <link rel="stylesheet" type="text/css" href="css/layout.css" />
        <link rel="stylesheet" type="text/css" href="css/table-display.css" />
        <style type="text/css">
            /* local style rules */
        </style>

    </head>

    <body>
        <div class="container">
            <div class="header"><?php require_once "include/header.php" ?></div>
            <div class="navigation"><?php require_once "include/navigation.php" ?></div>
            <div class="content"><!-- content -->

                <h2>My Cart</h2>
<!--Session debug bar for testing ===========================================--
                <div id="debug">session: <?php //echo $session; ?><br /> 
                    params: <?php //print_r(var_dump($params)); ?><br/>
                </div>
=========================================================================-->
                <form action="cart.php" method="post">
                    <table>
                        <tr>
                            <th>ITEM</th>
                            <th>PRICE</th>
                            <th>QUANTITY</th>
                            <th>DELETE</th>
                            <th>CHANGE QUANTITY</th>
                        </tr>
                    <?php foreach ($selectedItemsIds as $id): ?>
                            <?php $item = R::load('item', $id) ?>
                        <tr>
                            <td><a href="showItem.php?item_id=<?php echo $item->id ?>">
                                <?php echo htmlspecialchars($item->name) ?></a>
                            </td>
                            <td><?php echo number_format($item->price, 2) ?></td>
                            <td><?php echo $session->cart[$item->id] ?></td>
                            <td><input type="checkbox" name="delete[]" 
                                       value="<?php echo $id ?>"</td>
                            <td><input type="number" name="change[]"></td>
                        </tr>
                    <?php endforeach; ?>
                    </table>
                    <button type="submit" name="updateCart" 
                            value="update">Update Cart</button>
                    <button type="submit" name="clearItems" 
                            value="clear">Clear All Items</button>
                    <button type="sumbit" name="generateOrder">Generate Order</button>
                </form>
            
            <?php if ($isLoggedIn):?>
            <div>
                <h3>My Orders</h3>
                <table>
                    <?php foreach($orders as $order):?>
                    <tr>
                        <?php $user=R::load('user', $order->user_id)?>
                        <td><?php echo $order->id?></td><td><?php echo $user->name?></td>
                        <td><a href="showOrder.php?id=<?php echo $order->id?>">
                            <?php echo date('Y-m-d-h', $order->created_at)?></a></td>
                    </tr>
                    <?php endforeach?>
                </table>
            </div>
            <?php endif?>
           </div><!-- content -->
        </div><!-- container -->

        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="js/superfish.min.js"></script>
        <script type="text/javascript" src="js/init.js"></script>
        <script type="text/javascript">
            $(function() {
                $("button[name = updateCart]").click(function() {
                    return confirm("Update your cart?");
                });
            });
            
            $(function() {
                $("button[name = generateOrder]").click(function() {
                    return confirm("Order your cart?");
                });
            });

            $(function() {
                $("button[name = clearItems]").click(function() {
                    return confirm("Clear your cart?");
                });
            });
        </script>

    </body>
</html>

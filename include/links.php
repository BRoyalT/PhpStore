<?php
require_once "include/Session.php";
$session = new Session();
?>
<li><a href=".">Home</a></li>
<li><a href="cart.php">My Cart</a></li>


<?php if (isset($session->user) && $session->user->level > 0): ?>
<li><a href="addItem.php">Add Item</a></li>
<?php endif ?>

<li>
<?php if (!isset($session->user)): ?>
  <a href="login.php">Login</a>
<?php else: ?>
  <a href="logout.php">Logout</a>
<?php endif ?>
</li>
<li><a href="help.php">Help</a></li>

<?php
require_once "include/Session.php";
$session = new Session();

if (!isset($session->user) || $session->user->level == 0) {
  die("prohibited");
}

require_once "include/DB.php";
DB::init();

$params = (object) $_REQUEST;
//print_r($params);

if (isset($params->doit)) {
  try {
    $name = trim($params->name);
    $price = trim($params->price);
    $category = $params->category;
    $description = $params->description;
    $image = $params->image;

    if (!preg_match("^\d{0,3}\.\d{2}^", $price)) {
      throw new Exception("Illegal price format.");
    }
    if (strlen($name) < 3) {
      throw new Exception("Item name must have at least 3 chars.");
    }

    $item = R::dispense('item');
    $item->name= $name;
    $item->price = $price;
    $item->category = $category;
    $item->description = $description;
    $item->image = $image;
    $id = R::store($item);
    header("location: showItem.php?item_id=$id");
    exit();
  //} catch (RedBean_Exception_SQL $ex) {
  //  $response = "duplicate title";
  } catch (Exception $ex) {
    $response = $ex->getMessage();
  }
}
else {
  $response = "";
  $params->name = "";
  $params->price = "0.00";
  $params->category = "accessory";
  $params->description = "";
  $params->image = "";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<title>Add Item</title>

<link rel="stylesheet" type="text/css" href="css/superfish.css" />
<link rel="stylesheet" type="text/css" href="css/layout.css" />
<link rel="stylesheet" type="text/css" href="css/table-display.css" />
<link rel="stylesheet" type="text/css" href="css/item-form.css" />
<style type="text/css">
</style>

</head>

<body>
<div class="container">
<div class="header"><?php require_once "include/header.php" ?></div>
<div class="navigation"><?php require_once "include/navigation.php" ?></div>
<div class="content"><!-- content -->

<h2>Add Item</h2>

<form action="addItem.php" method="post">
  <table>
    <tr>
      <th>name:</th>
      <td><input type='text' name='name' 
                 value="<?php echo htmlspecialchars($params->name) ?>" />
      </td>
    </tr>
    <tr>
        <th>price:</th>
        <td>
            <input type="text" name="price" value="<?php echo $params->price?>"/>
        </td>
    </tr>
    <tr>
        <th>category:</th>
        <td>
            <select name="category">
                <option value="accessory">accessory</option>
                <option value="calculator">calculator</option>
                <option value="camera">camera</option>
                <option value="computer">computer</option>
                <option value="copy-scan">copy-scan</option>
                <option value="network">network</option>
                <option value="printer">printer</option>
                <option value="storage">video-audio</option>
                <option value="voice">voice</option>
            </select>
        </td>
    </tr>
    <tr>
        <th>description:</th>
        <td>
            <textarea name="description" value="<?php echo $params->description?>"></textarea>
        </td>
    </tr>
    <tr>
        <th>image:</th>
        <td>
            <input type="text" name="image" value="<?php echo $params->image?>"/>
        </td>
    </tr>
    <tr>
      <td></td>
      <td><button type="submit" name="doit">Add</button></td>
    </tr>
  </table>
</form>

<h3><?php echo $response?></h3>

</div><!-- content -->
</div><!-- container -->

<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="js/superfish.min.js"></script>
<script type="text/javascript" src="js/init.js"></script>
<script type="text/javascript">
/* local JavaScript */
</script>

</body>
</html>


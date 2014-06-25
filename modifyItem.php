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

$item = R::load('item',$params->id);
if ($item->id == 0) {
  die("no such book for id $params->id");
}

if (isset($params->doit)) {
  try {
    $name = trim($params->name);
    $price = trim($params->price);
    $category = $params->category;
    $description = $params->description;
    $image = $params->image;

    if (!preg_match("^\d{0,3}\.\d{2}^", $price)) {
      throw new Exception("Illegal price format");
    }
    if (strlen($name) < 3) {
      throw new Exception("title must have at least 3 chars");
    }
    $item->name= $name;
    $item->price = $price;
    $item->category = $category;
    $item->description = $description;
    $item->image = $image;
    $id = R::store($item);
    header("location: showItem.php?item_id=$id");

  } catch (Exception $ex) {
    $response = $ex->getMessage();
  }
}
else {
  $response = "";
  $params->name = $item->name;
  $params->price = $item->price;
  $params->category = $item->category;
  $params->description = $item->description;
  $params->image = $item->image;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<title>Modify Item</title>

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

<h2>Modify Item</h2>

<form action="modifyItem.php" method="post">
  <input type="hidden" name="id" value="<?php echo $params->id ?>" />
  <input type="hidden" name="name" value="<?php echo $params->name?>"/>
  <input type="hidden" name="category" value="<?php echo $params->category?>"/>
  <table>
    <tr>
      <th>id:</th>
      <td><?php echo $params->id ?></td>
    </tr>
    <tr>
      <th>name:</th>
      <td><?php echo $params->name ?></td>
    </tr>
    <tr>
      <th>category:</th>
      <td><?php echo $params->category ?></td>
    </tr>
    <tr>
        <th>price:</th>
        <td><input type="text" name="price" value="<?php echo $params->price?>"</td>
    </tr>
    <tr>
        <th>description:</th>
        <td>
            <textarea  name="description"><?php echo $params->description?></textarea>
        </td>
    </tr>
    <tr>
        <th>image:</th>
        <td>
            <input type="text" name="image" value="<?php echo $params->image?>"/>
        </td>
    </tr>
    <tr>
      <td><button type="submit" name="doit">Modify</button></td>
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

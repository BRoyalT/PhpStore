<?php 
$items_file = "setup/items.txt";
$descriptions_dir = "setup/descriptions";
if (!file_exists($items_file)) {
  die("missing file $items_file\n");
}
if (!is_dir($descriptions_dir)) {
  die("missing directory $descriptions_dir\n");
}

require_once "include/DB.php";
$props = DB::init();
echo "\naddItems -- url: {$props['url']}\n\n";

$items = file($items_file);

// populate by obtaining title and randomizing binding and quantity
$num = 0;
foreach($items as $str) {
  $info = trim($str);
  if (empty($info)) continue;
  if (substr($info,0,1) == "#") continue;
  list($category, $name, $price, $file) 
          = array_map('trim', explode("|", $info));
  echo "$category|$name|$price|$file\n";
  $item = R::dispense('item');
  $item->name = $name;
  $item->category = $category;
  $item->price = $price;
  $item->image = "$file.jpg";
  $descrip_file = "$descriptions_dir/$file.html";
  if (file_exists($descrip_file)) {
    $item->description = file_get_contents($descrip_file);
  } else {
    $item->description = "";
  }
  try {
    $id = R::store($item);
    echo "#$id: $name\n";
  }
  catch(Exception $ex) {  // accidental duplicate title
    echo $ex->getMessage(), "\n"; 
  }
}

<!--Ricardo Neiderer
    CSC 417-80
    Program 2
    4/17/14-->

<?php
require_once "include/DB.php";
DB::init();

$params = (object) $_REQUEST;

// List ordering code ==========================================================
$orderfield = "name";
if (isset($params->orderField)) {
    $orderfield = $params->orderField;
}

// Pagination code =============================================================
$items_per_page = 15;
$page = 1;
if (isset($params->page)) {
    $page = $params->page;
}
$offset = ($page - 1) * $items_per_page;

// Page loading ================================================================
$items = R::findAll('item', "1 order by $orderfield asc limit $offset,$items_per_page");

$num_pages = ceil(R::count('item') / $items_per_page);

$paging_url = "index.php?orderField=$orderfield";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="css/superfish.css" />
        <link rel="stylesheet" type="text/css" href="css/layout.css" />
        <link rel="stylesheet" type="text/css" href="css/table-display.css" />
        <!--Navigation bar style -->
        <style type="text/css">   
            #nav_bar {
                background: #000;
                color: #fff;
                margin-bottom: 15px;
                line-height: 25px;
                height: 25px;
                padding-left: 5px;
                cursor: pointer;
                border-radius: 6px;
            }
            #nav_bar a {
                color: #fff;
                font-weight: bold;
                padding: 0 5px;
                outline: none;
            }
            #nav_bar a:nth-child(<?php echo $page ?>) {
                color: magenta;
            }
        </style>
        <!--=====================-->
    </head>

    <body>
        <div class="container">
            <div class="header"><?php require_once "include/header.php" ?></div>
            <div class="navigation"><?php require_once "include/navigation.php" ?></div>
            <div class="content"><!-- content -->

                <h2>Store Items</h2>
                <!--Page number links-->
                <div id="nav_bar">
                    Pages:
                    <?php for ($num = 1; $num <= $num_pages; ++$num): ?>
                        <a href="<?php echo "$paging_url&page=$num" ?>"><?php echo $num ?></a>
                    <?php endfor ?>
                </div>
                <!--=================-->
                <table>
                    <tr>
                        <!--Category listing links-->
                        <th><a href = "index.php?orderField=name"?>name</a></th>
                        <th><a href = "index.php?orderField=category"?>category</a></th>
                        <th><a href = "index.php?orderField=price"?>price</a></th>
                        <!--======================-->
                    </tr>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><a href="showItem.php?item_id=<?php echo $item->id ?>">
                                    <?php echo htmlspecialchars($item->name) ?></a>
                            </td>
                            <td><?php echo $item->category ?></td>
                            <td><?php echo number_format($item->price, 2) ?></td>
                        </tr>
                    <?php endforeach ?>
                </table>

            </div><!-- content -->
        </div><!-- container -->

        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="js/superfish.min.js"></script>
        <script type="text/javascript" src="js/init.js"></script>
        <script type="text/javascript">
        </script>

    </body>
</html>

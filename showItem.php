<!--Ricardo Neiderer
    CSC 417-80
    4/17/14-->

<?php
require_once "include/Session.php";
$session = new Session();
require_once "include/DB.php";
DB::init();

$params = (object) $_REQUEST;

$item = R::load('item', $params->item_id);

$superUser = false;
if (isset($session->user)) {
    $superUser = $session->user->level > 0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <title>Item Features</title>
        <link rel="stylesheet" type="text/css" href="css/superfish.css" />
        <link rel="stylesheet" type="text/css" href="css/layout.css" />
        <link rel="stylesheet" type="text/css" href="css/table-display.css" />
        <style type="text/css">
            .block {
                display: inline-block;
                vertical-align: top;
            }
            .item-descrip {
                max-width: 375px;
                margin: 2px 5px;
            }
            .item-descrip {
                margin: 2px 5px;
            }
            .item-descrip header {
                font-weight: bold;
                margin: 2px 0 5px 0;
            }
            .item-image img {
                max-width: 300px;
                margin-top: 5px;
            }
            .item-features {
                margin-right: 40px;
                max-width: 400px;
            }
            .item-cart {
                margin: 5px;
                padding: 5px 10px;
                border: solid 2px  red;
                border-radius: 4px;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="header"><?php require_once "include/header.php" ?></div>
            <div class="navigation"><?php require_once "include/navigation.php" ?></div>
            <div class="content"><!-- content -->

                <h2>Item Features</h2>
                <!--Session debug bar for testing ===========================================
                <div id="debug">session: <?php //echo $session; ?></div>
                <!--=========================================================================-->

                <div class="block item-features">
                    <table>
                        <tr> <th>id:</th> <td><?php echo $item->id ?></td> </tr>
                        <tr> <th>name:</th> <td><?php echo htmlspecialchars($item->name) ?></td> </tr>
                        <tr> <th>category:</th> <td><?php echo $item->category ?></td> </tr>
                        <tr> <th>price:</th> <td>$<?php echo $item->price ?></td> </tr>
                    </table>
                </div>

                <div class="block item-cart">
                    <form action="addCart.php">
                        <b>Say Something</b><br />
                        <input type="hidden" name="id" value="<?php echo $item->id ?>" />
                        <!--Quantity determination ==============================================-->
                        quantity:
                        <input type="text" size="5" name="quantity"/><br />
                        <button type="submit" name="doit" value="Add">DoIt</button>
                    </form>
                </div>

                <br />
                <div class="block item-descrip">
                    <header>description:</header>
                    <?php if (empty($item->description)): ?>
                        <strong>Not Available</strong>
                    <?php else: ?>
                        <?php echo $item->description ?>
                    <?php endif ?>
                </div>
                <div class="block item-image">
                    <img src="images/items/<?php echo $item->image ?>" />
                </div>

            
            <?php if ($superUser): ?>
                <br />
                <div class='super'>
                    <form action="modifyItem.php" method="get">
                        <input type='hidden' name='id' value="<?php echo $item->id ?>" />
                        <button type="submit">Modify</button>
                    </form>
                </div>
            <?php endif ?>
          </div><!-- content -->
        </div><!-- container -->


        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="js/superfish.min.js"></script>
        <script type="text/javascript" src="js/init.js"></script>
        <script type="text/javascript">
            $(function() {
                $("button[name = doit]").click(function() {
                    return confirm("Add to cart?");
                });
            });
        </script>

    </body>
</html>

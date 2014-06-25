<?php
require_once "include/Session.php";
$session = new Session();
if (isset($session->user)) {
  require_once "index.php";
  exit();
}
$message = $session->message;
$username = $session->username;
unset($session->message);
unset($session->username);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<title>Login</title>
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

<h2>Login</h2>

<p>Please enter access information</p>
<form action="validate.php" method="post" autocomplete="off">
  <table>
    <tr>
      <th>user:</th>
      <td><input type="text" name="username" autofocus="on"
                 value="<?php echo htmlspecialchars($username) ?>" /></td>
    </tr>
    <tr>
      <th>password:</th>
      <td><input type="password" name="password" /></td>
    </tr>
    <tr>
      <td></td>
      <td><button type="submit">Access</button></td>
    </tr>
  </table>
</form>
  
<h3 id="response"><?php echo $message ?></h3>

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

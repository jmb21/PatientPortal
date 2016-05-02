<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for User Controller</title>
</head>
<body>
<h1>User controller tests</h1>

<?php
include_once("../controllers/UserController.class.php");
include_once("../models/Database.class.php");
include_once("../models/Messages.class.php");
include_once("../models/Thread.class.php");
include_once("../models/ThreadDB.class.php");
include_once("../models/User.class.php");
include_once("../models/UsersDB.class.php");
include_once("../views/HomeView.class.php");
include_once("../views/MasterView.class.php");
include_once("../views/UserView.class.php");
include_once("./DBMaker.class.php");
?>

<h2>It should should show a user that exists</h2>
<?php 
DBMaker::create('ptest');
$_SERVER ["REQUEST_METHOD"] = "POST";
$_SESSION = array('base' => 'bj_lab5', 'control' => 'user', 
	                      'action' =>'show', 'arguments' => 2);
UserController::run();
?>


<?php 
/* Goes Home because the user doesnt exist
DBMaker::create('ptest');
$_SERVER ["REQUEST_METHOD"] = "GET";
$_SESSION = array('base' => 'bj_lab3', 'control' => 'user',
		             'action' =>'show', 'arguments' => 0);
UserController::run();
*/
?>

<?php ob_end_flush();  ?>
</body>
</html>
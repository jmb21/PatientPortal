<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for Login Controller</title>
</head>
<body>
<h1>Login controller tests</h1>

<?php
include_once("../controllers/LoginController.class.php");
include_once("../models/Database.class.php");
include_once("../models/Messages.class.php");
include_once("../models/User.class.php");
include_once("../models/UsersDB.class.php");
include_once("../views/HomeView.class.php");
include_once("../views/LoginView.class.php");
include_once("../views/MasterView.class.php");
include_once("./DBMaker.class.php");
?>

<h2>It should call the run method for valid input during $POST</h2>

<?php 
$myDb = DBMaker::create('ptest');
$_SERVER ["REQUEST_METHOD"] = "POST";
$_SERVER["REQUEST_URI"] = "/bj_lab5/login";
$_POST = array("userName" => "Jon", "password" => "abc");
$_SESSION = array('base' => 'bj_lab5', 'control' => 'login', 'action' => '', 'arguments' => null);
LoginController::run();
?>

<h2>It should have an error when user doesn't provide a password</h2>
<?php 

$myDb = DBMaker::create('ptest');
$_SERVER ["REQUEST_METHOD"] = "POST";
$_SERVER["REQUEST_URI"] = "/bj_lab5/login";
$_POST = array("userName" => "Jon");
$_SESSION = array('base' =>'bj_lab5', 'control' => 'login', 'action' => '', 'arguments' => null);
LoginController::run();
?>


<h2>It should call show the login page for a $GET request</h2>
<?php 
$_SERVER ["REQUEST_METHOD"] = "GET";
$_SERVER["REQUEST_URI"] = "/bj_lab5/login";
$_SESSION = array('base'=> 'bj_lab5', 'control' => 'login', 'action' => '', 'arguments' => null);
LoginController::run();

?>

</body>
</html>
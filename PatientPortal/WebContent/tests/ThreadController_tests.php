<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for Thread Controller</title>
</head>
<body>
<h1>Thread controller tests</h1>

<?php
include_once("../controllers/ThreadController.class.php");
include_once("../models/Database.class.php");
include_once("../models/Messages.class.php");
include_once("../models/Thread.class.php");
include_once("../models/ThreadDB.class.php");
include_once("../models/User.class.php");
include_once("../models/UsersDB.class.php");
include_once("../views/HomeView.class.php");
include_once("../views/MasterView.class.php");
include_once("../views/ThreadView.class.php");
include_once("../views/UserView.class.php");
include_once("./DBMaker.class.php");
?>

<h2>It should call a new thread form input during $POST with incomplete information</h2>
<?php 
DBMaker::create('ptest');
$_SERVER ["REQUEST_METHOD"] = "POST";
$_SESSION = array('base' => 'bj_lab5', 'control' => 'thread', 
	                      'action' =>'new', 'arguments' => null);
$_POST = array("submitterName" => "Jon");
ThreadController::run();
?>

<h2>It should call show a new thread form for a $GET request</h2>
<?php 
$_SERVER ["REQUEST_METHOD"] = "GET";
$_SESSION = array('base' => 'bj_lab5', 'control' => 'thread',
		             'action' =>'new', 'arguments' => null);
ThreadController::run();
?>
</body>
</html>
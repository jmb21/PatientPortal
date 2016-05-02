<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for User View</title>
</head>
<body>
<h1>User view tests</h1>

<?php
include_once("../models/Messages.class.php");
include_once("../models/Thread.class.php");
include_once("../models/User.class.php");
include_once("../views/UserView.class.php");
include_once("../views/MasterView.class.php");
?>

<h2>It should show successfully when user is passed to show</h2>
<?php 
$validTest = array("userName" => "Jon", "password" =>"abc");
$_SESSION = array('user' => new User($validTest), 'base' => 'bj_lab5');
$validThread = array("submitterName" => "Jon");
$_SESSION['userThreads'] = array (new Thread($validThread));
UserView::show();
?>

<h2>It should show all users when the session variable is set</h2>
<?php 
$s1 = new User(array("userName" => "Jon", "password" => "abc"));
$s1 -> setUserId(1);
$s2 = new User(array("userName" => "Steven", "password" => "123"));
$s2 -> setUserId(2);
$s3 = new User(array("userName" => "Kai", "password" => "DoReMe"));
$s3 -> setUserId(3);
$s4 = new User(array("userName" => "Mike", "password" => "xyz"));
$s4 -> setUserId(3);

$_SESSION = array('users' => array($s1, $s2, $s3, $s4), 'base' => 'bj_lab5', 'arguments' =>null);
UserView::showall();
?>

<h2>It should allow updating when a valid user is passed</h2>
<?php 
$validTest = array("userName" => "Jon", "password" => "xxx");
$user = new User($validTest);
$user->setUserId(1);
echo $user;
$_SESSION = array('users' => array($user), 'base' => "bj_lab5");
UserView::showUpdate();
?>
</body>
</html>
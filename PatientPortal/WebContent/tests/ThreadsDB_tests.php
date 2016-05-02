<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for ThreadDB</title>
</head>
<body>
<h1>ThreadsDB tests</h1>


<?php
include_once("../models/Database.class.php");
include_once("../models/Messages.class.php");
include_once("../models/Thread.class.php");
include_once("../models/ThreadDB.class.php");
include_once("../models/User.class.php");
include_once("../models/UsersDB.class.php");
include_once("./DBMaker.class.php");
?>


<h2>It should get all threads from a test database</h2>
<?php
DBMaker::create('ptest'); 
Database::clearDB();
$db = Database::getDB('ptest');
$threads = ThreadDB::getThreadsBy();
$threadCount = count($threads);
echo "Number of threads in db is: $threadCount <br>";
foreach ($threads as $thread) 
	echo "$thread <br>";
?>	

<h2>It should insert a valid thread in the database</h2>
<?php 
DBMaker::create('ptest');
Database::clearDB();
$db = Database::getDB('ptest', 'C:\xampp\myConfig.ini');
$beforeCount = count(ThreadDB::getThreadsBy());
$validTest = array("submitterName" => "Mike");
$s1 = new Thread($validTest);
echo "<br>In insertion should not have errors $s1<br>";
print_r($s1->getErrors());
$newS1 = ThreadDB::addThread($s1);
$afterCount = count(ThreadDB::getThreadsBy());
echo 'The inserted thread Id is:'. $newS1->getThreadId().'<br>';
echo "Before the database has $beforeCount";
echo "Now the database has $afterCount";
?>

<h2>It should not allow insertion of a duplicate thread</h2>
<?php 
DBMaker::create('ptest');
Database::clearDB();
$db = Database::getDB('ptest', 'C:\xampp\myConfig.ini');
$beforeCount = count(ThreadDB::getThreadsBy());
$duplicateTest =  array("submitterName" => "Mike");
$s1 = new Thread($duplicateTest);
$newS1 = ThreadDB::addThread($s1);
$afterCount = count(ThreadDB::getThreadsBy());
echo "The inserted thread errors:";
print_r($newS1->getErrors());
echo "Before the database has $beforeCount";
echo "Now the database has $afterCount";
?>

<h2>It should get a thread by submitter name</h2>
<?php 
DBMaker::create('ptest');
Database::clearDB();
$db = Database::getDB('ptest', 'C:\xampp\myConfig.ini');
$threads = ThreadDB::getThreadsBy('submitterName', 'Jon');
echo "<br>Number of threads by Jon is ". count($threads);
foreach ($threads as $thread)
    echo "<br>Thread: $thread<br>";
?>
</body>
</html>
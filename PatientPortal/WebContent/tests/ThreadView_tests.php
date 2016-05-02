<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for Thread View</title>
</head>
<body>
<h1>ThreadView tests</h1>

<?php
include_once("../models/Messages.class.php");
include_once("../models/Thread.class.php");
include_once("../views/MasterView.class.php");
include_once("../views/ThreadView.class.php");
?>

<h2>It should show a thread with a header and footer</h2>
<?php 
$validSubmission = array("submitterName" => "Jon");
$s1 = new Thread($validSubmission);
$_SESSION = array('thread' => $s1, 'base' => "bj_lab5");

ThreadView::show();
?>


<h2>It should show a thread table with a header and a footer</h2>
<?php 
$validSubmission = array("submitterName" => "Jon");

$s1 = new Thread($validSubmission);
$s1 -> setThreadId(1);
$threads = array($s1, $s1);
$_SESSION = array('threads' => $threads,
   		            'headerTitle' => "DD Threads",
		            'footerTitle' => "<h3>The footer goes here</h3>",
		            'base' => "bj_lab5");
ThreadView::showall();
?> 
 
<h2>It should show a thread table without a header and a footer</h2>
<?php 
$s1 -> setThreadId(1);
$threads = array($s1, $s1);
$_SESSION = array('threads' => $threads,
		            'base' => "bj_lab5");
ThreadView::showall();
?>  
</body>
</html>
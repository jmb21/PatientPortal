<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Basic tests for Submission</title>
</head>
<body>
<h1>Thread tests</h1>

<?php
include_once("../models/Messages.class.php");
include_once("../models/Thread.class.php");
include_once("../models/User.class.php");
?>

<h2>It should create a valid Thread object when all input is provided</h2>
<?php 
$validTest = array("submitterName" => "Jon");

$s1 = new Thread($validTest);
echo "The object is: $s1<br>";
echo "The object was created<br>";
$test1 = (is_a($s1, 'Thread'))?'':
'Failed:It should create a valid object when valid input is provided<br>';
echo $test1;
$test2 = (empty($s1->getErrors()))?'':
'Failed:It not have errors when valid input is provided<br>';
print_r($s1->getErrors());
echo $test2;
?>
</body>
</html>
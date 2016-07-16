<?php


require_once "vendor/autoload.php";
require_once "Actions.php";

use UsamaNoman\WitConverse\WitConverse;

$actions=new Actions();
$wit = new WitConverse($actions,"O5XGUSYTHYXXAWFT6XGJ362EGPPQ3BVF");
$context=[];
$old='';
$message='';

echo "<pre>";

$old=$message;
$response=($wit->getBotReply("How are you doing?","123abc",$context));
$context=$response['context'];
$message=$response['text'];
echo $message;

$old=$message;
$response=($wit->getBotReply("How are you doing?","123abc",$context));
$context=$response['context'];
$message=$response['text'];
echo "<br>".$message;


echo "</pre>";
?>
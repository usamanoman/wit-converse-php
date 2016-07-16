<?php


require_once "vendor/autoload.php";
require_once "Actions.php";

use UsamaNoman\WitConverse\WitConverse;

$actions=new Actions();
$wit = new WitConverse($actions,"123a1223","token","O5XGUSYTHYXXAWFT6XGJ362EGPPQ3BVF");
$context=$wit->replyToUser("How are you?",[]);
$context=$wit->replyToUser("No I am fine, thanks.",$context);
// $wit = new WitConverse($actions,"O5XGUSYTHYXXAWFT6XGJ362EGPPQ3BVF");
// $context=$wit->replyToUser("asca","How are you?","123abc");


//$wit->replyToUser("asca","No I am fine, thanks.","123abc");

// echo "<pre>";

// $old=$message;
// $response=($wit->getBotReply("How are you doing?","123abc",$context));
// $context=$response['context'];
// $message=$response['text'];
// echo $message;

// $old=$message;
// $response=($wit->getBotReply("How are you doing?","123abc",$context));
// $context=$response['context'];
// $message=$response['text'];
// echo "<br>".$message;


echo "</pre>";
?>
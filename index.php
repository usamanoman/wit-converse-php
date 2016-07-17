<?php


require_once "vendor/autoload.php";
require_once "Actions.php";

use UsamaNoman\WitConverse\WitConverse;

$actions=new Actions();
$wit = new WitConverse($actions,"123a1223","token","U7LGTYN4XVUOUTDRI4Y3AZPWD72YCXPW");
// echo "1<br>";
// $context=$wit->replyToUser("How are you?",[]);
// echo "2<br>";
// $context=$wit->replyToUser("No I am fine thanks.",[]);
// echo "3<br>";
// $context=$wit->replyToUser("You are asshole.",[]);
// echo "4<br>";
// $context=$wit->replyToUser("Are you a human?",[]);
// echo "5<br>";
// $context=$wit->replyToUser("Let's go on a movie with me?",[]);
// echo "6<br>";
// $context=$wit->replyToUser("Do you love me?",[]);
// echo "7<br>";
// $context=$wit->replyToUser("Hello",[]);

// echo "8<br>";
// $context=$wit->replyToUser("I need urgent help",[]);

// echo "9<br>";
// $context=$wit->replyToUser("How are your feelings about me?",[]);
// echo "10<br>";
// $context=$wit->replyToUser("I wish we two could be together.",[]);
echo "10<br>";
$context=$wit->replyToUser("What do you do?.",[]);
echo "10<br>";
$context=$wit->replyToUser("What are namaz timings",[]);
echo "10<br>";
$context=$wit->replyToUser("in Karachi",[]);

print_r($context);
//$context=$wit->replyToUser("No I am fine, thanks.",$context);
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
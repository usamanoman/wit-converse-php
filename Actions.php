<?php


//namespace UsamaNoman\MyActions;
use UsamaNoman\WitConverse\ActionMapping;

class Actions extends ActionMapping
{
    /**
     * @inheritdoc
     */
    public function action($sessionId, $actionName, array  $context, array $entities=[])
    {
        return call_user_func_array(array($this, $actionName), array($sessionId, $context,$entities));
    }


    public function determineMood($sessionId,$context,$entities){
        return ['mood'=>'good'];
    }

    public function sendMessage($token,$userId,$msg){
        echo $msg."<br>";
    }
}
?>
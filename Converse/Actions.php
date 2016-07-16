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

    public function sayHello($sessionId,$context,$entities){
        return ["Hello"];
    }

    public function determineMood($sessionId,$context,$entities){
        return ['mood'=>'good'];
    }
}
?>
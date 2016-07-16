<?php

namespace UsamaNoman\WitConverse;
abstract class ActionMapping
{
    /**
     * @param string $sessionId
     * @param string $actionName
     * @param Context $context
     * @param array $entities
     * 
     * @return Context
     */
    abstract public function action($sessionId, $actionName, array $context, array $entities = []);
}

?>
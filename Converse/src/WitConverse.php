<?php

namespace UsamaNoman\WitConverse;
use UsamaNoman\WitConverse\Exceptions\WitConverseException;

/**
 * Class Diffbot
 *
 * The main class for API consumption
 *
 * @package UsamaNoman\WitConverse
 */
class WitConverse
{
    /** @var string The instance token, settable once per new instance */
    private $instanceToken;

    private $actionsObject;

    /**
     * @param string|null $token The API access token, as obtained on diffbot.com/dev
     * @throws DiffbotException When no token is provided
     */
    public function __construct($actionsObject,$token = null)
    {
        $this->actionsObject=$actionsObject;
        if ($token === null) {
            if (self::$token === null) {
                $msg = 'No token provided, and none is globally set. ';
                $msg .= 'Use Diffbot::setToken, or instantiate the Diffbot class with a $token parameter.';
                throw new DiffbotException($msg);
            }
        } else {
            $this->setToken($token);
        }
    }

    /**
     * Sets the token for all future new instances
     * @param $token string The API access token, as obtained on diffbot.com/dev
     * @return void
     */
    public function setToken($token)
    {
        $this->validateToken($token);
        $this->instanceToken = $token;
    }

    public function getToken(){
        return $this->instanceToken;
    }

    public function getActionsObject(){
        return $this->actionsObject;
    }


    public function getBotReply($message,$userId,$context){
        $converse= new Converse($this->getToken(),$message,$userId,$context,$this->getActionsObject());
        $context=$converse->resolve();
        return $context;
    }

    private function validateToken($token)
    {
        if (!is_string($token)) {
            throw new \InvalidArgumentException('Token is not a string.');
        }
        if (strlen($token) < 4) {
            throw new \InvalidArgumentException('Token "' . $token . '" is too short, and thus invalid.');
        }
        return true;
    }
}
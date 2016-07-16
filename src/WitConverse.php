<?php

namespace UsamaNoman\WitConverse;
use UsamaNoman\WitConverse\Exceptions\WitConverseException;
use GuzzleHttp\Client;
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
    public function __construct($actionsObject,$userId,$access_token,$token = null)
    {
        $this->actionsObject=$actionsObject;
        $this->access_token=$access_token;
        $this->userId=$userId;
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

    public function setContext($context){
        $this->context=$context;
    }

    public function replyToUser($userQuery,$context){
        $this->setContext($context);
        $json=$this->context;
        $requestParams= array_merge([
            'query'=>[
                'v'=>'20160526',
                'session_id'=>$this->userId,
                'q'=>$userQuery
            ],
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept'     => 'application/json',
                'Authorization'      => 'Bearer '.$this->instanceToken
            ],
            'verify' => false
        ],$json);

        $client = new Client();
        $r = $client->request('POST', 'https://api.wit.ai/converse',$requestParams);
        //dd(print_r(json_decode($r->getBody(),true)));
        return $this->nextStep(json_decode($r->getBody(),true),$userQuery);
    }

    public function updateContext($arr){
        $context=[];
        foreach($arr as $key =>$val){
            $context[$key]=[];
            foreach($val as $value){
                array_push($context[$key], $value['value']);
            }
        }
        return $context;
    }

    private function nextStep($arr,$userQuery){
        switch($arr['type']){
            case 'msg':
                $this->actionsObject->sendMessage($this->access_token,$this->userId,$arr['msg']);
                return $this->replyToUser($userQuery,$this->context);
            case 'action':
                $this->context=['json'=>$this->actionsObject->action($this->userId,$arr['action'],$this->context,$this->updateContext($arr['entities']))];
                //dd($this->context);
                return $this->replyToUser($userQuery,$this->context);
            case 'stop':
                return $this->context;
            case 'merge':
                return $this->context;
        }
    }
}
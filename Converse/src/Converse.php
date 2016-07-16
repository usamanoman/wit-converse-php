<?php

namespace UsamaNoman\WitConverse;
use GuzzleHttp\Client;

class Converse
{
    private $token;
    private $message;
    private $userId;

    /**
     * Create a new Skeleton Instance
     */
    public function __construct($token,$message,$userId,$context,$actionsObject)
    {
        $this->token=$token;
        $this->message=$message;
        $this->userId=$userId;
        $this->context=$context;
        $this->actionsObject=$actionsObject;
    }

    /**
     * Friendly welcome
     *
     * @param string $phrase Phrase to return
     *
     * @return string Returns the phrase passed in
     */
    public function resolve()
    {
        if(empty($this->context)||count($this->context)==0){
            $json=[];
        }else{
            $json=['json'=>$this->context];
        }
        $requestParams= array_merge([
            'query'=>[
                'v'=>'20160526',
                'session_id'=>$this->userId,
                'q'=>$this->message
            ],
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept'     => 'application/json',
                'Authorization'      => 'Bearer '.$this->token
            ],
            'verify' => false
        ],$json);

        $client = new Client();
        $r = $client->request('POST', 'https://api.wit.ai/converse',$requestParams);
        return $this->nextStep(json_decode($r->getBody(),true));
    }

    private function updateContext($arr){
        $context=[];
        foreach($arr as $key =>$val){
            $context[$key]=[];
            foreach($val as $value){
                array_push($context[$key], $value['value']);
            }
        }
        return $context;
    }

    private function nextStep($arr){
        switch($arr['type']){
            case 'msg':
                return ['text'=>$arr['msg'],'context'=>$this->context];
            case 'action':
                $this->context=$this->updateContext($arr['entities']);
                $this->context= $this->actionsObject->action($this->userId,$arr['action'],$this->context,array_keys($this->context));
                return $this->resolve();
            case 'stop':
                return ['text'=>'','context'=>$this->context];
            case 'merge':
                return [];
        }
    }
}
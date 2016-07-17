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



    public function determineNamazTimings($sessionId,$context,$entities)
    {
        if(!empty($entities['location']) && !empty($entities['athan'])){
            $location=$entities['location'][0];
                $url="https://maps.googleapis.com/maps/api/geocode/json?address=".str_replace(' ','%20',$location)."&key=AIzaSyCbgI7p-kKnykVrtdAgA19MpYiAK-lL8U4";
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', $url,['verify' => false]);
            $result=(json_decode((string)$res->getBody(),true));
            try{
                if($result['status']=='OK')
                {
                    if(count($result['results'])>1){
                                                return ['default'=>'Sorry I found multiple locations with this name. Could you be please more precise?'];
                    }else{
                        $lat= $result['results'][0]['geometry']['location']['lat'];
                        $lng= $result['results'][0]['geometry']['location']['lng'];
                        foreach($result['results'][0]['address_components'] as $addressComponents){
                            if(in_array('country', $addressComponents['types'])){
                                $country=$addressComponents['long_name'];
                            }elseif(in_array('locality', $addressComponents['types'])){
                                $city=$addressComponents['long_name'];
                            }
                        }
                                        
                        // $urlTimeZone="https://maps.googleapis.com/maps/api/timezone/json?location=".$lat.",".$lng."&timestamp=".time()."&key=AIzaSyCbgI7p-kKnykVrtdAgA19MpYiAK-lL8U4";
                        // $res = $client->request('GET', $urlTimeZone,['verify' => false]);
                        // $result=(json_decode((string)$res->getBody(),true));
                        // $timezone=$result['rawOffset']/3600;
                        //$url="http://www.islamicfinder.org/prayer_service.php?country=".$country."&city=".$city."&latitude=".$lat."&longitude=".$lng."&timezone=".$timezone."&HanfiShafi=1&pmethod=3&simpleFormat=xml";
                        
                        //Comment this line and uncomment above line for Athan API.
                        $url='http://muslimsalat.com/'.$city.'.json?key=7aa50070e080305351e6784a8f73d79b';
                        

                        $res = $client->request('GET', $url,['verify' => false,'timeout'=>3]);
                        $data=json_decode((string)$res->getBody(),true);
                        $xml=$data['items'][0];
                        //$result= file_get_contents($url);
                        //$xml=simplexml_load_string($result);
                        //Making Context
                        $response='Fajr at '.$xml["fajr"];
                        $response.='\nSunrise at '.$xml["shurooq"];
                        $response.='\nDhuhr at '.$xml["dhuhr"];
                        $response.='\nAsr at '.$xml["asr"];
                        $response.='\nMaghrib at '.$xml["maghrib"];
                        $response.='\nIsha at '.$xml["isha"];
                        return ['timings'=>$response,'location'=>$location,'method'=>$data['prayer_method_name']]; 
                    }

                }
                
            }catch(Exception $e){
                                return ['error'=>'Ops! Something wrong happened while I was trying to find out Athan timings. Can you report this error by emailing my owner at usama@botsify.com?'];
            }
        }elseif(empty($entities['location'])){
            return ['no_location'=>'No location found.'];
        }else{
            return [];
        }
    }
}
?>
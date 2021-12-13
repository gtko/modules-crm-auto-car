<?php

namespace Modules\CrmAutoCar\Services\Paytweak;

use Modules\CoreCRM\Contracts\Entities\ClientEntity;

class Paytweak
{

    protected $uri = 'https://api.paytweak.com/v1/';
//    protected $uri = 'https://api.paytweak.com/v1/';
    protected $public_key = '';
    protected $private_key = '';
    protected $user_key = '';
    protected $token_key = '';

    public function __construct($public_key, $private_key){
        $this->public_key = $public_key;
        $this->private_key =$private_key;
        $this->connect();
    }

    public function __destruct(){
        $this->disconnect();
    }

    protected function endpoint($endpoint){
        return $this->uri . $endpoint;
    }

    protected function reset(){
       $this->user_key = '';
       $this->token_key = '';
    }

    protected function resolveToken(){
        if(!$this->user_key){
            return ["Paytweak-API-KEY:$this->public_key"];
        }else{
            if(!$this->token_key){
                return ["Paytweak-USER-TOKEN:$this->user_key"];
            }
        }

        return ["Paytweak-Token:$this->token_key"];
    }

    protected function generateUserToken($security_token){
        $this->user_token = base64_encode(trim($security_token).$this->private_key);
    }

    public function connect(){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->uri."hello/");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Paytweak-API-KEY: $this->public_key"));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER , true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
        curl_setopt($ch, CURLOPT_HTTPGET , true);

        $result = curl_exec($ch);

        /* catch errors */

        if($result === false) {
            echo "Error Number:".curl_errno($ch);
            echo "Error String:".curl_error($ch);
        }

        dd($result);

        /* Connect to hello */
        $result = $this->get('hello');
        dd($result);
        $this->generateUserToken($result["Paytweak-Security-Token"] ?? '');
        $result = $this->get('verify');
        $this->token_key = $result['Paytweak-Work-Token'] ?? '';
    }

    public function disconnect(){
        $this->get('quit');
        $this->reset();
    }



    public function createLink($devis_id, $amount , ClientEntity $client, $life = 30)
    {
        return $this->post('links', [
            "order_id" => $devis_id,
            "amount" => $amount,
            'freetext' => 'Création du lien de paiement sur le CRM le ' .now()->format('d/m/Y H:i:s'),
            'firstname' => $client->firstname,
            'lastname' => $client->lastname,
            'life' => $life
        ]);
    }

    protected function get($endpoint,$queryUri = ''){
        return $this->request($endpoint, 'GET', [], $queryUri);
    }

    protected function post($endpoint, $params = [], $queryUri = ''){
        return $this->request($endpoint, 'POST', $params, $queryUri);
    }

    protected function request($enpoint, $type, $params, $queryUri = ''){
        $ch = curl_init();

        if($queryUri){
            $queryUri = '?'.$queryUri;
        }

        dump($this->resolveToken(), $enpoint);

        curl_setopt($ch, CURLOPT_URL, $this->endpoint($enpoint).$queryUri);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->resolveToken());
        curl_setopt($ch,CURLOPT_RETURNTRANSFER , 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , 1);

        if($type === 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            $query = http_build_query($params);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        }

        $result = curl_exec($ch);

        return json_decode($result, true, 512, JSON_THROW_ON_ERROR);
    }

}

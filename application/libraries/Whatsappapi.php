<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Whatsappapi 
{
    /**
 * Whatsappapi -
 * 
 * @package Whatsappapi
 * @category Whatsappapi
 * @name Barcode39
 * @version 1.0
 */
    public $apiKey = "";
    public $options = array();

    // public function __construct() {
    //     parent::__construct();
    // }
    public function sendText($options)
    {
        $result = $this->curPostRequest($options);
        echo $result;
    }
    public function sendMedia($options)
    {
        $result = $this->curPostRequest($options);
        echo $result;
    }
    public function curPostRequest($options)
    {
        /* Endpoint */
        $url = 'https://backend.aisensy.com/campaign/t1/api';
   
        /* eCurl */
        $curl = curl_init($url);
   
        /* Data */
        $data = array();
        $data['apiKey'] = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY0MmVkODMxNGVlNDI2NjI3Nzk0MDE5MCIsIm5hbWUiOiJUZWNodGFudHJhIiwiYXBwTmFtZSI6IkFpU2Vuc3kiLCJjbGllbnRJZCI6IjY0MmVkODMxNGVlNDI2NjI3Nzk0MDE4YiIsImFjdGl2ZVBsYW4iOiJCQVNJQ19NT05USExZIiwiaWF0IjoxNjgwNzkxNjAxfQ.nhZcY-nzwGfHQpv0754hWdVF3nMDMCDZ164Lss3PBak";
        $data['campaignName'] = "Insu";
        $data['destination'] = $options['mobileNumber'];
        $data['userName'] = $options['userName'];
        $data['templateParams'] = $options['fields'];
        $data['media'] = $options['media'];
        //print_r(json_encode($data));
        /* Set JSON data to POST */
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            
        /* Define content type */
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            
        /* Return json */
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
        /* make request */
       $result = curl_exec($curl);
          //  $result =":"   ;
        /* close curl */
        curl_close($curl);
        return $result;
    }
}
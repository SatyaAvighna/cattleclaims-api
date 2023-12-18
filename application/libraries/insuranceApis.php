<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class insuranceApis
{
    protected $CI;
    public $options = array();
    public function __construct() {
        $this->CI =& get_instance();
    }
    function tokenGenerator($options)
    {
        return $this->apiCall($options);
    }
    function getQuotes($options)
    {
        return $this->apiCall($options);
    }

    function apiCall($options)
    {
		$curl = curl_init();
		switch ($optionss['method']){
			case "POST":
				curl_setopt($curl, CURLOPT_POST, 1);
				if ($optionss['body'])
				{
					curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($optionss['body'], JSON_UNESCAPED_SLASHES));
				}					
				break;
			case "PUT":
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
				if ($optionss['body'])
					curl_setopt($curl, CURLOPT_POSTFIELDS, $optionss['body']);			 					
				break;
			default:
				if ($optionss['body'])
					$url = sprintf("%s?%s", $url, http_build_query($optionss['body']));
		}
		curl_setopt($curl, CURLOPT_URL, $optionss['aUrl']);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $optionss['headers']);
		// curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($curl);
		if(!$result){die("Connection Failure");}
		curl_close($curl);
		return $result;
	}
}
?>
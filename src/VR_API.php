<?php

namespace VerifiablyRandomApp\Api;

class VR_API{
	
	private $api_key = false;
	
	public function request(){
		
	}
	
	
	public function apiKey($key=false){
		if($key){
			$this->api_key = $key;
		} else {
			return $this->api_key;
		}
	}
}
?>
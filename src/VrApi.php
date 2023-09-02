<?php
namespace VerifiablyRandom\Api;

use VerifiablyRandom\Api\Validate\Requests;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class VrApi {
	
	private $api_key = false;
	private $api_uri = null;
	private $client;
	private $request;
	private $response;
	
	public function __construct(){
		$this->api_uri = "https://verifiablyrandom.app";
		$this->request = new \stdClass();
		$this->request->headers = ['User-Agent','verifiablyrandom.app/1.0.0','Accept'=>'application/json','Content-Type'=>'application/json','Authorization'=>'Bearer ' . $this->api_key];
		$this->request->query = [];
		$this->refreshClient();
	}
	
	public function model($query=array()){
		$this->request->query = $query;
		if($this->checkRequest($this->request->query['request'])){
			$this->response = $this->client->request('GET', '/v1/api');
		} else {
			throwerror();
		}
	}
	
	
	public function response(){
		return $this->response;
	}
	
	public function apiKey($key=false){
		if($key){
			$this->api_key = $key;
			$this->refreshRequestHeaderAuthorization();
		} else {
			return $this->api_key;
		}
	}
	
	public function apiUri($uri=false){
		if($uri){
			$this->api_uri = $uri;
			$this->refreshClient();
		} else {
			return $this->api_uri;
		}
	}
	
	public function refreshClient(){
		$this->client = new \GuzzleHttp\Client(['base_uri' => $this->api_uri,  'headers' => $this->request->headers]);
	}
	
	public function refreshRequestHeaderAuthorization(){
		$this->request->headers['Authorization'] = 'Bearer ' . $this->api_key;
		$this->refreshClient();
	}
	
	public function checkRequest($Request){
		$valid = true;
		
		if(gettype($Request)=='array'){
			$RequestSize = count($Request);
			
			if(!$this->runRequestValidation($Request, 10)){
				$valid=false;
			}
		} else {
			$valid=false;
		}
		
		return $valid;
	}
	
	private function runRequestValidation(&$array, int $depth=0, int $max_depth=100){
		
		// Got 99 Problems but call stack smashing limits ain't 1 de cead.
		if($depth > $max_depth || $depth >= 99){return -1;}
		
		if(array_key_exists('key', $array)){
		if(array_key_exists('models')){
			return runRequestValidation($array['model'], $depth+=1);
		} else {
			if(in_array($array['key'], $validObjects)){
				if(array_key_exists('options', $array)){
					foreach($array['options'] as $key => $value){
						if(!Requests::validate_option($key, $value)){
							return false;
						}
					}
				} else {
					return -4;
				}
			} else {
				return -3;
			}
		}
		} else {
			return -2;
		}
	}
	
	private function throwerror($error=false){
		if(!$error){$error="A non-std error occured.";}
		print_r($error);
		die();
	}
}

?>
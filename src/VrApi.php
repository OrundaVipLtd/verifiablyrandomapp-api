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
	private $error;
	
	public function __construct(){
		$this->api_uri = "https://verifiablyrandom.app";
		$this->request = new \stdClass();
		$this->request->headers = ['User-Agent'=>'verifiablyrandom.app/1.0.0','Accept'=>'application/json','Authorization'=>'Bearer ' . $this->api_key];
		$this->request->query = [];
		$this->refreshClient();
	}
	
	public function model($query=array()){
		$this->request->query = $query;
		if($this->checkRequest($this->request->query['request'])){
			$this->response = $this->client->request('POST', '/v1/api', ['json' => $this->request->query]);
			
		} else {
			$this->throwerror();
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
			
			foreach($Request as $model_item){
				$valid_request_error = $this->runRequestValidation($mode_item, 10);
				if($valid_request_error<0){
					$valid=false;
					break;
				}
			}
		} else {
			$valid=false;
		}
		
		return $valid;
	}
	
	private function runRequestValidation(&$array, int $depth=0, int $max_depth=100){
		print_r("runRequestValidation");
		// Got 99 Problems but call stack smashing limits ain't 1 de cead.
		if($depth > $max_depth || $depth >= 99){return -1;}
		
		if(array_key_exists('key', $array)){
			print_r("array_key_exists('key', \'\$array\'\)");
		if(array_key_exists('models')){
			$valid = true;
			if(gettype($array['model'])=='array'){
				foreach($array['model'] as $model_item){
					$valid_request_error = runRequestValidation($model_item, $depth+=1);
					if($valid_request_error<0){
						$valid=false;
						break;
					}
				}
			} else {
				$valid = false;
			}
			return $valid;
		} else {
			print_r("Requests::ifObExists");
			if(Requests::ifObExists($array['key'])){
				if(array_key_exists('options', $array)){
					foreach($array['options'] as $key => $value){
						if(!Requests::validate_option($key, $value)){
							$this->error = array('code'=>-5, 'msg'=>'Invalid option ['.$key.'=>'.$value.']');
							return -5;
						} else {
							return 0;
						}
					}
				} else {
					$this->error = array('code'=>-4, 'msg'=>'options key does not exists @'.$depth);
					return -4;
				}
			} else {
				$this->error = array('code'=>-3, 'msg'=>'Key ['.$array["key"].'] is invalid.');
				return -3;
			}
		}
		} else {
			$this->error = array('code'=>-2, 'msg'=>'key [key] does not exist.');
			return -2;
		}
	}
	
	private function throwerror(){
		if(!$this->error){$this->error=array('code'=>-99, 'msg'=>"A non-std error occured.");}
		print_r($this->error['msg']);
		print_r($this->error['code']);
		die();
	}
}

?>
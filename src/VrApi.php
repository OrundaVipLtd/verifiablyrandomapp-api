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
				$valid_request_error = $this->runRequestValidation($model_item, 10);
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
		// Got 99 Problems but call stack smashing limits ain't 1 de cead.
		if($depth > $max_depth || $depth >= 99){return -1;}
		
		$Requests = new Requests();
		if(array_key_exists('key', $array)){
		if(array_key_exists('models', $array)){
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
			if($Requests->ifObExists($array['key'])){
				$key_pair = explode(":",$array['key']);
				$key_model = $key_pair[0];
				$key_super_model = $key_pair[1];
				if(array_key_exists('data', $array)){
					foreach($array['data'] as $option_key => $value){
						if(!$Requests->validate_option($key_model, $key_super_model, $option_key, $value)){
							$this->error = array('code'=>-5, 'msg'=>'Invalid option ['.$option_key.'=>'.$value.']');
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
	
	public function test(){
		$Requests = new Requests();
		
		$model_types = get_object_vars($Requests->model);
		
		$model = [];
		
		
		$model[] = ["key"=>"number:natural","data"=>["mode"=>"any"]];
		$model[] = ["key"=>"number:natural","data"=>["mode"=>"custom","custom"=>[13,100,25,19]]];
		$model[] = ["key"=>"number:natural","data"=>["mode"=>"range","range"=>["min"=>0,"max"=>"Infinity"]]];
		
		$model[] = ["key"=>"number:odd","data"=>["mode"=>"any"]];
		$model[] = ["key"=>"number:odd","data"=>["mode"=>"custom","custom"=>[13,101,25,19]]];
		$model[] = ["key"=>"number:odd","data"=>["mode"=>"range","range"=>["min"=>1,"max"=>"Infinity"]]];
		
		$model[] = ["key"=>"number:even","data"=>["mode"=>"any"]];
		$model[] = ["key"=>"number:even","data"=>["mode"=>"custom","custom"=>[12,100,24,18]]];
		$model[] = ["key"=>"number:even","data"=>["mode"=>"range","range"=>["min"=>0,"max"=>"Infinity"]]];
		
		$model[] = ["key"=>"number:irrational","data"=>["mode"=>"any"]];
		$model[] = ["key"=>"number:irrational","data"=>["mode"=>"custom","custom"=>[1.5,2.9,7.3]]];
		$model[] = ["key"=>"number:irrational","data"=>["mode"=>"range","range"=>["min"=>0,"max"=>"Infinity"]]];
		
		$model[] = ["key"=>"number:prime","data"=>["mode"=>"any"]];
		$model[] = ["key"=>"number:prime","data"=>["mode"=>"custom","custom"=>[11,13,27,19]]];
		$model[] = ["key"=>"number:prime","data"=>["mode"=>"range","range"=>["min"=>1,"max"=>"Infinity"]]];
		
		
		
		$model[] = ["key"=>"string:binary","data"=>["mode"=>"any"]];
		$model[] = ["key"=>"string:binary","data"=>["mode"=>"any","custom"=>["101010","111000","111110"]]];
		$model[] = ["key"=>"string:binary","data"=>["mode"=>"any","range"=>["min"=>0,"max"=>"Infinity"]]];
		$model[] = ["key"=>"string:binary","data"=>["mode"=>"any","size"=>10]];
		
		$model[] = ["key"=>"string:binary","data"=>["mode"=>"any","custom"=>["101010","111000","111110"],"range"=>["min"=>0,"max"=>"Infinity"]]];
		$model[] = ["key"=>"string:binary","data"=>["mode"=>"any","custom"=>["101010","111000","111110"],"size"=>10]];
		$model[] = ["key"=>"string:binary","data"=>["mode"=>"any","range"=>["min"=>0,"max"=>"Infinity"], "size"=>10]];
		
		$model[] = ["key"=>"string:binary","data"=>["mode"=>"any","custom"=>["101010","111000","111110"],"range"=>["min"=>0,"max"=>"Infinity"],"size"=>10]];
		
		
		
		$model[] = ["key"=>"string:byte","data"=>["mode"=>"any"]];
		$model[] = ["key"=>"string:byte","data"=>["mode"=>"any","custom"=>["10101000","11100011","11111001"]]];
		$model[] = ["key"=>"string:byte","data"=>["mode"=>"any","range"=>["min"=>0,"max"=>"Infinity"]]];
		$model[] = ["key"=>"string:byte","data"=>["mode"=>"any","size"=>10]];
		
		$model[] = ["key"=>"string:byte","data"=>["mode"=>"any","custom"=>["10101000","11100011","11111001"],"range"=>["min"=>0,"max"=>"Infinity"]]];
		$model[] = ["key"=>"string:byte","data"=>["mode"=>"any","custom"=>["10101000","11100011","11111001"],"size"=>10]];
		$model[] = ["key"=>"string:byte","data"=>["mode"=>"any","range"=>["min"=>0,"max"=>"Infinity"], "size"=>10]];
		
		$model[] = ["key"=>"string:byte","data"=>["mode"=>"any","custom"=>["10101000","11100011","11111001"],"range"=>["min"=>0,"max"=>"Infinity"],"size"=>10]];
		
		
		
		$model[] = ["key"=>"string:hexadecimal","data"=>["mode"=>"any"]];
		$model[] = ["key"=>"string:hexadecimal","data"=>["mode"=>"any","custom"=>["55AA","CAFEB00B","FAB100"]]];
		$model[] = ["key"=>"string:hexadecimal","data"=>["mode"=>"any","range"=>["min"=>0,"max"=>"Infinity"]]];
		$model[] = ["key"=>"string:hexadecimal","data"=>["mode"=>"any","size"=>10]];
		
		$model[] = ["key"=>"string:hexadecimal","data"=>["mode"=>"any","custom"=>["55AA","CAFEB00B","FAB100"],"range"=>["min"=>0,"max"=>"Infinity"]]];
		$model[] = ["key"=>"string:hexadecimal","data"=>["mode"=>"any","custom"=>["55AA","CAFEB00B","FAB100"],"size"=>10]];
		$model[] = ["key"=>"string:hexadecimal","data"=>["mode"=>"any","range"=>["min"=>0,"max"=>"Infinity"], "size"=>10]];
		
		$model[] = ["key"=>"string:hexadecimal","data"=>["mode"=>"any","custom"=>["55AA","CAFEB00B","FAB100"],"range"=>["min"=>0,"max"=>"Infinity"],"size"=>10]];
		
		
		
		
		$model[] = ["key"=>"string:email","data"=>["name"=>"any","domain"=>"any","ext"=>"any"]];
		$model[] = ["key"=>"string:email","data"=>["name"=>"any","domain"=>"any","ext"=>"any","custom"=>["name"=>["firstname.lastname","person.one","person.two"]]]];
		$model[] = ["key"=>"string:email","data"=>["name"=>"any","domain"=>"any","ext"=>"any","custom"=>["domain"=>["new-domain","second-domain","third-domain"]]]];
		$model[] = ["key"=>"string:email","data"=>["name"=>"any","domain"=>"any","ext"=>"any","custom"=>["ext"=>[".shop",".domain",".ltd"]]]];
		$model[] = ["key"=>"string:email","data"=>["name"=>"any","domain"=>"any","ext"=>"any","custom"=>["name"=>["firstname.lastname","person.one","person.two"],"domain"=>["new-domain","second-domain","third-domain"]]]];
		$model[] = ["key"=>"string:email","data"=>["name"=>"any","domain"=>"any","ext"=>"any","custom"=>["name"=>["firstname.lastname","person.one","person.two"],"ext"=>[".shop",".domain",".ltd"]]]];
		$model[] = ["key"=>"string:email","data"=>["name"=>"any","domain"=>"any","ext"=>"any","custom"=>["domain"=>["new-domain","second-domain","third-domain"],"ext"=>[".shop",".domain",".ltd"]]]];
		$model[] = ["key"=>"string:email","data"=>["name"=>"any","domain"=>"any","ext"=>"any","custom"=>["name"=>["firstname.lastname","person.one","person.two"],"domain"=>["new-domain","second-domain","third-domain"],"ext"=>[".shop",".domain",".ltd"]]]];
		
		$model[] = ["key"=>"string:email","data"=>["name"=>"f.l.f","domain"=>"any","ext"=>"any"]];
		$model[] = ["key"=>"string:email","data"=>["name"=>"f.l.m","domain"=>"any","ext"=>"any"]];
		$model[] = ["key"=>"string:email","data"=>["name"=>"custom","domain"=>"any","ext"=>"any","custom"=>["name"=>["firstname.lastname","person.one","person.two"]]]];
		$model[] = ["key"=>"string:email","data"=>["name"=>"any","domain"=>"custom","ext"=>"any","custom"=>["domain"=>["new-domain","second-domain","third-domain"]]]];
		$model[] = ["key"=>"string:email","data"=>["name"=>"any","domain"=>"any","ext"=>["co.uk","ie","com","uk"]]];
		
		
		
		$model[] = ["key"=>"string:domain","data"=>["protocol"=>"any","name"=>"any","ext"=>"any"]];
		$model[] = ["key"=>"string:domain","data"=>["protocol"=>"any","name"=>"custom","ext"=>"any","custom"=>["domain.com","domain.co.uk","domain.ie"]]];
		
		
		
		$model[] = ["key"=>"string:ip","data"=>["version"=>"any","mode"=>"any"]];
		$model[] = ["key"=>"string:ip","data"=>["version"=>"any","mode"=>"range","range"=>["v4"=>["min"=>"0.0.0.0","max"=>"255.255.255.255"],"v6"=>["min"=>"0000:0000:0000:0000","max"=>"0000:0000:0000:0000"]]]];
		$model[] = ["key"=>"string:ip","data"=>["version"=>"v4","mode"=>"range","range"=>["v4"=>["min"=>"0.0.0.0","max"=>"255.255.255.255"],"v6"=>["min"=>"0000:0000:0000:0000","max"=>"0000:0000:0000:0000"]]]];
		$model[] = ["key"=>"string:ip","data"=>["version"=>"v6","mode"=>"range","range"=>["v4"=>["min"=>"0.0.0.0","max"=>"255.255.255.255"],"v6"=>["min"=>"0000:0000:0000:0000","max"=>"0000:0000:0000:0000"]]]];
		
		
		$responses = [];
		foreach($model as $request){
			$request['size'] = 10;
			$modeled_request = array("request"=>array($request), "save"=>true);
			$this->model($modeled_request);
			$responses[] = $api->response()->getBody()->getContents();
		}
		
		
		
		
		
		
	}
}

?>
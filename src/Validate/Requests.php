<?php
 
namespace VerifiablyRandom\Api\Validate;

/*

This entire controller class is a fucking nightmare of logical switch / if statements,
is there really any better way to organise this thing? Or am i just getting tired ag 19:31 o lunas oiche aris?
Ta ano e fuck. is feider me dean e amarach, tog le briste. le do thoil, anois :).

*/

class Requests
{	
	private $validObjects;
	private $validOp;
	private $valid_data;
	
	public function __construct(){
		$this->validObjects = ['natural','even','odd','irrational','prime','binary', 'hexadecimal','decimal','byte','email','domain','ip'];
		
		$this->valid_data = new \stdClass();
		$this->ip = new \stdClass();
		$this->ip->version_string_types = array('any','v4','v6');
		$this->ip->model_string_types = array('any','range','customer');
	}
	
	public function ifObExists($obName){
		return in_array($obName, $this->validObjects);
	}
	
	public function ifOpExists($opName){
		return array_key_exists($opName, $this->validOp);
	}
	
	public function ifOpRangeable($opName){
		if(array_key_exists($opName, $this->validOp)){
			return $this->validOp[$opName]['validate']['rangeable'];
		} else {
			return false;
		}
	}
	
	public function opValidate($opName, $ops){
		$valid = true;
		if($this->ifOpExists($opName)){
			$opType = gettype($ops);
			foreach($this->validOp[$opName]['validate']['type'] as $opValidateType){
				if($opType=='array'||$opType=='object'){
					foreach($ops as $op){
					    if(!$this->validate_option($opValidateType, $op)){
							$valid=false;
							break;
						}
					}
					if(!$valid){break;}
				} else {
					if(!$this->validate_option($opValidateType, $ops)){
						$valid=false;
						break;
					}
				}
			}
		} else {
			return false;
		}
		
		return $valid;
	}
	
	
	
	public function validate_option($type, $options){
		$valid_opt = false;
		switch($type){
			case 'natural':
				return is_integer($options);
			break;
			case 'natural_range':
				$valid = false;
				$min=0;
				$max=PHP_INT_MAX;
				if(array_key_exists('min', $options) && array_key_exists('max', $options)){
					if($options['min']>=$min && $options['max']<=$max && $options['max']>$options['min']){
						$valid=true;
					}
				}
				return $valid;
			break;
			case 'natural_custom':
				$valid=false;
				if(gettype($options)=='array'){
					foreach($options as $option){
						if(is_integer($option) && $option>=$min && $option<=$max){
							$valid=true;
						} else {
							$valid=false;
							break;
						}
					}
				}
				return $valid;
			break;
			case 'even':
				$valid = false;
				if(is_integer($options)){
					if($options%2==0){
						$valid=true;
					}
				}
				return $valid;
			break;
			case 'even_range':
				$min=0;
				$max=PHP_INT_MAX;
				if(gettype($options)=='array'){
					if(array_key_exists('min', $options) && array_key_exists('max', $options)){
						if(is_integer($options['max']) && is_integer($options['min'])){
						if($options['max']%2==0 && $options['min']%2==0 && $options['min']>=$min && $options['max']<=$max && $options['max']>$options['min']){
						}
						}
					}
				}
				return $valid;
			break;
			case 'even_custom':
				$valid = false;
				if(gettype($options)=='array'){
					foreach($options as $option){
						if(is_integer($option)){
							$valid=true;
						} else {
							$valid=false;
							break;
						}
					}
				}
				return $valid;
			break;
			case 'odd':
				$valid = false;
				if(is_integer($options)){
					$valid=true;
				}
				return $valid;
			break;
			case 'odd_range':
				$valid = false;
				if(gettype($options)){
					foreach($options as $option){
						if(is_integer($option)){
							if($option%2!=0){
								$valid=true;
							} else {
								$valid=false;
								break;
							}
						}
					}
				}
				return $valid;
			break;
			case 'odd_custom':
				$valid = false;
				if(gettype($options)=='array'){
					foreach($options as $option){
						if(is_integer($option)){
							if($option%2!=0){
								$valid=true;
							} else {
								$valid=false;
								break;
							}
						}
					}
				}
				return $valid;
			break;
			case 'irrational':
				$valid = false;
				if(is_float($options)){
					$valid=true;
				}
				return $valid;
			break;
			case 'irrational_range':
				$valid=false;
				$min=0;
				$min=PHP_FLOAT_MAX;
				if(gettype($options)=='array'){
					if(array_key_exists('min', $options) && array_key_exists('max', $options)){
						if($options['min']>=$min && $options['max']<=$max && $options['max']>$options['min']){
							$valid=true;
						}
					}
				}
				return $valid;
			break;
			case 'irrational_custom':
				$valid = false;
				if(gettype($options)=='array'){
					foreach($options as $option){
						if(is_float($option)){
							$valid=true;
						} else {
							$valid=false;
							break;
						}
					}
				}
				return $valid;
			break;
			case 'prime':
				$valid = false;
				if(gettype($options)){
					if(gmp_prob_prime($options)!=0){
						$valid=true;
					}
				}
				return $valid;
			break;
			case 'prime_range':
				$valid=false;
				$min=0;
				$max=PHP_INT_MAX;
				if(gettype($options)=='array'){
					if(array_key_exists('min', $options) && array_key_exists('max', $options)){
						if($options['min']>=$min && $options['max']<=$max && $options['max']>$options['min']){
							$valid=true;
						}
					}
				}
				return $valid;
			break;
			case 'prime_custom':
				$valid=false;
				if(gettype($options)=='array'){
					foreach($options as $options){
						if(is_integer($option)){
							if(gmp_prob_prime($option)!=0){
								$valid=true;
							} else {
								$valid=false;
								break;
							}
						}
					}
				}
				return $valid;
			break;
			case 'string':
				$valid=false;
				if(is_string($option)){
					$valid;
				}
				return $valid;
			break;
			case 'string_range':
				$valid=false;
				$min=1;
				$max=(1204*1024*1024*2);
				if(gettype($options)=='array'){
					if(array_key_exists('min', $options) && array_key_exists('max', $options)){
						if($options['min']>=$min && $options['max']<=$max && $options['max']>$options['min']){
							$valid=true;
						}
					}
				}
				return $valid;
			break;
			case 'string_custom':
				$valid=false;
				$maxstr=256;
				if(gettype($options)=='array'){
					foreach($options as $option){
						if(is_string($option)){
							if(!empty($option) && strlen($option)<$maxstr){
								$valid=true;
							} else {
								$valid=false;
								break;
							}
						}
					}
				}
				return $valid;
			break;
			case 'email':
				$valid=false;
				if(filter_var($option, FILTER_VALIDATE_EMAIL)){
					$valid=true;
				}
				return $valid;
			break;
			case 'email_name':
				$valid=false;
				$maxtsr=5;
				if(is_integer($option)){
					if($option>0 && $option<=$maxstr){
						$valid=true;
					}
				}
				return $valid;
			break;
			case 'email_name_custom':
				$valid=false;
				
				/*
				 * RFC 3696 Erratum 1003
				 * In addition to restrictions on syntax, there is a length limit on<br>
				 * email addresses.  That limit is a maximum of 64 characters (octets)
				 * in the "local part" (before the "@") and a maximum of 255 characters
				 * (octets) in the domain part (after the "@") for a total length of 320
				 * characters.
				 */
				$local_limit = 64;
				/*
				 * Fake Domain for Local Prefix Character validation with filter_var
				 */
				$fake_domain="@domain.com";
				if(gettype($options)=='array'){
					foreach($options as $option){
						if(is_string($option)){
							if(strlen($option)<=$local_limit){
								if(filter_var($option+"@domain.com", FILTER_VALIDATE_EMAIL)){
									$valid=true;
								} else {
									$valid=false;
									break;
								}
							} else {
								$valid=false;
								break;
							}
						} else {
							$valid=false;
							break;
						}
					}
				}
				return $valid;
			break;
			case 'binary':
				$valid=true;
				$maxtsr=2048;
				if(is_string($options)){
					if(strlen($options)<=$maxtsr){
					for($n = 0; $n < strlen($options); $n++){
						$c=$options[$n];
						if($c!="1"||$c!="0"){
							$valid=false;
							break;
						}
					}
					} else {$valid=false;}
				} else {$valid=false;}
				return $valid;
			break;
			case 'binary_custom':
				$valid=false;
				$terminate=false;
				$maxstr=128;
				if(gettype($options)=='array'){
					foreach($options as $option){
						if(is_string($options)){
							if(strlen($option)<$maxtsr){
								for($n=0; $n < strlen($option); $n++){
									$c=$options[$n];
									if($c=="1"||$c=="0"){
										$valid=true;
									} else {
										$valid=false;
										$terminate=true;
										break;
									}
								}
								if($terminate){break;}
							} else {
								$valid=false;
								break;
							}
						} else {
							$valid=false;
							break;
						}
					}
				}
				return $valid;
			break;
			case 'domain':
				$valid=false;
				if(filter_var($option, FILTER_VALIDATE_DOMAIN)){
					$valid=true;
				}
				return $valid;
			break;
			case 'domain_name':
				$valid=false;
				$maxstr=5;
				if(is_integer($options)){
					if($options>=0 && $options<=$maxstr){
						$valid=true;
					}
				}
				return $valid;
			break;
			case 'domain_name_custom':
				$valid=false;
				
				/*
				 * Fake domain Extension for validating character-set with filter_var.
				 */
				$fake_domain_ext=".com";
				if(gettype($options)=='array'){
					foreach($options as $option){
						if(is_string($option)){
							if(filter_var($option.$fake_domain_ext, FILTER_VALIDATE_DOMAIN)){
								$valid=true;
							} else {
								$valid=false;
								break;
							}
						} else {
							$valid=false;
							break;
						}
					}
				}
				return $valid;
			break;
			case 'domain_ext':
				$valid=false;
				$maxtstr=5;
				if(is_integer($options)){
					if($options>=0 && $options<=$maxtsr){
						$valid=true;
					}
				}
				return $valid;
			break;
			case 'domain_ext_custom':
				$valid=false;
				if(gettype($options)=='array'){
					foreach($options as $option){
						if(is_string($option)){
							if(filter_var("i".$option, FILTER_VALIDATE_DOMAIN)){
								$valid=true;
							} else {
								$valid=false;
								break;
							}
						} else {
							$valid=false;
							break;
						}
					}
				}
				return $valid;
			break;
			case 'ipv4':
				$valid=false;
				if(is_string($options)){
					if(filter_var($options, FILTER_VALIDATE_IPV4)){
						$valid=true;
					}
				}
				return $valid;
			break;
			case 'ipv4_range':
				$valid=false;
				$min=ip2long("0.0.0.0");
				$max=ip2long("255.255.255.255");
				if(gettype($options)=='array'){
					if(array_key_exists('min', $options) && array_key_exists('max', $options)){
						if(filter_var($options['min'], FILTER_VALIDATE_IPV4)){
						if(filter_var($options['max'], FILTER_VALIDATE_IPV4)){
							$ipmin=ip2long($options['min']);
							$ipmax=ip2long($options['max']);
							if($ipmin>=$min && $ipmax<=$max && $ipmax>$ipmin){
								$valid=true;
							}
						}
						}
					}
				}
				return $valid;
			break;
			case 'ipv4_custom':
				$valid=false;
				if(gettype($options)=='array'){
					foreach($options as $options){
						if(is_string($option)){
							if(filter_var($option, FILTER_VALIDATE_IPV4)){
								$valid=true;
							} else {
								$valid=false;
								break;
							}
						} else {
							$valid=false;
							break;
						}
					}
				}
				return $valid;
			break;
			case 'ipv6':
				$valid=false;
				if(is_string($option)){
					if(filter_var($options, FILTER_VALIDATAE_IPV6)){
						$valid=true;
					}
				}
				return $valid;
			break;
			case 'ipv6_range':
				$valid=false;
				$min=gmp_import(inet_pton("0000:0000:0000:0000:0000:0000:0000:0000"));
				$max=gmp_import(inet_pton("ffff:ffff:ffff:ffff:ffff:ffff:ffff:ffff"));
				if(gettype($options)=='array'){
					if(array_key_exists('min', $options) && array_key_exists('max', $options)){
						if(filter_var($options['min'], FILTER_VALIDATE_IPV6)){	
							if(filter_var($options['min'], FILTER_VALIDATE_IPV6)){
							$ipmin=gmp_import(inet_pton($options['min']));
							$ipmax=gmp_import(inet_pton($options['max']));
							if($ipmin>=$min && $ipmax<=$max && $ipmax > $ipmin){
								$valid=true;
							}
						}
						}
					}
				}
				return $valid;
			break;
			case 'ipv6_custom':
				$valid=false;
				if(gettype($options)=='array'){
					foreach($options as $option){
						if(is_string($option)){
							if(filter_var($option, FILTER_VALIDATE_IPV6)){
								$valid=true;
							} else {
								$valid=false;
								break;
							}
						} else {
							$valid=false;
							break;
						}
					}
				}
				return $valid;
			break;
			case 'ip_version_string_type':
				$valid = false;
				if(gettype($options)=='string'){
					if(in_array($options, $this->valid_data->ip->version_string_types)){
						$valid=true;
					}
				}
				return $valid;
			break;
			case 'ip_model_string_type':
				$valid = false;
				if(gettype($options)=='string'){
					if(in_array($options, $this->valid_data->ip->model_string_types)){
						$valid=true;
					}
				}
				return $valid;
			break;
			default:
				return false;
			break;
		}
	}
}

?>
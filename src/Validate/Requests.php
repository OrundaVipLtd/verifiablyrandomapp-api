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
	private $validDataMethods;
	private $validOp;
	private $valid;
	private $model;
	
	public function __construct(){
		$this->validObjects = ['natural','even','odd','irrational','prime','binary', 'hexadecimal','decimal','byte','email','domain','ip'];
		
		$this->valid = new \stdClass();
		$this->valid->string = new \stdClass();
		$this->valid->string->binary = new \stdClass();
		$this->valid->string->binary->validate = function($string=null){
			$valid=false;
			if($string){
				
			}
			return $valid;
		};
		$this->valid->string->hexadecimal = new \stdClass();
		$this->valid->string->hexadecimal->validate = function($string=null){
			$valid=false;
			if($string){
				
			}
			return $valid;
		};
		$this->valid->string->decimal = new \stdClass();
		$this->valid->string->decimal->validate = function($string=null){
			$valid=false;
			if($string){
				
			}
			return $valid;
		};
		$this->valid->string->byte = new \stdClass();
		$this->valid->string->byte->validate = function($string=null){
			$valid=false;
			if($string){
				
			}
			return $valid;
		};
		$this->valid->string->email = new \stdClass();
		$this->valid->string->email->validate = function($string=null){
			$valid=false;
			if($string){
				
			}
			return $valid;
		};
		$this->valid->string->email->name = new \stdClass();
		$this->valid->string->email->name->validate = function($string=null){
			$valid=false;
			if($string){
				
			}
			return $valid;
		};
		$this->valid->string->email->domain  = new \stdClass();
		$this->valid->string->email->domain->validate = function($string=null){
			$valid=false;
			if($string){
				
			}
			return $valid;
		};
		$this->valid->string->email->ext = new \stdClass();
		$this->valid->string->email->ext->validate = function($string=null){
			$valid=false;
			if($string){
				
			}
			return $valid;
		};
		$this->valid->string->domain = new \stdClass();
		$this->valid->string->domain->validate = function($string=null){
			$valid=false;
			if($string){
				
			}
			return $valid;
		};
		$this->valid->string->domain->protocol = new \stdClass();
		$this->valid->string->domain->protocol->validate = function($string=null){
			$valid=false;
			$protocols = ['http','https','ftp','sftp','ssh'];
			if($string){
				if(in_array($string, $protocols)){
					$valid=true;
				}
			}
			return $valid;
		};
		$this->valid->string->domain->name = new \stdClass();
		$this->valid->string->domain->name->validate = function($string=null){
			$valid=false;
			if($string){
				
			}
			return $valid;
		};
		$this->valid->string->domain->ext = new \stdClass();
		$this->valid->string->domain->ext->validate = function($string=null){
			$valid=false;
			if($string){
				
			}
			return $valid;
		};
		$this->valid->string->ip = new \stdClass();
		$this->valid->string->ip->validate = function($string=null){
			$valid=false;
			if($string){
				if(filter_var($string, FILTER_VALIDATE_IPV4) || filter_var($string, FILTER_VALIDATE_IPV6)){
					$valid=true;
				}
			}
			return $valid;
		};
		$this->valid->string->ip->v4 = new \stdClass();
		$this->valid->string->ip->v4->validate = function($string=null){
			$valid=false;
			if($string){
				if(filter_var($string, FILTER_VALIDATE_IPV4)){
					$valid=true;
				}
			}
			return $valid;
		};
		$this->valid->string->ip->v6 = new \stdClass();
		$this->valid->string->ip->v6->validate = function($string=null){
			$valid=false;
			if($string){
				if(filter_var($number, FILTER_VALIDATE_IPV6)){
					$valid=true;
				}
			}
			return $valid;
		};
		$this->valid->number = new \stdClass();
		$this->valid->number->natural = new \stdClass();
		$this->valid->number->natural->validate = function($number=null){
			$valid=false;
			if($number){
				
			}
			return $valid;
		};
		$this->valid->number->even = new \stdClass();
		$this->valid->number->even->validate = function($number=null){
			$valid=false;
			if($number){
				
			}
			return $valid;
		};
		$this->valid->number->odd = new \stdClass();
		$this->valid->number->odd->validate  = function($number=null){
			$valid=false;
			if($number){
				
			}
			return $valid;
		};
		$this->valid->number->irrational = new \stdClass();
		$this->valid->number->irrational->validate = function($number=null){
			$valid=false;
			if($number){
				
			}
			return $valid;
		};
		$this->valid->number->prime = new \stdClass();
		$this->valid->number->prime->validate = function($number=null){
			$valid=false;
			if($number){
				
			}
			return $valid;
		};
		
		$this->valid->array = new \stdClass();
		$this->valid->array->validate = function($array=null){
			$valid = false;
			if($array){
				
			}
			return $valid;
		};
		$this->valid->array->string = new \stdClass();
		$this->valid->array->string->binary = $this->valid->string->binary;
		$this->valid->array->string->hexadecimal = $this->valid->string->hexadecimal;
		$this->valid->array->string->decimal = $this->valid->string->decimal;
		$this->valid->array->string->byte = $this->valid->string->byte;
		$this->valid->array->string->email = $this->valid->string->email;
		$this->valid->array->string->domain = $this->valid->string->ip;
		$this->valid->array->string->ip = $this->valid->string->ip;
		
		$this->valid->array->number = new \stdClass();
		$this->valid->array->number->natural = $this->valid->number->natural;
		$this->valid->array->number->even = $this->valid->number->even;
		$this->valid->array->number->odd = $this->valid->number->odd;
		$this->valid->array->number->irrational = $this->valid->number->irrational;
		$this->valid->array->number->prime = $this->valid->number->prime;
		
		$this->valid->array->custom = $this->valid->array;
		
		$this->valid->object = new \stdClass();
		$this->valid->object->validate = function($object=null){
			$valid = false;
			if($object){
				
			}
			return $valid;
		};
		$this->valid->object->string = new \stdClass();
		$this->valid->object->string->binary = $this->valid->string->binary;
		$this->valid->object->string->hexadecimal = $this->valid->string->hexadecimal;
		$this->valid->object->string->decimal = $this->valid->string->decimal;
		$this->valid->object->string->byte = $this->valid->string->byte;
		$this->valid->object->string->email = $this->valid->string->email;
		$this->valid->object->string->domain = $this->valid->string->ip;
		$this->valid->object->string->ip = $this->valid->string->ip;
		
		$this->valid->object->number = new \stdClass();
		$this->valid->object->number->natural = $this->valid->number->natural;
		$this->valid->object->number->even = $this->valid->number->even;
		$this->valid->object->number->odd = $this->valid->number->odd;
		$this->valid->object->number->irrational = $this->valid->number->irrational;
		$this->valid->object->number->prime = $this->valid->number->prime;
		
		$this->valid->object->custom = $this->valid->object;
		
		
		
		$this->model = new \stdClass();
		$this->model->array = new \stdClass();
		$this->model->object = new \stdClass();
		$this->model->number = new \stdClass();
		$this->model->string = new \stdClass();
		$this->model->mediia = new \stdClass();
		
		$this->model->array->name = "Array";
		$this->model->array->allow_sub_model = true;
		$this->model->array->restricted_models = [];
		$this->model->array->is_super_model = false;
		
		$this->model->object->name = "Object";
		$this->model->object->allow_sub_model = true;
		$this->model->object->restricted_models = [];
		$this->model->object->is_super_model = false;
		
		$this->model->number->name = "Number";
		$this->model->number->allow_sub_model = false;
		$this->model->number->is_super_model = true;
		$this->model->number->super_models = new \stdClass();
		
		$this->model->number->super_models->natural = new \stdClass();
		$this->model->number->super_models->natural->name = "Natural";
		$this->model->number->super_models->natural->is_rangeable = true;
		$this->model->number->super_models->natural->min = 0;
		$this->model->number->super_models->natural->max = "Infinity";
		$this->model->number->super_models->natural->is_super_model = false;
		$this->model->number->super_models->natural->data = new \stdClass();
		$this->model->number->super_models->natural->data->mode = new \stdClass();
		$this->model->number->super_models->natural->data->mode->valid_type = 'array.string';
		$this->model->number->super_models->natural->data->mode->valid_array = ['any', 'custom', 'range'];
		
		$this->model->number->super_models->odd = new \stdClass();
		$this->model->number->super_models->odd->name = "Odd";
		$this->model->number->super_models->odd->is_rangeable = true;
		$this->model->number->super_models->odd->min = 0;
		$this->model->number->super_models->odd->max = "Infinity";
		$this->model->number->super_models->odd->is_super_model = false;
		$this->model->number->super_models->odd->data = new \stdClass();
		$this->model->number->super_models->odd->data->mode = new \stdClass();
		$this->model->number->super_models->odd->data->mode->valid_type = 'array.string';
		$this->model->number->super_models->odd->data->mode->valid_array = ['any', 'custom', 'range'];
		
		$this->model->number->super_models->even = new \stdClass();
		$this->model->number->super_models->even->name = "Even";
		$this->model->number->super_models->even->is_rangeable = true;
		$this->model->number->super_models->even->min = 0;
		$this->model->number->super_models->even->max = "Infinity";
		$this->model->number->super_models->even->is_super_model = false;
		$this->model->number->super_models->even->data = new \stdClass();
		$this->model->number->super_models->even->data->mode = new \stdClass();
		$this->model->number->super_models->even->data->mode->valid_type = 'array.string';
		$this->model->number->super_models->even->data->mode->valid_array = ['any', 'custom', 'range'];
		
		$this->model->number->super_models->irrational = new \stdClass();
		$this->model->number->super_models->irrational->name = "Irrational";
		$this->model->number->super_models->irrational->is_rangeable = true;
		$this->model->number->super_models->irrational->min = 0;
		$this->model->number->super_models->irrational->max = "Infinity";
		$this->model->number->super_models->irrational->is_super_model = false;
		$this->model->number->super_models->irrational->data = new \stdClass();
		$this->model->number->super_models->irrational->data->mode = new \stdClass();
		$this->model->number->super_models->irrational->data->mode->valid_type = 'array.string';
		$this->model->number->super_models->irrational->data->mode->valid_array = ['any', 'custom', 'range'];
		
		$this->model->number->super_models->prime = new \stdClass();
		$this->model->number->super_models->prime->name = "Prime";
		$this->model->number->super_models->prime->is_rangeable = true;
		$this->model->number->super_models->prime->min = 1;
		$this->model->number->super_models->prime->max = "Infinity";
		$this->model->number->super_models->prime->is_super_model = false;
		$this->model->number->super_models->prime->data = new \stdClass();
		$this->model->number->super_models->prime->data->mode = new \stdClass();
		$this->model->number->super_models->prime->data->mode->valid_type = 'array.string';
		$this->model->number->super_models->prime->data->mode->valid_array = ['any', 'custom', 'range'];
		
		$this->model->string->name = "String";
		$this->model->string->allow_sub_model = false;
		$this->model->string->restricted_models = [];
		$this->model->string->is_super_model = true;
		$this->model->string->super_models = new \stdClass();
		
		$this->model->string->super_models->binary = new \stdClass();
		$this->model->string->super_models->binary->name = "Binary";
		$this->model->string->super_models->binary->is_rangeable = true;
		$this->model->string->super_models->binary->is_sizeable = true;
		$this->model->string->super_models->binary->min = 0;
		$this->model->string->super_models->binary->max = "Infinity";
		$this->model->string->super_models->binary->min_size = 0;
		$this->model->string->super_models->binary->max_size = "Infinity";
		$this->model->string->super_models->binary->is_super_model = false;
		$this->model->string->super_models->binary->data = new \stdClass();
		$this->model->string->super_models->binary->data->mode = new \stdClass();
		$this->model->string->super_models->binary->data->mode->valid_type = 'array.string';
		$this->model->string->super_models->binary->data->mode->valid_array = ['any', 'custom', 'range'];
		$this->model->string->super_models->binary->data->range = new \stdClass();
		$this->model->string->super_models->binary->data->range->valid_type = "number.natural";
		$this->model->string->super_models->binary->data->size = new \stdClass();
		$this->model->string->super_models->binary->data->size->valid_type = 'number.natural';
		$this->model->string->super_models->binary->data->custom = new \stdClass();
		$this->model->string->super_models->binary->data->custom->valid_type = 'array.custom.string.binary';
			
		$this->model->string->super_models->byte = new \stdClass();
		$this->model->string->super_models->byte->name = "Byte";
		$this->model->string->super_models->byte->is_rangeable = true;
		$this->model->string->super_models->byte->is_sizeable = true;
		$this->model->string->super_models->byte->min = 0;
		$this->model->string->super_models->byte->max = "Infinity";
		$this->model->string->super_models->byte->min_size = 0;
		$this->model->string->super_models->byte->max_size = "Infinity";
		$this->model->string->super_models->byte->is_super_model = false;
		$this->model->string->super_models->byte->data = new \stdClass();
		$this->model->string->super_models->byte->data->mode = new \stdClass();
		$this->model->string->super_models->byte->data->mode->valid_type = 'array.string';
		$this->model->string->super_models->byte->data->mode->valid_array = ['any', 'custom', 'range'];
		$this->model->string->super_models->byte->data->range = new \stdClass();
		$this->model->string->super_models->byte->data->range->valid_type = 'number.natural';
		$this->model->string->super_models->byte->data->size = new \stdClass();
		$this->model->string->super_models->byte->data->size->valid_type = 'number.natural';
		$this->model->string->super_models->byte->data->custom = new \stdClass();
		$this->model->string->super_models->byte->data->custom->valid_type = 'array.custom.string.byte';
		
		$this->model->string->super_models->hexadecimal = new \stdClass();
		$this->model->string->super_models->hexadecimal->name = "Hexadecimal";
		$this->model->string->super_models->hexadecimal->is_rangeable = true;
		$this->model->string->super_models->hexadecimal->is_sizeable = true;
		$this->model->string->super_models->hexadecimal->min = 0;
		$this->model->string->super_models->hexadecimal->max = "Infinity";
		$this->model->string->super_models->hexadecimal->min_size = 0;
		$this->model->string->super_models->hexadecimal->max_size = "Infiniity";
		$this->model->string->super_models->hexadecimal->is_super_model = false;
		$this->model->string->super_models->hexadecimal->data = new \stdClass();
		$this->model->string->super_models->hexadecimal->data->mode = new \stdClass();
		$this->model->string->super_models->hexadecimal->data->mode->valid_type = 'array.string';
		$this->model->string->super_models->hexadecimal->data->mode->valid_array = ['any', 'custom', 'range'];
		$this->model->string->super_models->hexadecimal->data->range = new \stdClass();
		$this->model->string->super_models->hexadecimal->data->range->valid_type = 'number.natural';
		$this->model->string->super_models->hexadecimal->data->size = new \stdClass();
		$this->model->string->super_models->hexadecimal->data->size->valid_type = 'number.natural';
		$this->model->string->super_models->hexadecimal->data->custom = new \stdClass();
		$this->model->string->super_models->hexadecimal->data->custom->valid_type = 'array.custom.string.hexadecimal';
		
		
		$this->model->string->super_models->email = new \stdClass();
		$this->model->string->super_models->email->name = "Email";
		$this->model->string->super_models->email->is_rangeable = true;
		$this->model->string->super_models->email->is_sizeable = true;
		$this->model->string->super_models->email->min = 0;
		$this->model->string->super_models->email->max = "Infinity";
		$this->model->string->super_models->email->min_size = 0;
		$this->model->string->super_models->email->max_size = "Infiniity";
		$this->model->string->super_models->email->is_super_model = false;
		$this->model->string->super_models->email->data = new \stdClass();
		$this->model->string->super_models->email->data->name = new \stdClass();
		$this->model->string->super_models->email->data->name->valid_type = 'array.string';
		$this->model->string->super_models->email->data->name->valid_array = ['any', 'firstname.lastname.female', 'firstname.lastname.male', 'custom'];
		$this->model->string->super_models->email->data->domain = new \stdClass();
		$this->model->string->super_models->email->data->domain->valid_type = 'array.string';
		$this->model->string->super_models->email->data->domain->valid_array = ['any', 'custom'];
		$this->model->string->super_models->email->data->ext = new \stdClass();
		$this->model->string->super_models->email->data->ext->valid_type = ['array.domain.ext'];
		$this->model->string->super_models->email->data->ext->valid_array = ['any','com','uk','co.uk','ie'];
		$this->model->string->super_models->email->data->custom_name = new \stdClass();
		$this->model->string->super_models->email->data->custom_name->valid_type = 'array.custom.string';
		$this->model->string->super_models->email->data->custom_name->valid_array = ['string'];
		$this->model->string->super_models->email->data->custom_domain = new \stdClass();
		$this->model->string->super_models->email->data->custom_domain->valid_type = 'array.custom.domain';
		$this->model->string->super_models->email->data->custom_domain->valid_array = ['name','name.ext'];
		
		
		$this->model->string->super_models->domain = new \stdClass();
		$this->model->string->super_models->domain->name = "Domain";
		$this->model->string->super_models->domain->is_rangeable = true;
		$this->model->string->super_models->domain->is_sizeable = true;
		$this->model->string->super_models->domain->min = 0;
		$this->model->string->super_models->domain->max = "Infinity";
		$this->model->string->super_models->domain->min_size = 0;
		$this->model->string->super_models->domain->max_size = "Infiniity";
		$this->model->string->super_models->domain->is_super_model = false;
		$this->model->string->super_models->domain->data = new \stdClass();
		$this->model->string->super_models->domain->data->protocol = new \stdClass();
		$this->model->string->super_models->domain->data->protocol->valid_type = 'array.domain.protocol';
		$this->model->string->super_models->domain->data->protocol->valid_array = ['none', 'http', 'https', 'ftp'];
		$this->model->string->super_models->domain->data->name = new \stdClass();
		$this->model->string->super_models->domain->data->name->valid_type = 'array.string';
		$this->model->string->super_models->domain->data->name->valid_array = ['any','custom'];
		$this->model->string->super_models->domain->data->ext = new \stdClass();
		$this->model->string->super_models->domain->data->ext->valid_type = 'array.domain.ext';
		$this->model->string->super_models->domain->data->ext->valid_array = ['any','com','uk','co.uk','ie'];
		$this->model->string->super_models->domain->data->custom = new \stdClass();
		$this->model->string->super_models->domain->data->custom->valid_type = 'array.custom.domain';
		$this->model->string->super_models->domain->data->custom->valid_array = ['protocol.name.ext','name.ext'];
			
		$this->model->string->super_models->ip = new \stdClass();
		$this->model->string->super_models->ip->name = "IP Address";
		$this->model->string->super_models->ip->is_rangeable = true;
		$this->model->string->super_models->ip->is_sizeable = false;
		$this->model->string->super_models->ip->min = 0;
		$this->model->string->super_models->ip->max = "Infinity";
		$this->model->string->super_models->ip->min_size = 0;
		$this->model->string->super_models->ip->max_size = "Infiniity";
		$this->model->string->super_models->ip->is_super_model = false;
		$this->model->string->super_models->ip->data = new \stdClass();
		$this->model->string->super_models->ip->data->version = new \stdClass();
		$this->model->string->super_models->ip->data->version->valid_type = 'array.string';
		$this->model->string->super_models->ip->data->version->valid_array = ['any', 'v4', 'v6'];
		$this->model->string->super_models->ip->data->mode = new \stdClass();
		$this->model->string->super_models->ip->data->mode->valid_type = 'array.string';
		$this->model->string->super_models->ip->data->mode->valid_array = ['any', 'customer', 'range'];
		$this->model->string->super_models->ip->data->range_v4 = new \stdClass();
		$this->model->string->super_models->ip->data->range_v4->valid_type = 'ip.v4';
		$this->model->string->super_models->ip->data->range_v6 = new \stdClass();
		$this->model->string->super_models->ip->data->range_v6->valid_type = 'ip.v6';
		$this->model->string->super_models->ip->data->custom = new \stdClass();
		$this->model->string->super_models->ip->data->custom->valid_type = 'array.custom.ip';
		$this->model->string->super_models->ip->data->custom->valid_array = ['v4', 'v6'];
		
		$this->model->string->super_models->date = new \stdClass();
		$this->model->string->super_models->date->name = "Date";
		$this->model->string->super_models->date->is_rangeable = true;
		$this->model->string->super_models->date->is_sizeable = false;
		$this->model->string->super_models->date->min = 0;
		$this->model->string->super_models->date->max = "Infinity";
		$this->model->string->super_models->date->min_size = 0;
		$this->model->string->super_models->date->max_size = "Infiniity";
		$this->model->string->super_models->date->is_super_model = false;
		$this->model->string->super_models->date->data = new \stdClass();
		$this->model->string->super_models->date->data->mode = new \stdClass();
		$this->model->string->super_models->date->data->mode->valid_type = 'array.string';
		$this->model->string->super_models->date->data->mode->valid_array = ['any', 'custom', 'range'];
		
		$this->model->string->super_models->datetime = new \stdClass();
		$this->model->string->super_models->datetime->name = "DateTime";
		$this->model->string->super_models->datetime->is_rangeable = true;
		$this->model->string->super_models->datetime->is_sizeable = false;
		$this->model->string->super_models->datetime->min = 0;
		$this->model->string->super_models->datetime->max = "Infinity";
		$this->model->string->super_models->datetime->min_size = 0;
		$this->model->string->super_models->datetime->max_size = "Infiniity";
		$this->model->string->super_models->datetime->is_super_model = false;
		$this->model->string->super_models->datetime->data = new \stdClass();
		$this->model->string->super_models->datetime->data->mode = new \stdClass();
		$this->model->string->super_models->datetime->data->mode->valid_type = 'array.string';
		$this->model->string->super_models->datetime->data->mode->valid_array = ['any', 'custom', 'range'];
		
		$this->model->string->super_models->time = new \stdClass();
		$this->model->string->super_models->time->name = "Time";
		$this->model->string->super_models->time->is_rangeable = true;
		$this->model->string->super_models->time->is_sizeable = false;
		$this->model->string->super_models->time->min = 0;
		$this->model->string->super_models->time->max = "Infinity";
		$this->model->string->super_models->time->min_size = 0;
		$this->model->string->super_models->time->max_size = "Infiniity";
		$this->model->string->super_models->time->is_super_model = false;
		$this->model->string->super_models->time->data = new \stdClass();
		$this->model->string->super_models->time->data->mode = new \stdClass();
		$this->model->string->super_models->time->data->mode->valid_type = 'array.string';
		$this->model->string->super_models->time->data->mode->valid_array = ['any', 'custom', 'range'];
		
		
		/* Add Media + Other Models */
	}
	
	public function ifObExists($obName){
		$exists=false;
		$key_pair = split(":", $obName);
		if(count($key_pair)==2){
			if(property_exists($this->model, $key_pair[0])){
				if(property_exists($this->model->$key_pair[0]->super_models, $key_pair[1])){
					$exists=true;
				}
			}
		}
		
		return $exists;
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
	
	
	
	public function validate_option($type, $subtype, $datatype, $options){
		$valid_opt = false;
		
		if(property_exists($this->model, $type)){
			if(property_exists($this->model->$type->super_models, $subtype)){
				if(property_exists($this->model->$type->super_models->$subtype->data, $datatype)){
					
					$valid_type = $this->model->$type->super_models->$subtype->data->$datatype->valid_type;
					$valid_type = split(".");
					$validity = $this->valid;
					$valid_type_exists = false;
					foreach($valid_type as $valid_type_id){
						if(property_exists($validity, $valid_type_id)){
							if(!$valid_type_exists){$valid_type_exists=true;}
							$validity = $validity->$valid_type_id;
						} else {
							if($valid_type_exists){$valid_type_exists=false;}
						}
					}
					
					if($valid_type_exists){
						if(property_exists($validity, "validate")){
							if($validity->validate($options)){
								$valid_opt = true;
							}
						}
					}
					
				}
			}
		}
		
		return $valid_opt;
	}
	
	
}

?>
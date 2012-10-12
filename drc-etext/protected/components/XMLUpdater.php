<?php
/**
 * XMLUpdater handels calls to XML services to retreive data and updatelocal datastores.
 */
class XMLUpdater extends CApplicationComponent
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
    /**
     * The configuration data for servers to call services on.
     * @var string
     */
    public $servers = array();
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $server
	 * @param unknown_type $service
	 * @param array $params parameters to be added to service request.
	 */
    public function update($server, $service, $params=array())
    {
    	// call service to get data
    	$xml = $this->getDataFromService($server, $service, $params);
    	// read config, if config not set do nothing
		if (isset($this->servers[$server]['services'][$service])){
    		$elementConfigs = $this->servers[$server]['services'][$service];
    		// parse XML and create objects
			foreach ($xml->children() as $elem) {
				// find config or set to null
				$config = null;
				if (isset($elementConfigs[$elem->getName()])){
					$config = $elementConfigs[$elem->getName()];
				}
				$this->updateElement($elem, $config);  // recursive
			}
		}
    }

	/**
	 * 
	 * Recursive...Enter description here ...
	 * @param unknown_type $xml
	 * @param unknown_type $config
	 * @param unknown_type $parent
	 */
    public function updateElement($elem, $config = null, $parent = null)
    {
		// check for mapper
		if ($config && isset($config['mapper'])){
			$model = new $config['mapper']($elem);
		} else { // use config or defaults
			if ($config && isset($config['model'])){
				$model = new $config['model'];
			} 
			else if (@class_exists($elem->getName())) {
				$className = $elem->getName();
				$model = new $className;
			} 
			//else if (class_exists(ucfirst($elem->getName()), false)) {
			//	$className = ucfirst($elem->getName());
			//	$model = new $className;
			//} 
			//else if (class_exists($this->from_camel_case($elem->getName()), false)) {
			//	$className = $this->from_camel_case($elem->getName());
			//	$model = new $className;
			//} 
			else {
				return;
			}
			// first assign any inherited parent attributes which might be inherited by default, will later be overridden if needed
			if ($parent){
				foreach ($parent->children() as $possibleAttribute) {
					// first look for configured parent attributes
					if ($config && isset($config['parentAttributes'][$possibleAttribute->getName()])){
						$model->setAttribute($config['parentAttributes'][$possibleAttribute->getName()],(string)$possibleAttribute); // safely returns false if attribute does not exist
					}
					// try name matching 
					else if (!$this->setModelAttribute($model,$possibleAttribute->getName(),(string)$possibleAttribute)){ 
						if (strtolower($possibleAttribute->getName()) == "id" ){  // special case to get parent id as default
							$this->setModelAttribute($model,$parent->getName()."Id",(string)$possibleAttribute);
						}
					}
				}
			}
			if ($config && isset($config['thisAsAttribute'])){
				$model->setAttribute($config['thisAsAttribute'],(string)$elem); // safely returns false if attribute does not exist
			}
			foreach ($elem->children() as $child) {
				if ($config && isset($config['attributes'][$child->getName()])){
					$model->setAttribute($config['attributes'][$child->getName()],(string)$child); // safely returns false if attribute does not exist
				}
				else if ($config && isset($config['children'][$child->getName()])){
					$this->updateElement($child, $config['children'][$child->getName()], $elem);
				}
				// if there is no config setting for this attribute see if the xml name matches a model attribute
				else if (!$this->setModelAttribute($model,$child->getName(),(string)$child)){ // safely returns false if attribute does not exist
					// try matching to a class 
					if (class_exists($child->getName(), false)) {
						$this->updateElement($child);
					} 
				}
			}
	    }
		// update or save model
		$modelPrior = $model->findByPk($model->getPrimaryKey());  
		//now check if the model is null
		if(!$modelPrior) {
			$model->save();			
		} else{
			// update
			$modelPrior->updateByPk($model->getPrimaryKey(), $model->getAttributes());			
		}
    }
    
    /**
     * 
     * Checks for various  possible name mappings camelCase to underbar etc. ...
     * @param unknown_type $model
     * @param unknown_type $name
     * @param unknown_type $value
	 */
    public function setModelAttribute($model, $name, $value)
    {
		if (!$model->setAttribute($name,$value)){ // safely returns false if attribute does not exist
			// try converting the name to underscore syntax and see if there is a match
			return $model->setAttribute($this->from_camel_case($name),$value);
		}
		return true;
    }
    
     /**
	 */

    public function updateAll()
    {
		foreach ($servers as $serverName => $serverConfig) {
			foreach ($serverConfig['services'] as $serviceName => $serviceConfig) {
	    		update($serverName, $serviceName);
			}
    	}
    }
    
    /**
     * 
     * Enter description here ...
     * @param unknown_type $server
     * @param unknown_type $service
	 * @param array $params parameters to be added to service request.
     * @return Ambiguous
	 */
    public function getDataFromService($server, $service, $params=array())
    {
		// get config data from config/main.php?
    	$uri = $this->servers[$server]['uri'];
    	$operation = $this->servers[$server]['operation'];
    	$from = $this->servers[$server]['from'];
    	$to = $this->servers[$server]['to'];
    	$uName = $this->servers[$server]['uName'];
    	$pWord = $this->servers[$server]['pWord'];
		
    	// set up uri
		//$service = 'classes';
    	$uri = $uri . "?service=$service";
		foreach ($params as $name => $value) {
			$uri .= "&$name=$value";
    	}
    	$url = parse_url($uri);
		
		$data = "Operation=$operation&From=$from&To=$to&UserName=$uName&Password=$pWord";
		
		//$test_uri = 'https://ais-dev-dmz-6.ucsc.edu:1821/PSIGW/HttpListeningConnector?service=all';
		//$uri = 'https://ais-dev-dmz-6.ucsc.edu:1821/PSIGW/HttpListeningConnector?service=classes';
		//$url = parse_url($uri);
		//$data = 'Operation=SCX_ETEXT.v1&From=SCX_ETEXT_NODE&To=PSFT_CSDEV&UserName=ETEXT&Password=j@bberw0cky';
		
		$timeout=80;
		set_time_limit ( 600 );

		$path = $url['path'];
		$host = $url['host'];
		$port = (!empty($url['port']) ? $url['port'] : null);
		$scheme = $url['scheme'];
		$protocol=$url['scheme'].'://';

		if (!isset($port)) {
			switch ($scheme) {
				case 'https':
					$port=443;
					break;
				default:
					$port=80;
			}
		}
		
		$newUri = $protocol.$host.(!empty($port) ? ':'.$port : '').$path;

		$eol="\r\n";
		
		$headers = "Host: ".$host.$eol.
		"Content-Type: application/x-www-form-urlencoded".$eol.
		"Content-Length: ".strlen($data).$eol.
		"Connection: close".$eol.$eol;
		
		$options = array(
			'method' => 'POST',
			'header' => $headers,
			'timeout' => $timeout,
			'content' => $data
		);
		$context = stream_context_create(
			array('http' => $options)
		);
		
    	// call service to get data
		$fp = fopen($uri,'r',false,$context);

		if (!$fp) {
		
			$errorArr['error_nbr'] = $errnbr;
			$errorArr['error_str'] = $errstr;
			return $errorArr;

		} else {

			$response_content = stream_get_contents($fp);
			$metadata = stream_get_meta_data($fp);
			
		    fclose($fp);
		    
		    $chunked = false;
		    foreach ($metadata['wrapper_data'] as $response_header) {
		    	if (strpos(strtolower($response_header), "transfer-encoding: chunked") !== FALSE) $chunked = true;
		    }
	
			if ($chunked) {
				$response_content = $this->unchunkHttp11($response_content);
			}
			
			$xmlObj = simplexml_load_string($response_content);
			
			//echo '<pre>'.print_r(get_object_vars($xmlObj),1),'</pre>';
			return $xmlObj;
		} 
    }

	/**
	 */
    public function unchunkHttp11($data) {
	    $fp = 0;
	    $outData = "";
	    while ($fp < strlen($data)) {
	        $rawnum = substr($data, $fp, strpos(substr($data, $fp), "\r\n") + 2);
	        $num = hexdec(trim($rawnum));
	        $fp += strlen($rawnum);
	        $chunk = substr($data, $fp, $num);
	        $outData .= $chunk;
	        $fp += strlen($chunk);
	    }
	    return $outData;
	}
    
    /**
	 * Updates Model from data in a SimpleXMLElement object.
	 * @param SimpleXMLElement $elem the attribute name
	 */
	public static function updateFromSimpleXML($elem, $className = null)
	{
		if (!$className){
			$className = $elem->getName();
		}
		if (class_exists($className)) {
			$model = new $className;
			//$className = get_called_class();
			//if ($elem->getName() == $className){
			//$model = new $className;
			//$model = new static();
			
			//create model from new data
			foreach ($elem->children() as $node) {
				//$attribs[$node->getName()] = (string)$node;
				//$this->{$node->getName()} = (string)$node;
				$model->setAttribute($node->getName(),(string)$node); // safely returns false if attribute does not exist
			}
			$modelPrior = $model->findByPk($model->getPrimaryKey());  
			//now check if the model is null
			if(!$modelPrior) {
				$model->save();			
			} else{
				// update
				$modelPrior->updateByPk($model->getPrimaryKey(), $model->getAttributes());			
			}
		}
		// ......
	}

	/**
   	* Translates a camel case string into a string with underscores (e.g. firstName -&gt; first_name)
   	* @param    string   $str    String in camel case format
   	* @return    string            $str Translated into underscore format
   	*/
  	public function from_camel_case($str) {
    	$str[0] = strtolower($str[0]);
    	$func = create_function('$c', 'return "_" . strtolower($c[1]);');
    	return preg_replace_callback('/([A-Z])/', $func, $str);
  	}
 
	/**
	* Translates a string with underscores into camel case (e.g. first_name -&gt; firstName)
	* @param    string   $str                     String in underscore format
	* @param    bool     $capitalise_first_char   If true, capitalise the first char in $str
	* @return   string                              $str translated into camel caps
	*/
	public function to_camel_case($str, $capitalise_first_char = false) {
		if($capitalise_first_char) {
			$str[0] = strtoupper($str[0]);
		}
		$func = create_function('$c', 'return strtoupper($c[1]);');
		return preg_replace_callback('/_([a-z])/', $func, $str);
   }
	
}
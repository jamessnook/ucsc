<?php
/**
 * XMLUpdater handels calls to XML services to retreive data and update local datastores.
 */
class XMLUpdater extends CApplicationComponent
{
	
    /**
     * The configuration data for servers to call services on.
     * This data comes from the config/main.php file
     * @var array
     */
    public $servers = array();
	
	/**
	 * 
	 * This is a genreral purpose update function used to call an xml service and import and save data to the applications models.
	 * @param string $server   Identifies the name of the server to call as used in the main/config.php file
	 * @param string $service  Identifies the name of the service to call on the server as used in the main/config.php file
	 * @param array $params    parameters to be added to service request sent to server.
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
	 * Recursive function to import the data in an individual xml element (node) into the local models
	 * This method attempts to match the axml data to models using naming configured in the config/main.php.  
	 * If there is no config information for a node the code attempts to match the node name to attributes or model names directly 
	 * or by translating from camel case to underbar naming conventions.
	 * @param SimpleXMLElement $xml  An object reperesentation of an xml node.
	 * @param array $config an array holdong the config information from config/main.php providing needed information about the schema for the xml.
	 * @param SimpleXMLElement $parent  An object reperesentation of the parent xml node. IF $xml has no parent then $parent is null.
	 */
    public function updateElement($elem, $config = null, $parent = null)
    {
		// Check for mapper.  If a mapper class is configured for this node then it is called 
		// to import the object rather then using the code below
		if ($config && isset($config['mapper'])){
			$model = new $config['mapper']($elem);
		} else { // If no mapper class is set then use the config information or name matching to help import the object
			if ($config && isset($config['model'])){  // see if a model class name is defined in the config
				$model = new $config['model'];
			} 
			else if (@class_exists($elem->getName())) { // If no model class name is defined try to use the xml element name
				// the @ in the call above suppresses warnings from the autoloader if the class is not found
				$className = $elem->getName();
				$model = new $className;
			} 
			else { // If no model class can be identified for this element do not import it
				return;
			}
			// First assign any inherited parent attributes which might be inherited by default, these will later be overridden if needed
			if ($parent){
				foreach ($parent->children() as $possibleAttribute) {
					// first look for configured parent attributes
					if ($config && isset($config['parentAttributes'][$possibleAttribute->getName()])){
						$model->setAttribute($config['parentAttributes'][$possibleAttribute->getName()],(string)$possibleAttribute); // safely returns false if attribute does not exist
					}
					// try name matching any parent attributes to child attributes (often needed in many-many associatin tables.)
					else if (!$this->setModelAttribute($model,$possibleAttribute->getName(),(string)$possibleAttribute)){ 
						if (strtolower($possibleAttribute->getName()) == "id" ){  // special case to get parent id as default
							$this->setModelAttribute($model,$parent->getName()."Id",(string)$possibleAttribute);
						}
					}
				}
			}
			// For child elements the which are multible elements with the same name 
			// but where the child element is a single value, this value needs to be mapped to an attribute of the child.  
			// This is common for many to many associations such as emplid for course instructors included in the class (course) element.
			if ($config && isset($config['thisAsAttribute'])){
				$model->setAttribute($config['thisAsAttribute'],(string)$elem); // safely returns false if attribute does not exist
			}
			// Now look at each of the child nodes of the current xml element and try to import them as attribute or child elements.
			foreach ($elem->children() as $child) {
				// see if there is an attriute name defined in the config for this node 
				if ($config && isset($config['attributes'][$child->getName()])){
					$model->setAttribute($config['attributes'][$child->getName()],(string)$child); // safely returns false if attribute does not exist
				}
				// if there is no attriute name defined in the config for this node see if it is configed 
				// as a child element and call this method recursively
				else if ($config && isset($config['children'][$child->getName()])){
					$this->updateElement($child, $config['children'][$child->getName()], $elem);
				}
				// if there is no config setting for this attribute see if the xml node name matches a model attribute
				else if (!$this->setModelAttribute($model,$child->getName(),(string)$child)){ // safely returns false if attribute does not exist
					// IF there is still no match try matching the node name to a possible child element model class 
					if (@class_exists($child->getName())) {
						// the @ in the call above suppresses warnings from the autoloader if the class is not found
						$this->updateElement($child);
					} 
				}
			}
	    }
		// update or save model
		// If there is already data in the database for this primary key then perform an update, other wise do a save
		$modelPrior = $model->findByPk($model->getPrimaryKey());  
		if(!$modelPrior) {  // save
			$model->save();			
		} else{  // update
			$modelPrior->updateByPk($model->getPrimaryKey(), $model->getAttributes());			
		}
    }
    
    /**
     * Assigns an attribute value in a model
     * Checks for various  possible name mappings camelCase to underbar etc. ...
     * @param CActiveRecord $model  Model object to have attribute assigned for
     * @param string $name  Possible name of attribute
     * @param String $value  Value to be assigned to attribute
	 */
    public function setModelAttribute($model, $name, $value)
    {
		if (!$model->setAttribute($name,$value)){ // safely returns false if attribute does not exist
			// if the is no exact name match then try converting the name to underscore syntax and see if there is a match
			return $model->setAttribute($this->from_camel_case($name),$value);
		}
		return true;
    }
    
     /**
      * 
      * Updates all servers and services defined in the config/main.php file
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
	 * This is a genreral purpose update function used to call an xml service and get data.
	 * @param string $server   Identifies the name of the server to call as used in the main/config.php file
	 * @param string $service  Identifies the name of the service to call on the server as used in the main/config.php file
	 * @param array $params    parameters to be added to service request sent to server.
     * @return SimpleXMLElement   An object holding the xml data retreived from the service.
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
		
		$timeout=80;
		set_time_limit ( 3600 );

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
			// need to add error logging and reporting

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
			
			return $xmlObj;
		} 
    }

	/**
	 * 
	 * Used for processing string data
	 * @param string $data
	 * @return string
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
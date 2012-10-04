<?php
/**
 * XMLUpdater handels calls to XML services to retreive data and updatelocal datastores.
 */
class XMLUpdater extends CController
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
    public $serverConfigs = array();
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $server
	 * @param unknown_type $service
	 */
    public function update($server, $service)
    {
    	// call service to get data
    	$xml = getDataFromService($server, $service);
    	// read config
    	$elementConfigs = $serverConfigs[$server]['services'][$service];
    	// parse XML and create objects
		foreach ($xml->children() as $elem) {
			// find config or set to null
			$config = null;
			if (isset($config[$elem->getName()])){
				$config = $config[$elem->getName()];
			}
			$this->updateElement($elem, $config);  // recursive
			
		}
			
    }

	/**
	 * 
	 * Recursive...Enter description here ...
	 * @param unknown_type $xml
	 * @param unknown_type $config
	 * @param unknown_type $parent
	 */
    public function updateElement($xml, $config = null, $parent = null)
    {
		// check for mapper
		if (isset($config['mapper'])){
			$model = new $config['mapper']($xml);
		} else { // use config or defaults
			if ($config && isset($config['model'])){
				$model = new $config['model'];
			} 
			else if (class_exists($xml->getName())) {
				$model = new $xml->getName();
			} 
			else {
				return;
			}
			foreach ($elem->children() as $child) {
				if ($config && isset($config['attributes'][$child->getName()])){
					$model->setAttribute($config['attributes'][$child->getName()],(string)$child); // safely returns false if attribute does not exist
				}
				else if ($config && isset($config['children'][$child->getName()])){
					$this->updateElement($child, $config['children'][$child->getName()], $elem);
				}
				else if ($config && isset($config['parentAttributes'][$child->getName()]) && $parent){
					$model->setAttribute($config['attributes'][$child->getName()],(string)$parent->{$child->getName()}); // safely returns false if attribute does not exist
				}
				// if there is no config setting for this attribute see if the xml name matches a model attribute
				else if (!$model->setAttribute($child->getName(),(string)$child)){ // safely returns false if attribute does not exist
					// try converting the name to underscore syntax and see if there is a match
					if (!$model->setAttribute($this->from_camel_case($child->getName()),(string)$child)){
						// try matching ot a class 
						
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
	 */
    public function updateAll()
    {
    	// get list of elements to look for from config and class mapping if avialable
    	// call service to get data
    	
    	// parse XML and create objects
    	
    	// iterate on objects and update appropriate model
    		// for each create new  look up call simple xml constructor -update...
    }

    /**
	 */
    public function getDataFromService($server, $service)
    {
    	// get uri from config
		$service = 'students';
    	$uri =  'https://ais-dev-dmz-6.ucsc.edu:1821/PSIGW/HttpListeningConnector';
    	$uri = uri . "?service=$service";
    	$url = parse_url($uri);
		
		// get password from config or better??
		$operation = 'SCX_ETEXT.v1';
		$from = 'SCX_ETEXT_NODE';
		$to = 'PSFT_CSDEV';
		$uName = 'ETEXT';
		$pWord = 'j@bberw0cky';
		
		$data = "Operation=$operation&From=$from&To=$to&UserName=$uName&Password=$pWord";
		
		$timeout=30;

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
		
		$uri = $protocol.$host.(!empty($port) ? ':'.$port : '').$path;

		$eol="\r\n";
		
		$headers = "Host: ".$host.$eol.
		"Content-Type: application/x-www-form-urlencoded".$eol.
		"Content-Length: ".strlen($test_data).$eol.
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
		$fp = fopen($test_uri,'r',false,$context);

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
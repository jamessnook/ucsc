<?php
/**
 * DataImporter is a components used to import data from external sources and update local datastores.
 * 
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2013 University of California, Santa Cruz
 * @package base.protected.components
 */
class DataImporter extends CApplicationComponent
{
	
    /**
     * The configuration data.
     * This data comes from the config/main.php file
     * @var array
     */
     public $readerClass = '';
     public $feedClass = '';
     public $modelClass = '';
     public $location = '';
     public $config = array();
     public $fieldNames = null;

     public $feed = array();
     public $reader = array();
          
     
	/**
	 * 
	 * This is a general purpose update function used to collect data from an external source and import and save data to the applications models.
	 * @param array $params    parameters as required.
	 */
     protected function update($params=array())
    {
    	$reader = new $reader['class'];
    	$feed = new $feed['class'];
    	$model = $modelClass::model();
    	return $reader->update($feed->getData($location), $modelClass);
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
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
	 */
    public function update()
    {
    	// call service to get data
    	
    	// parse XML and create objects
    	
    	// iterate on objects and update appropriate model
    		// fore each create new  look up call simple xml constructor -update...
    }

	/**
	 */
    public function getDataFromService()
    {
    	// get uri from config
    	
    	// call service to get data
		$test_uri = 'https://ais-dev-dmz-6.ucsc.edu:1821/PSIGW/HttpListeningConnector?service=students';
		$url = parse_url($test_uri);
		$test_data = 'Operation=SCX_ETEXT.v1&From=SCX_ETEXT_NODE&To=PSFT_CSDEV&UserName=ETEXT&Password=j@bberw0cky';
		
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
		
		//echo $headers;

		$options = array(
			'method' => 'POST',
			'header' => $headers,
			'timeout' => $timeout,
			'content' => $test_data
		);
		$context = stream_context_create(
			array('http' => $options)
		);

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
				$response_content = $this->unchunk($response_content);
			}
			
			//echo '<br>Integration Broker response<pre>';
			//print_r(htmlspecialchars($response_content));
			//echo '</pre>';

			$xmlObj = simplexml_load_string($response_content);
			echo '<pre>'.print_r(get_object_vars($xmlObj),1),'</pre>';
			//return $xmlObj;

		} //if($fp)
    	
    	// parse XML and create objects
    	
    	// iterate on objects and update appropriate model
    		// fore each create new  look up call simple xml constructor -update...
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
    
}
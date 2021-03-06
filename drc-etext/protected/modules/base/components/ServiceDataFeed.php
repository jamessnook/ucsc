<?php
/**
 * ServiceDataFeed collects stream data from an external web service as a string.
 * 
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.components
 */
class ServiceDataFeed extends DataFeed
{
    
    /**
     * 
	 * This is a function used to call a service and get data.
     * @return string holding the data.
	 */
    public function getData()
    {
		// get config data from config/main.php?
    	$uri = $this->config['uri'];
    	$operation = $ $this->config['operation'];
    	$from =  $this->config['from'];
    	$to = $ $this->config['to'];
    	$uName =  $this->config['uName'];
    	$pWord =  $this->config['pWord'];
    	$service =  $this->config['service'];
    	
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
			
			//$xmlObj = simplexml_load_string($response_content);
			
			//return $xmlObj;
			return $response_content;
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
    
}
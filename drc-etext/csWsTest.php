<?php
//$test_uri = 'https://ais-dev-dmz-6.ucsc.edu:1821/PSIGW/HttpListeningConnector?service=all';
//$test_uri = 'https://ais-dev-dmz-6.ucsc.edu:1821/PSIGW/HttpListeningConnector?service=accomodations&emplid=0150172';
$test_uri = 'https://ais-dev-dmz-6.ucsc.edu:1821/PSIGW/HttpListeningConnector?service=enrollments';
$url = parse_url($test_uri);
$test_data = 'Operation=SCX_ETEXT.v1&From=SCX_ETEXT_NODE&To=PSFT_CSDEV&UserName=ETEXT&Password=j@bberw0cky';

//$timeout=30;
		$timeout=80;
		set_time_limit ( 720 );

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


function unchunkHttp11($data) {
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

?>
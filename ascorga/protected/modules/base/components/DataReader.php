<?php
/**
 * XMLUpdater handels calls to XML services to retreive data and update local datastores.
 * 
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.components
 */
abstract class DataReader extends DataReader
{
	
	/**
	 * 
	 * This is a genreral purpose update function used to call an xml service and import and save data to the applications models.
	 * @param string $server   Identifies the name of the server to call as used in the main/config.php file
	 * @param string $service  Identifies the name of the service to call on the server as used in the main/config.php file
	 * @param array $params    parameters to be added to service request sent to server.
	 */
    abstract public function update($dataString, $modelClass, $fieldNames = null)
    {
	}

}
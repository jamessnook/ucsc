<?php
/**
 * DataFeed is the abstract super class of classes to collect stream data from an external sourcee as a string.
 * 
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.components
 */
abstract class DataFeed extends CBehavior
{
    
    /**
     * 
	 * This is a genreral purpose update function used to get data.
	 * @param string $server   Identifies the name of the server to call as used in the main/config.php file
	 * @param string $service  Identifies the name of the service to call on the server as used in the main/config.php file
	 * @param array $params    parameters to be added to service request sent to server.
     * @return string holding the data.
	 */
    abstract public function getData($location, $params=array())
    {
    }

    
}
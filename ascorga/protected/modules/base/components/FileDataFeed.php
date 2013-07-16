<?php
/**
 * ServiceDataFeed collects stream data from an external web service as a string.
 * 
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.components
 */
class FileDataFeed extends DataFeed
{
    
    /**
     * 
	 * This is a genreral purpose update function used to read a file and get data.
	 * @param array $params    parameters.
     * @return string holding the data.
	 */
    public function getData($location)
    {
    	return file_get_contents($location);
    }
    
}
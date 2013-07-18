<?php
/**
 * FileDataFeed collects data from a file as a string.
 * 
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2013 University of California, Santa Cruz
 * @package drc-etext.protected.components
 */
class FileDataFeed extends DataFeed
{
    
    /**
     * 
	 * This is the function used to get data.
     * @return string holding the data.
	 */
    public function getData()
    {
    	return file_get_contents($this->config['location']);
    }
    
}
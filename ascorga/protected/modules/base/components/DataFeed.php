<?php
/**
 * DataFeed is the abstract super class of classes to collect data from an external source.
 * 
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.components
 */
abstract class DataFeed extends CComponent
{
    
    /**
     * The configuration data.
     * This data comes from the config/main.php file
     * @var array
     */
     public $config = array();
     
	/**
     * 
	 * This is the function used to get data.
     * @return object holding the data.
	 */
    abstract public function getData()
    {
    }

    
}
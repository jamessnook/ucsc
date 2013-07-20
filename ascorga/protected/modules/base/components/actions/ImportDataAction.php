<?php

/**
 * ImportDataAction
 * =============
 * Basic functionality to load part of the database from a file or service.
 * 
 *
 * @author JSnook 
 * @package drc-etext.protected.extensions.components
 */
class ImportDataAction extends CAction {

	/**
     * The configuration data.
     * This data comes from the config/main.php file
     */
     public $feed = array();
     public $reader = array();
     public $timeout = 600;
     
    /**
     * Member components built using above config
     */
     public $myFeed;
     public $myReader;
          
     
	/**
	 * provide needed initialization.
	 */
	public function init()
	{
    	$this->myReader = new $this->reader['class'];
    	$this->myReader->config = $this->reader;
    	$this->myFeed = new $this->feed['class'];
    	$this->myFeed->config = $this->feed;
    	set_time_limit ( $this->timeout );
    	
	}
	

    /**
     * The main action that handles the data import request.
      */
    public function run( ) {
    	$this->init();
    	return $this->myReader->processData($this->myFeed->getData());
    }
    
}

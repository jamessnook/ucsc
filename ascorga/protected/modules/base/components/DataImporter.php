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
     */
     public $feed = array();
     public $reader = array();
          
    /**
     * Member components built using above config
     */
     public $myFeed;
     public $myReader;
          
     
	/**
	 * Overrides parent method to provide needed initialization.
	 */
	public function init()
	{
		parent::init();
    	$this->myReader = new $this->reader['class'];
    	$this->myReader->config = $this->reader;
    	$this->myFeed = new $this->feed['class'];
    	$this->myFeed->config = $this->feed;
	}
	

	/**
	 * 
	 * This is a general purpose update function used to collect data from an external source and import and save data to the applications models.
	 */
     public function update()
     {
     	set_time_limit ( 600 );
    	return $this->myReader->processData($this->myFeed->getData());
     }

}
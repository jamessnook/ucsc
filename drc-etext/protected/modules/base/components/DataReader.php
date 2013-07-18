<?php
/**
 * DataReader is the abstrtact super class of classes used to process data and load it into the applications data models.
 * 
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2013 University of California, Santa Cruz
 * @package base.components
 */
abstract class DataReader extends CComponent
{
	
    /**
     * The configuration data.
     * This data comes from the config/main.php file
     * @var array
     */
     public $config = array();
     
	/**
	 * 
	 * This is a general purpose function used process data and load it into the applications data models.
	 * @param $data    object holding data.
	 */
    abstract public function processData($data);
    
	/**
	 * 
	 * This saves a row of data into a record in the applications data models.
	 * @param array $data    row of data.
	 */
    public function saveRow($row)
    {
	    foreach ($this->config['defaults'] as $name => $value){
	    	$row[$name] = $value;
	    }
		$modelClass = $this->config['model'];
		$record = $modelClass::loadModel($row);
		echo $record->username .', ';
		$record->save();
    }

	/**
	 * 
	 * This saves an array of rows of data into a record in the applications data models.
	 * @param array $data    array of arrays of data.
	 */
    public function save($dataArray)
    {
		foreach($dataArray as $row){
			$this->saveRow($row);
		}	
    }

    

}
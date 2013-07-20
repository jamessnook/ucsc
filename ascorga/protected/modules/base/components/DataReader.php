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
	    foreach ($this->config['convert'] as $name => $function){
	    	$row[$name] = $this->$function($row[$name]);
	    }
	    foreach ($this->config['replace'] as $name => $options){
	    	$row[$name] = $this->replace($row, $options);
	    }
	    $modelClass = $this->config['model'];
		$record = $modelClass::loadModel($row);
		echo $record->div_data_id .', ';
		$record->save();
    }

	/**
	 * 
	 * This saves an array of rows of data into a record in the applications data models.
	 * @param array $data    array of arrays of data.
	 */
    public function save($dataArray)
    {
		$model = CActiveRecord ::model($this->config['model']);
	    foreach ($this->config['setAllBefore'] as $name => $value){
			$model->updateAll(array($name=>$value));
	    }
	    $start = 0;
	    if ($this->config['skipFirstRow']){
	    	$start = 1;
	    }
	    $end = count($dataArray);
		//foreach($dataArray as $row){
		for($i=$start; $i<$end; $i++){
			$this->saveRow($dataArray[$i]);
		}	
    }

 	/**
	 * 
	 * This converts a date string to MySQL format for insert to DB.
	 * @param array $value    date string.
	 */
    public function toMysqlDate($value)
    {
    	return date('Y-m-d H:i:s', strtotime($value));;
    }

     /**
	 * 
	 * This creates a new value based on other values in a data row (array).
	 * @param array $row    row data.
	 */
    public function replace( $row, $options=array())
    {
    	$prepend = '';
    	if (isset($options['prepend'])) $prepend = $options['prepend'];
    	return $prepend . $row[$options['oldField']];
    }

     

}
<?php
/**
 * CSVReader is used to process a string of CSV data and load it into the applications data models.
 * 
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2013 University of California, Santa Cruz
 * @package base.components
 */
class CSVReader extends DataReader
{
	
	
	/**
	 * 
	 * This is a general purpose function used process a string of CSV data and load it into the applications data models.
	 * @param striing $data    string of CSV data.
	 */
    public function processData($data)
    {
    	if (isset($this->config['fieldNames'])){
    		$dataArray = getCSVNoHeader($data, $this->config['fieldNames']);
       	} else{
    		$dataArray = getCSV($data);
        }
		foreach($dataArray as $row){
			$record = $config['modelClass']::loadModel($row);
			$record->save();
		}	
    }

	 /**
     * 
	 * This function converts a string of CSV data to an array of arrays.
	 * This functon assumes the first row of data includes column names.
	 * @param striing $dataString    string of CSV data.
     * @return array of arrays holding the data.
	 */
    public function getCSV($dataString)
    {
    	$lines = explode("\n", $dataString);
    	$lineCount = count($lines);
    	$fieldNames = str_getcsv($lines[0]);
		
		$dataArray = array();
		for ($i = 1; $i < $lineCount; $i++) {
			$fields = str_getcsv($lines[$i]);
		    $dataArray[] = array_combine($fieldNames, $fields);
		}
		return $dataArray;
    }
    
	 /**
     * 
	 * This function converts a string of CSV data to an array of arrays.
	 * This functon assumes the first row of data does not include column names.
	 * @param striing $dataString    string of CSV data.
     * @return array of arrays holding the data.
	 */
    public function getCSVNoHeader($dataString, $fieldNames)
    {
    	$lines = explode("\n", $dataString);
		$dataArray = array();
		foreach($lines as $line){
			$fields = str_getcsv($lines[$i]);
		    $dataArray[] = array_combine($fieldNames, $fields);
		}	
		return $dataArray;
    }
    
    
}
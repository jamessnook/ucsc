<?php

/**
 * This is a base class for active record classes with usefull funtionality added.
 *
 *
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.models
 */
class BaseModel extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * Must be overridden in each sub-class
	 * @param string $className active record class name.
	 * @return the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	/**
	 * Overrides parent to assign non input values.
	 * Here we assign time stamps and user data to any tables that include it.
	 * @return boolean whether the saving should be executed. Defaults to true.
	 */
	public function beforeSave(){
		$now = date('Y-m-d H:i:s');
    	if ($this->isNewRecord){
			$this->setAttribute('created', $now); // safely returns false if attribute does not exist
		}
		$this->setAttribute('modified', $now); // safely returns false if attribute does not exist
		$this->setAttribute('modified_by', Yii::app()->user->name); // safely returns false if attribute does not exist
		return parent::beforeSave();
	}
	
	/**
	 * Retrieves a url parameter array using data from this object.
	 * @return array of url params.
	 */
	public function urlParams($route, $paramMap)
	{
		$params = array();
		foreach($paramMap as $name => $source) $params[$name]=$this->$source;
		return array($route, $params);
	}
	
	/**
	 * Returns the data model based on the passed attributes.
	 * Persues various ways of finding and creating the model
	 * @param array of parameters
	 * @return model instance of a BaseModel subclass built using the url params.
	 */
	public static function loadModel($params=null)
	{
		$className=get_called_class();
		$aModel=new $className(null);
		if (!$params) $params = $_REQUEST;
		// check for array of parrams
		if (isset($params[$className]) && is_array($params[$className])){
			$params = array_merge($params, $params[$className]);
			//unset($params[$className]);
			//echo $params[$className]['first_name'];
			//echo $params['first_name'];
		}
		$aModel->unsetAttributes();  // clear any default values .. is this needed?
		if ($params){
			$aModel->setIsNewRecord(true);
			$key = $aModel->getTableSchema()->primaryKey;
			$tableParams = array();
			// find primary key params that are in table model
			foreach($params as $name=>$value){
				if ($name == $key || (is_array($key) && in_array($name, $key))){
					$tableParams[$name]= $value;
				}
			}
			if (count($tableParams)>0){
				$newModel=$aModel->findByAttributes($tableParams);
				if($newModel){
					$aModel->attributes = $newModel->attributes;
					$aModel->setIsNewRecord(false);
				}
			}
			// change alls to blanks and set values
			foreach($params AS $name=>$value){
				if ($value=='all' || $value=='All'|| $value=='-1'|| $value==-1 ){
	        		$value = "";
				}
				try {
					//echo " $name=$value, ";
					$aModel->$name=$value;  // @ = ignore errors
				} catch (Exception $e) {
					//echo ' trouble.. ';
					// ignore
				}
			}
		}
		return $aModel;
	}

	/**
	 * Returns the data model based on the passed attributes.
	 * Persues various ways of finding and creating the model
	 * @param array of parameters
	 * @return model instance of a UCSCModel subclass built using the url params.
	 */
	public static function loadModelOld($params=null)
	{
		$className=get_called_class();
		$aModel=new $className(null);
		if (!$params) $params = $_REQUEST;
		// check for array of parrams
		if (isset($params[$className]) && is_array($params[$className])){
			$params = array_merge($params, $params[$className]);
		}
		$aModel->unsetAttributes();  // clear any default values .. is this needed?
		if ($params){
			// change alls to blanks and set values
			foreach($params AS $name=>$value){
				if ($value=='all' || $value=='All'|| $value=='-1'|| $value==-1 ){
	        		$value = "";
				}
				if (!is_array($value)){
					@$aModel->$name=$value;  // @ = ignore errors
				}
			}
			$aModel->setIsNewRecord(true);
			$key = $aModel->getTableSchema()->primaryKey;
			$tableParams = array();
			// find primary key params that are in table model
			foreach($params as $name=>$value){
				if ($name == $key || (is_array($key) && in_array($name, $key))){
					$tableParams[$name]= $value;
				}
			}
			if (count($tableParams)>0){
				$newModel=$aModel->findByAttributes($tableParams);
				if($newModel){
					$aModel->attributes = $newModel->attributes;
					$aModel->setIsNewRecord(false);
				}
			}
		}
		return $aModel;
	}

	 /**
     * Assigns an attribute value in a model
     * Checks for various  possible name mappings camelCase to underbar etc. ...
     * @param CActiveRecord $model  Model object to have attribute assigned for
     * @param string $name  Possible name of attribute
     * @param String $value  Value to be assigned to attribute
	 */
    public function setAttribute($name, $value)
    {
		if (!parent::setAttribute($name,$value)){ // safely returns false if attribute does not exist
			// if the is no exact name match then try converting the name to underscore syntax and see if there is a match
			return parent::setAttribute($this->from_camel_case($name),$value);
		}
		return true;
    }
    
	/**
   	* Translates a camel case string into a string with underscores (e.g. firstName -&gt; first_name)
   	* @param    string   $str    String in camel case format
   	* @return    string            $str Translated into underscore format
   	*/
  	public function from_camel_case($str) {
    	$str[0] = strtolower($str[0]);
    	$func = create_function('$c', 'return "_" . strtolower($c[1]);');
    	return preg_replace_callback('/([A-Z])/', $func, $str);
  	}
 
	/**
	* Translates a string with underscores into camel case (e.g. first_name -&gt; firstName)
	* @param    string   $str                     String in underscore format
	* @param    bool     $capitalise_first_char   If true, capitalise the first char in $str
	* @return   string                              $str translated into camel caps
	*/
	public function to_camel_case($str, $capitalise_first_char = false) {
		if($capitalise_first_char) {
			$str[0] = strtoupper($str[0]);
		}
		$func = create_function('$c', 'return strtoupper($c[1]);');
		return preg_replace_callback('/_([a-z])/', $func, $str);
   }
	
    
}
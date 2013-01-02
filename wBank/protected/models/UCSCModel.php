<?php

/**
 * This is a base class for active record classes with usefull funtionality added.
 *
 *
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.models
 */
class UCSCModel extends CActiveRecord
{

	/**
	 * Returns the static model of the specified AR class.
	 * Must be overridden in each sub-class
	 * @param string $className active record class name.
	 * @return BookRequest the static model class
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
	 * @return model instance of a UCSCModel subclass built using the url params.
	 */
	public static function loadModel($params=null)
	{
		$className=get_called_class();
		$aModel=new $className(null);
		if (!$params) $params = $_REQUEST;
		// check for array of parrams
		if (isset($params[$className]) && is_array($params[$className])){
			$params = $params[$className];
		}
		$aModel->unsetAttributes();  // clear any default values .. is this needed?
		if ($params){
			// change alls to blanks and set values
			foreach($params AS $name=>$value){
				if ($value=='all' || $value=='All'|| $value=='-1'|| $value==-1){
	        		$value = "";
				}
				$aModel->$name=$value;
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

}
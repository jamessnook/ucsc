<?php

/**
 * This is a base class for active record classes with usefull funtionality added.
 *
 */
class UCSCModel extends CActiveRecord
{
	public $term_id;
	public $username;
	
	/**
	 * Returns the static model of the specified AR class.
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
	 * Persues various ways of creating the model
	 * @param array of parameters
	 */
	public static function loadModel($params=null)
	{
		if (!$params) $params = $_REQUEST;
		$className=get_called_class();
		$model=new $className(null);
		$model->unsetAttributes();  // clear any default values .. is this needed?
		if(isset($_POST[$className]))
		{
			$model->attributes=$_POST[$className];
		}
		else if ($params){
			if(!is_array($params)){ // special case only a single value is a single primary key
				$model()->findByPk($params);
				if($model===null)
					throw new CHttpException(404,'The requested model does not exist.');
				$model->attributes=$_REQUEST; // or use setAttributes()
			} else {
				$newModel=Course::model()->findByAttributes($params);
				if($newModel)
					$model = $newModel;
				$model->attributes=$params; // or use setAttributes()
			}
			if(isset($_POST[$className])){
				$model->attributes=$_POST[$className];
			}
		}
		return $model;
	}

}
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
	

}
<?php

/**
 * This is the model class for table "file_type".
 *
 * Identifies a set of file types which can be assocaited with a file.
 * Is used to populate drop down menu.
 *
 * The followings are the available columns in table 'file_type':
 * @property integer $id
 * @property string $type
 * @property string $caption
 *
 * The followings are the available model relations:
 * @property DrcRequest[] $drcRequests
 * @property File[] $files
 *
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.models
 */
class DrcFileType extends FileType
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FileType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'drcRequests' => array(self::HAS_MANY, 'DrcRequest', 'type'),
			'files' => array(self::HAS_MANY, 'File', 'type_id'),
		);
	}

	/**
	 * Retrieves a data provider that can provide a list of file types and associated students for this Assignment 
	 * @return CActiveDataProvider the data provider that can return a list of File Association models.
	 */
	public function studentNames()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('class_num',$this->class_num);
		$criteria->with = array( 'DrcRequest');
		//$criteria->addCondition("drcRequests.username = $username");         
		$criteria->compare('model_id',$this->id);
		//$criteria->compare('file.type',$this->id);
		$criteria->compare('model_name','Assignment');
		$criteria->addCondition("file.type IN(SELECT drc_request.type FROM drc_request JOIN user USING(emplid) 
		      WHERE user.username = $this->username)");         
		
		return new CActiveDataProvider('FileType', array(
			'criteria'=>$criteria,
		 	'pagination' => false,
		));
	}
	/**
	 * Retrieves an array of file types needed for this user.
	 * @return array, the names of file types for this course.
	 */
	public function students()
	{
		$students = array();
		foreach($this->drcRequests as $request)
		{
			$students[] = $request->user; // use value as key to prevent duplicates
		}
		return $students;
	}
	
	
		
}
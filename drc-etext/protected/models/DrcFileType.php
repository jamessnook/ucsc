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
	 * Retrieves an array of file types needed for this user.
	 * @return array, the names of file types for this course.
	 */
	public static function options()
	{
		return CHtml::listData(FileType::model()->findAll(), 'id', 'name');	
	}
	
		/**
	 * Retrieves an array of file types needed for this user.
	 * @return array, the names of file types for this course.
	 */
	public static function optionsWithNameAsValue()
	{
		return CHtml::listData(FileType::model()->findAll(), 'name', 'name');	
	}
	
}
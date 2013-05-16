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
class FileType extends CActiveRecord
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
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'file_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type', 'required'),
			array('type', 'length', 'max'=>32),
			array('caption', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, caption', 'safe', 'on'=>'search'),
		);
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
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type' => 'Type',
			'caption' => 'Caption',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('caption',$this->caption,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Retrieves an array of file types needed for this user.
	 * @return array, the names of file types for this course.
	 */
	public static function options()
	{
		return CHtml::listData(FileType::model()->findAll(), 'id', 'name');	
	}
	
}
<?php

/**
 * This is the model class for table "file_association".
 *
 * Represents the association between an file ane the book,
 * assignment or other object it has been uploaded for. 
 *
 * The followings are the available columns in table 'file_association':
 * @property integer $file_id
 * @property integer $model_id
 * @property string $model_name
 *
 * The followings are the available model relations:
 * @property File $file
 *
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.models
 */
class FileAssociation extends UCSCModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FileAssociation the static model class
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
		return 'file_association';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('file_id, model_id, model_name', 'required'),
			array('file_id, model_id', 'numerical', 'integerOnly'=>true),
			array('model_name', 'length', 'max'=>63),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('file_id, model_id, model_name', 'safe', 'on'=>'search'),
			array('file_id, model_id, model_name', 'safe'),
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
			'file' => array(self::BELONGS_TO, 'File', 'file_id'),
			//'filedata' => array(self::BELONGS_TO, 'File', 'file_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'file_id' => 'File',
			'model_id' => 'Model',
			'model_name' => 'Model Name',
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

		$criteria->compare('file_id',$this->file_id);
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('model_name',$this->model_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
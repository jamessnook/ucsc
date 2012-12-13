<?php

/**
 * This is the model class for table "instructor_files".
 *
 * Identifies files uploaded by an instructor for a specific course.
 * Associates instructor, file and course
 *
 * The followings are the available columns in table 'instructor_files':
 * @property integer $file_id
 * @property integer $term_code
 * @property integer $class_number
 * @property string $emplId
 * @property string $notes
 * @property boolean $is_syllabus
 *
 * The followings are the available model relations:
 * @property User $empl
 * @property Course $class_number
 * @property Term $term_code
 * @property File $file
 *
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.models
 */
class InstructorFiles extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InstructorFiles the static model class
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
		return 'instructor_files';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('term_code', 'required'),
			array('term_code, class_number', 'numerical', 'integerOnly'=>true),
			array('emplId', 'length', 'max'=>32),
			array('notes', 'length', 'max'=>512),
			array('is_syllabus', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('file_id, term_code, class_number, emplId, notes, is_syllabus', 'safe', 'on'=>'search'),
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
			'empl' => array(self::BELONGS_TO, 'User', 'emplId'),
			'class_number' => array(self::BELONGS_TO, 'Course', 'class_number'),
			'term_code' => array(self::BELONGS_TO, 'Term', 'term_code'),
			'file' => array(self::BELONGS_TO, 'File', 'file_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'file_id' => 'File',
			'term_code' => 'Term Code',
			'class_number' => 'Class Number',
			'emplId' => 'Empl',
			'notes' => 'Notes',
			'is_syllabus' => 'Is Syllabus',
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
		$criteria->compare('term_code',$this->term_code);
		$criteria->compare('class_number',$this->class_number);
		$criteria->compare('emplId',$this->emplId,true);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('is_syllabus',$this->is_syllabus);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
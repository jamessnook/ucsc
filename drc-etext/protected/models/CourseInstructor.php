<?php

/**
 * This is the model class for table "course_instructor".
 *
 * Represents the association between a course 
 * and an instructor associated with that course.
 * Is used to identify the instructors for a course.
 *
 * The followings are the available columns in table 'course_instructor':
 * @property integer $term_code
 * @property integer $class_num
 * @property string $emplid
 *
 * The followings are the available model relations:
 * @property Course $course
 * @property User $instructor
 *
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.models
 */
class CourseInstructor extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CourseInstructor the static model class
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
		return 'course_instructor';
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
			array('term_code, class_num', 'numerical', 'integerOnly'=>true),
			array('emplid', 'length', 'max'=>32),
			// The following rule is used by search().   
			// Please remove those attributes that should not be searched.
			array('term_code, class_num, emplid', 'safe', 'on'=>'search'),
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
			'course' => array(self::BELONGS_TO, 'Course', 'term_code, class_num'),
			'sentEmails' => array(self::HAS_MANY, 'EmailSent', 'term_code, class_num'),
			'instructor' => array(self::BELONGS_TO, 'DrcUser', 'emplid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'term_code' => 'Term Code',
			'class_num' => 'Class Num',
			'emplid' => 'Emplid',
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

		$criteria->compare('term_code',$this->term_code);
		$criteria->compare('class_num',$this->class_num);
		$criteria->compare('emplid',$this->emplid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
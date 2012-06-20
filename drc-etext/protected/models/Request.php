<?php

/**
 * This is the model class for table "request".
 *
 * The followings are the available columns in table 'request':
 * @property integer $id
 * @property string $term_id
 * @property string $class_id
 * @property string $department
 * @property string $course
 * @property string $section
 * @property string $instructor_id
 * @property string $username
 * @property integer $type_id
 * @property string $course_name
 *
 * The followings are the available model relations:
 * @property BookRequest[] $bookRequests
 */
class Request extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Request the static model class
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
		return 'request';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('term_id, class_id, department, course, section, instructor_id', 'required'),
			array('type_id', 'numerical', 'integerOnly'=>true),
			array('term_id, class_id, course, section, instructor_id', 'length', 'max'=>32),
			array('department', 'length', 'max'=>128),
			array('username', 'length', 'max'=>64),
			array('course_name', 'length', 'max'=>256),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, term_id, class_id, department, course, section, instructor_id, username, type_id, course_name', 'safe', 'on'=>'search'),
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
			'bookRequests' => array(self::HAS_MANY, 'BookRequest', 'request_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'term_id' => 'Term',
			'class_id' => 'Class',
			'department' => 'Department',
			'course' => 'Course',
			'section' => 'Section',
			'instructor_id' => 'Instructor',
			'username' => 'Username',
			'type_id' => 'Type',
			'course_name' => 'Course Name',
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
		$criteria->compare('term_id',$this->term_id,true);
		$criteria->compare('class_id',$this->class_id,true);
		$criteria->compare('department',$this->department,true);
		$criteria->compare('course',$this->course,true);
		$criteria->compare('section',$this->section,true);
		$criteria->compare('instructor_id',$this->instructor_id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('course_name',$this->course_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
<?php

/**
 * This is the model class for table "course".
 *
 * The followings are the available columns in table 'course':
 * @property integer $term_code
 * @property integer $class_num
 * @property string $section
 * @property string $course_id
 * @property string $subject
 * @property string $description
 * @property string $title
 * @property string $catalog_num
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property Assignment[] $assignments
 * @property CourseInstructor[] $courseInstructors
 * @property CourseInstructor[] $courseInstructors1
 * @property InstructorFiles[] $instructorFiles
 */
class Course extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Course the static model class
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
		return 'course';
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
			array('section, course_id', 'length', 'max'=>32),
			array('subject, catalog_num', 'length', 'max'=>64),
			array('description', 'length', 'max'=>512),
			array('title', 'length', 'max'=>128),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('term_code, class_num, section, course_id, subject, description, title, catalog_num, created, modified', 'safe', 'on'=>'search'),
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
			'assignments' => array(self::HAS_MANY, 'Assignment', 'class_number'),
			'courseInstructors' => array(self::HAS_MANY, 'CourseInstructor', 'term_code'),
			'courseInstructors1' => array(self::HAS_MANY, 'CourseInstructor', 'class_num'),
			'instructorFiles' => array(self::HAS_MANY, 'InstructorFiles', 'class_number'),
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
			'section' => 'Section',
			'course_id' => 'Course',
			'subject' => 'Subject',
			'description' => 'Description',
			'title' => 'Title',
			'catalog_num' => 'Catalog Num',
			'created' => 'Created',
			'modified' => 'Modified',
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
		$criteria->compare('section',$this->section,true);
		$criteria->compare('course_id',$this->course_id,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('catalog_num',$this->catalog_num,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * Provides a list of courses with additional data from other tables for student course view
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */

	public function studentCourses()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('term_code',$this->term_code);
		$criteria->compare('class_num',$this->class_num);
		$criteria->compare('section',$this->section,true);
		$criteria->compare('course_id',$this->course_id,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('catalog_num',$this->catalog_num,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}
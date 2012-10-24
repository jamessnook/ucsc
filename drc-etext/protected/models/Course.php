<?php

/**
 * This is the model class for table "Course".
 *
 * The followings are the available columns in table 'Course':
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
 * @property Term $termCode
 * @property CourseInstructor[] $courseInstructors
 * @property CourseInstructor[] $courseInstructors1
 * @property DrcRequest[] $drcRequests
 * @property DrcRequest[] $drcRequests1
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
		return 'Course';
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
			'assignments' => array(self::HAS_MANY, 'Assignment', 'term_code, class_num'),
			'termCode' => array(self::BELONGS_TO, 'Term', 'term_code'),
			'drcRequests' => array(self::HAS_MANY, 'DrcRequest', 'term_code'),
			'drcRequests1' => array(self::HAS_MANY, 'DrcRequest', 'class_num'),
			'instructorFiles' => array(self::HAS_MANY, 'InstructorFiles', 'class_num'),
            'instructors'=>array(self::MANY_MANY, 'User',
                'course_instructor(term_code, class_num, emplid)'),
            'courseInstructors'=>array(self::HAS_MANY, 'CourseInstructor', 'term_code, class_num'),
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
			'title' => 'Course Name',
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
	 * Retrieves a list of faculty names.
	 * @return string, the names of faculty for this course.
	 */
	public function faculty()
	{
		$names = '';
		foreach($this->courseInstructors as $instructor)
		{
			$names .= $instructor->user->first_name . ' ' . $instructor->user->last_name . ', ';
		}
		//foreach($this->instructors as $instructor)
		//{
		//	$names .= $instructor->first_name . ' ' . $instructor->last_name . ', ';
		//}
		if (strlen($names)>1 ) $names =  substr($names, 0, -2);
		return $names;
	}
	
	/**
	 * Retrieves a count of the assignemtns for this course.
	 * @return integer, a count of the assignemtns for this course.
	 */
	public function assignmentCount()
	{
		return count($this->assignments);
	}
	
	/**
	 * Returns true if all assignemtns for this course are complete.
	 * @return boolean, true if all assignemtns for this course are complete.
	 */
	public function completed()
	{
		foreach($this->assignments as $assignment){
			if (!$assignment->is_complete) return false;
		}
		return true;
	}
	
	/**
	 * Retrieves descriptive id string for this course.
	 * @return string, descriptive id string for this course.
	 */
	public function idString()
	{
		return $this->subject . ' ' . $this->catalog_num . ' - ' . $this->section;
	}
	
}
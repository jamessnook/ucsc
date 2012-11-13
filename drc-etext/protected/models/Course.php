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
 * @property string $schedule
 * @property string $romm
 * @property string $dates
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property Assignment[] $assignments
 * @property CourseInstructor[] $courseInstructors
 * @property CourseInstructor[] $courseInstructors1
 * @property DrcRequest[] $drcRequests
 * @property DrcRequest[] $drcRequests1
 * @property InstructorFiles[] $instructorFiles
 */
class Course extends CActiveRecord
{
	public $username;
	
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
			array('title, schedule, romm, dates', 'length', 'max'=>128),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('term_code, class_num, section, course_id, subject, description, title, catalog_num, schedule, romm, dates, created, modified', 'safe', 'on'=>'search'),
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
			'drcRequests' => array(self::HAS_MANY, 'DrcRequest', 'term_code, class_num'),
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
			'title' => 'Title',
			'catalog_num' => 'Catalog Num',
			'schedule' => 'Schedule',
			'romm' => 'Romm',
			'dates' => 'Dates',
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
		$criteria->compare('schedule',$this->schedule,true);
		$criteria->compare('romm',$this->romm,true);
		$criteria->compare('dates',$this->dates,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	

	/**
	 * Retrieves a list of assignments for this course based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function assignments()
	{
		$criteria=new CDbCriteria;
		if ($this->username) {
			$criteria->with = array( 'drcRequests', 'assignmentTypes' );
			//$criteria->together = array( 'drcRequests', 'assignmentTypes' ); // might be needed
			$criteria->compare('drcRequests.username',$this->username);
			//$criteria->addCondition("drcRequests.username = $username");         
			$criteria->addCondition("assignmentTypes.type = drcRequests.type");          
		}
		$criteria->compare('term_code',$this->term_code);
		$criteria->compare('class_num',$this->class_num);
		
		return new CActiveDataProvider('Assignment', array(
			'criteria'=>$criteria,
		 	'pagination' => false,
		));
	}

	/**
	 * Retrieves a list of assignments for this course based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function books()
	{
		$criteria=new CDbCriteria;
		$criteria->addCondition("id IN (SELECT book_id FROM assignment WHERE term_code ='$this->term_code' AND class_num='$this->class_num'");          
		
		return new CActiveDataProvider('Book', array(
			'criteria'=>$criteria,
		 	'pagination' => false,
		));
	}
	
	/**
	 * Retrieves a list of faculty names.
	 * @return string, the names of faculty for this course.
	 */
	public function facultyNames()
	{
		//$names = '';
		$names = array();
		foreach($this->courseInstructors as $instructor)
		{
			$names[] = $instructor->user->first_name . ' ' . $instructor->user->last_name;
		}
		return $names;
	}
	
	/**
	 * Retrieves a list of urls for faculty pages.
	 * @return string, the names of faculty for this course.
	 */
	public function facultyUrls()
	{
		$urls = array();
		foreach($this->courseInstructors as $instructor)
		{
			//$urls[] = 'http://campusdirectory.ucsc.edu/detail.php?type=people&uid='.$instructor->user->username;
			$urls[] = "http://campusdirectory.ucsc.edu/detail.php?type=people&uid=" . 'jsnook';
		}
		return $urls;
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
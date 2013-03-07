<?php

/**
 * This is the model class for table "course".
 *
 * Represents a single course which one or more DRC students have requested services for.
 * This is supplied by the data feed from AIS.
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
 * @property EmailSent[] $emailsSent
 * @property DrcRequest[] $drcRequests
 * @property InstructorFiles[] $instructorFiles
 * @property Term $term
 *
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.models
 */
class Course extends BaseModel
{
	/**
	 * @var string (Non database atribute.)  Identifies optional user associated with the assignemt for the current action.
	 */
	public $username;
	
	/**
	 * @var string (Non database atribute.)  Identifies optional user associated with the assignemt for the current action.
	 */
	//public $emplid;
		
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
			array('title, schedule, room, dates', 'length', 'max'=>128),
			array('created, modified, username, emplid', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('term_code, class_num, section, course_id, subject, description, title, catalog_num, schedule, room, dates, created, modified', 'safe', 'on'=>'search'),
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
			'emailsSent' => array(self::HAS_MANY, 'EmailSent', 'term_code, class_num'),
			'term' => array(self::BELONGS_TO, 'Term', 'term_code'),
			'drcRequests' => array(self::HAS_MANY, 'DrcRequest', 'term_code, class_num'),
			'instructorFiles' => array(self::HAS_MANY, 'InstructorFiles', 'class_num'),
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
			'room' => 'Room',
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
		$criteria->compare('room',$this->room,true);
		$criteria->compare('dates',$this->dates,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Provides an active data provider to provide a list of courses based on the request parameters.
	 * @return CActiveDataProvider the data provider that can return the models based on the request parameters.
	 */
	public function courses()
	{
		$criteria=new CDbCriteria; 
		$criteria->compare('t.term_code',$this->term_code);
		if ($this->username && strlen($this->username)>0) {
			$criteria->with = array( 'drcRequests', 'drcRequests.user' );
			$criteria->together = true;
			$criteria->compare('user.username',$this->username);
			$criteria->compare('drcRequests.term_code',$this->term_code);
		}
		
		return new CActiveDataProvider('Course', array(
			'criteria'=>$criteria,
		 	'pagination' => false,
		));
	}

	/**
	 *Provides an active data provider to provide a list of assignments for this course based on the request parameters.
	 * @return CActiveDataProvider the data provider that can return the models based on the request parameters.
	 */
	public function assignments()
	{
		$criteria=new CDbCriteria;
		if ($this->username && strlen($this->username)>0) {  // comment out untill we have type data
			//$criteria->with = array( 'drcRequests',  'drcRequests.user');
			//$criteria->together = true;
			//$criteria->compare('user.username',$this->username);
		}
		$criteria->compare('t.term_code',$this->term_code);
		$criteria->compare('t.class_num',$this->class_num);
		$criteria->together = array( 'book', ); // might be needed
		
		return new CActiveDataProvider('Assignment', array(
			'criteria'=>$criteria,
		 	'pagination' => false,
		));
	}

	/**
	 * Retrieves a list of books for this course based on the current request parameters.
	 * @return CActiveDataProvider the data provider that can return the models based on the request parameters.
	 */
	public function books()
	{
		$criteria=new CDbCriteria;
		$criteria->addCondition("id IN (SELECT book_id FROM assignment WHERE term_code ='$this->term_code' AND class_num='$this->class_num')");          
		
		return new CActiveDataProvider('Book', array(
			'criteria'=>$criteria,
		 	'pagination' => false,
		));
	}
	
	
	/**
	 * Retrieves a data provider that can provide list of emails for this Course.
	 * @return CActiveDataProvider the data provider that can return a list of Email models.
	 */
	public function emails()
	{
		// create sql to retieve emails sent or available to be sent ot istructors for this course.
		$sql = "SELECT DISTINCT email.id, email.enabled, email.subject, email.message, email_type.name, email_type.sequence, email_type.tone, email_sent.term_code AS sent
			FROM email JOIN email_type ON (email.type = email_type.name) 
			LEFT JOIN email_sent ON (email_sent.email_id = email.id AND email_sent.term_code=$this->term_code AND email_sent.class_num=$this->class_num)
			WHERE email.enabled>0 OR email_sent.email_id>0 ORDER BY email_type.sequence ASC";
		
		return new CSqlDataProvider($sql, array(
		 	'pagination' => false,
		 	'keyField' => 'id',
		));
	}

	/**
	 * Retrieves a list of students for this course.
	 * @return CActiveDataProvider the data provider that can return the models based on the request parameters (Which identify the course.)
	 */
	public function students()
	{
		$criteria=new CDbCriteria;
		$criteria->with = array( 'drcRequests', 'drcRequests.course');
		$criteria->compare('drcRequests.term_code',$this->term_code);
		$criteria->compare('drcRequests.class_num',$this->class_num);
		
		return new CActiveDataProvider('DrcUser', array(
			'criteria'=>$criteria,
		 	'pagination' => false,
		));
	}

	/**
	 * Retrieves a list of faculty names.
	 * @return array, the names of faculty for this course.
	 */
	public function facultyNames()
	{
		//$names = '';
		$names = array();
		foreach($this->courseInstructors as $instructor)
		{
			$names[] = $instructor->instructor->first_name . ' ' . $instructor->instructor->last_name;
		}
		return $names;
	}
	
	/**
	 * Retrieves a list of urls for faculty pages.
	 * @return array, the names of faculty for this course.
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
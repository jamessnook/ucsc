<?php

/**
 * This is the model class for table "drc_request".
 *
 * The followings are the available columns in table 'drc_request':
 * @property integer $term_code
 * @property integer $class_num
 * @property string $course_id
 * @property string $emplid
 * @property string $type
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property Assignment[] $assignments
 * @property Course $termCode
 * @property Course $classNum
 * @property User $empl
 * @property FileType $type0
 */
class StudentCourses extends CModel
{
	/**
	 * @var CDbConnection the default database connection for all active record classes.
	 * By default, this is the 'db' application component.
	 * @see getDbConnection
	 */
	public static $db;
	
	// attributes:
	public $username='';  	// student  user name
	public $emplid='';  	// student  emplid
	public $class_num='';  	// course class Number
	public $term_code='';  	// course term code
	public $courseName='';  // course title
	public $classId='';  	// course classId
	public $faculty='';  	// list of faculty names for course
	public $asignmentCount='';  	// number of assignemtns for course
	public $is_complete='';  	// true if all assignments for course uploaded to and available for download
	
	/**
	 * Returns the list of attribute names of the model.
	 * @return array list of attribute names.
	 */
	 public function attributeNames(){
	 	//return array('courseName', 'classId', 'faculty', 'asignmentCount', 'completed');
	 	return array_keys(get_object_vars($this));
	 }

	/**
	 * Returns the database connection used by active record.
	 * By default, the "db" application component is used as the database connection.
	 * You may override this method if you want to use a different database connection.
	 * @return CDbConnection the database connection used by this model class.
	 */
	public function getDbConnection()
	{
		if(self::$db!==null)
			return self::$db;
		else
		{
			self::$db=Yii::app()->getDb();
			if(self::$db instanceof CDbConnection)
				return self::$db;
			else
				throw new CDbException(Yii::t('yii','DBModel requires a "db" CDbConnection application component.'));
		}
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'username' => 'Student User Name',
			'courseName' => 'Course Name',
			'classId' => 'Class Id',
			'faculty' => 'Faculty',
			'asignmentCount' => 'Asignments',
			'completed' => 'Completed',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public static function getAll()
	{
		$sql="SELECT title AS courseName,
			CONCAT(' ', subject, course_id, section) AS classId,
			GROUP_CONCAT( user.first_name || ' ' || user.last_name) AS faculty,
			COUNT(id) AS assignments, 
			MIN(is_complete) AS completed
			FROM user JOIN drc_request ON (user.emplid = drc_request.emplid 
			NATURAL JOIN assignment NATURAL JOIN course NATURAL JOIN course_instructor 
			JOIN user ON(course_instructor.emplid = user.emplid)
			GROUP BY user.username, term_code, class_num";
		
		return new CSqlDataProvider($sql);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public static function getFor($userName, $termCode)
	{
		$sql="SELECT title AS courseName,
			CONCAT(' ', subject, course_id, section) AS classId,
			GROUP_CONCAT( user.first_name || ' ' || user.last_name) AS faculty,
			COUNT(id) AS assignments, 
			MIN(is_complete) AS completed
			FROM user JOIN drc_request ON (user.emplid = drc_request.emplid 
			NATURAL JOIN assignment NATURAL JOIN course NATURAL JOIN course_instructor 
			JOIN user ON(course_instructor.emplid = user.emplid)
			WHERE user.username = $username AND term_code = $termCode
			GROUP BY class_num";
		
		return new CSqlDataProvider($sql);
	}

	/**
	 * Generates a where clausae using the attribute values of this object.
	 * @return Cstring the wed on the search/filter conditions.
	 */
	public function where()
	{
		$where = '';
		foreach(get_object_vars($this) AS $name=>$value){
			if($value && $value!==''){
				// might need to convert $name from camel code...
				$where .= $name . '=' . $value;
			}
		}
		if ($where !=='') $where = ' WHERE ' . $where;
		return $where;
	}

	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$where = '';
		$where =  'user.username = $this->username AND term_code = $this->termCode AND class_num = $this->classNum AND emplid = $this->emplid';
		
		$sql="SELECT title AS courseName,
			CONCAT(' ', subject, course_id, section) AS classId,
			GROUP_CONCAT( user.first_name || ' ' || user.last_name) AS faculty,
			COUNT(id) AS assignments, 
			MIN(is_complete) AS completed
			FROM user JOIN drc_request ON (user.emplid = drc_request.emplid 
			NATURAL JOIN assignment NATURAL JOIN course NATURAL JOIN course_instructor 
			JOIN user ON(course_instructor.emplid = user.emplid)"
			. $this->where() . "GROUP BY term_code, class_num";
		
		return new CSqlDataProvider($sql);
	}

	
}
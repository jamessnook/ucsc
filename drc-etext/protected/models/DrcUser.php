<?php

/**
 * This is the model class for table "user".
 *
 * Represents a single user, student, faculty, staff or admin, who has
 * an account to use the DRC application.
 *
 * The followings are the available columns in table 'user':
 * @property string $username
 * @property string $emplid
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $created
 * @property string $modified
 * @property string $password
 * @property string $salt
 * @property string $modified_by
 *
 * The followings are the available model relations:
 * @property AuthAssignment[] $authAssignments
 * @property Assignment[] $assignments
 * @property DrcRequest[] $drcRequests
 * @property Book[] $books
 * @property File[] $files
 * @property InstructorFiles[] $instructorFiles
 * @property CourseInstructor[] $coursesAsInstructor
 *
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.models
 */
class DrcUser extends User
{
	public $term_code; // for non emplid matches
	public $role;      // for authentication, to set user roles
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'authAssignments' => array(self::HAS_MANY,'AuthAssignment', 'userid, itemname'),
			'drcRequests' => array(self::HAS_MANY, 'DrcRequest', 'emplid'),
			'coursesAsInstructor' => array(self::HAS_MANY, 'CourseInstructor', 'emplid'),
			'assignments' => array(self::HAS_MANY, 'Assignment', 'modified_by'),
			'books' => array(self::MANY_MANY, 'Book', 'book_user(username, book_id)'),
			'files' => array(self::HAS_MANY, 'File', 'modified_by'),
			'instructorFiles' => array(self::HAS_MANY, 'InstructorFiles', 'emplId'),
		);
	}

	/**
	 * Retrieves a list of USER models for students with active DRC requests for the term identified by $this->term_code.
	 * @return CActiveDataProvider the data provider that can return the User models.
	 */
	public function students()
	{
		$criteria=new CDbCriteria;
		$criteria->with = array( 'drcRequests', 'drcRequests.course');
		$criteria->compare('drcRequests.term_code', $this->term_code);
		//$criteria->addCondition("AuthAssignment.userid=t.username");
		//$criteria->join = 'JOIN drcRequests USING (emplid)';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		 	'pagination' => false,
		));
	}

	
	/**
	 * Retrieves a list of course Models associated with the user and term defined by the current $this object.
	 * @return CActiveDataProvider the data provider that can return the Course models.
	 */
	public function courses()
	{
		$criteria=new CDbCriteria; 
		if (!isset($this->term_code)) {
			$this->term_code = Term::currentTermCode();
		}
		$criteria->compare('t.term_code',$this->term_code);
		if ($this->emplid && strlen($this->emplid)>0) {
			$criteria->with = array( 'drcRequests' );
			$criteria->together = true;
			$criteria->compare('drcRequests.emplid',$this->emplid);
			$criteria->compare('drcRequests.term_code',$this->term_code);
		}
		
		return new CActiveDataProvider('Course', array(
			'criteria'=>$criteria,
		 	'pagination' => false,
		));
	}

	
	/**
	 * Retrieves a data provider that can provide list of emails for this Course.
	 * @return CActiveDataProvider the data provider that can return a list of Email models.
	 */
	public function books()
	{
		// create sql to retieve emails sent or available to be sent ot istructors for this course.
		$sql = "SELECT DISTINCT user.username, book.id, book.title, book.author, course.title AS courseTitle, term.description AS term, book_user.purchased
			FROM drc_request JOIN assignment USING(term_code, class_num) 
			JOIN course USING(term_code, class_num)
			JOIN term USING(term_code)
			JOIN user USING(emplid)
			JOIN book  ON (book.id = assignment.book_id)  
			LEFT JOIN book_user USING (book_id, username) 
			WHERE drc_request.emplid='$this->emplid' AND drc_request.term_code = $this->term_code";
			//WHERE drc_request.emplid='$this->emplid'";
		
		return new CSqlDataProvider($sql, array(
		 	'pagination' => false,
		 	'keyField' => 'id',
		));
	}

	/**
	 * Returns the data model based on the passed attributes.
	 * Persues various ways of finding and creating the model
	 * Adds functionality to arent class method to insure term_code is set.
	 * @param array of parameters
	 * @return model instance of a UCSCModel subclass built using the url params.
	 */
	public static function loadModel($params=null)
	{
		$aModel = parent::loadModel($params);
		if (!$aModel->term_code){
			$aModel->term_code = Term::currentTermCode();
		}
		return $aModel;
	}
	
	/**
	 * Retrieves a list of course names for the courses associate with a users.
	 * @return array, the names of courses for this user.
	 */
	public function courseNames()
	{
		//$names = '';
		$names = array();
		foreach($this->drcRequests as $request)
		{
			if ($request->course){
				$names[] = $request->course->title;
			}
		}
		foreach($this->coursesAsInstructor as $instructedCourse)
		{
			if ($instructedCourse->course){
				$names[] = $instructedCourse->course->title;
			}
		}
		return $names;
	}
	
	/**
	 * Retrieves a list of course objects for the courses associate with a users.
	 * @return array, the names of courses for this user.
	 */
	public function courseList()
	{
		//$names = '';
		$courses = array();
		foreach($this->drcRequests as $request)
		{
			if ($request->course){
				$courses[] = $request->course;
			}
		}
		foreach($this->coursesAsInstructor as $instructedCourse)
		{
			if ($instructedCourse->course){
				$courses[] = $instructedCourse->course;
			}
		}
		return $courses;
	}
	
	/**
	 * Retrieves a list of course names for the courses associate with a users.
	 * @return string, the names of courses for this user.
	 */
	public function courseNamesString()
	{
		$names = '';
		foreach($this->drcRequests as $request)
		{
			if($names != ''){
				$names .= ', ';
			}
			$names .= $request->course->title;
		}
		foreach($this->coursesAsInstructor as $instructedCourse)
		{
			if($names != ''){
				$names .= ', ';
			}
			$names .= $instructedCourse->course->title;
		}
		return $names;
	}
	
	/**
	 * Returns true if all assignemtns for this course are complete.
	 * @return boolean, true if all assignemtns for this course are complete.
	 */
	public function drcRequestsCompleted()
	{
		foreach($this->drcRequests as $request)
		{
			if ($request->course){
				foreach($request->course->assignments as $assignment){
					if (!$assignment->is_complete) return false;
				}
			}
		}
		return true;
	}
	
	/**
	 * Retrieves an array of file types needed for this user.
	 * @return array, the names of file types for this course.
	 */
	public function types()
	{
		$types = array();
		foreach($this->drcRequests as $request)
		{
			$types[$request->type] = $request->type; // use value as key to prevent duplicates
		}
		return $types;
	}
	
	/**
	 * Retrieves an array of file types needed for this assignment.
	 * @return array, the names of file types for this course.
	 */
	public function typesString()
	{
		$types = '';
		foreach($this->drcRequests as $request)
		{
			if($types != ''){
				$types .= ', ';
			}
			$types .= $request->type; // use value as key to prevent duplicates
		}
		return $types;
	}
	
	
}
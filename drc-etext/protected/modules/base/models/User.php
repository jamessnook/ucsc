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
class User extends BaseModel
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
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('username', 'required'),
			array('username, emplid, first_name, middle_name, last_name, modified_by', 'length', 'max'=>64),
			array('email, password, salt', 'length', 'max'=>128),
			array('phone', 'length', 'max'=>32),
			array('created, modified, term_code', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('username, emplid, first_name, middle_name, last_name, email, phone, created, modified, password, salt, modified_by', 'safe', 'on'=>'search'),
			array('username, emplid, first_name, middle_name, last_name, email, phone, created, modified, password, salt, modified_by, term_code, role', 'safe'),
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
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'username' => 'Username',
			'emplid' => 'Emplid',
			'first_name' => 'First Name',
			'middle_name' => 'Middle Name',
			'last_name' => 'Last Name',
			'email' => 'Email',
			'phone' => 'Phone',
			'created' => 'Created',
			'modified' => 'Modified',
			'password' => 'Password',
			'salt' => 'Salt',
			'modified_by' => 'Modified By',
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

		$criteria->compare('username',$this->username,true);
		$criteria->compare('emplid',$this->emplid,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('middle_name',$this->middle_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('modified_by',$this->modified_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
	 * Retrieves a list of USER models for faculty with active DRC requests for their courses in the term identified by $this->term_code.
	 * Note: Temporarily does not filter by term because our test data does not include it yet
	 * @return CActiveDataProvider the data provider that can return the User models.
	 */
	public function faculty()  
	{
		$criteria=new CDbCriteria;
		// temporary coment out so gets all faculty for demo....
		// need to add term code criteria once we have real data
		//$criteria->with = array( 'drcRequests', 'drcRequests.course');
		//$criteria->compare('drcRequests.term_code',$this->term_code);
		$criteria->join = "JOIN AuthAssignment ON (username=userid)";
		$criteria->addCondition("AuthAssignment.userid=t.username");
		$criteria->addCondition("(AuthAssignment.itemname='faculty')");          
				
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		 	'pagination' => false,
		));
	}

	
	/**
	 * Retrieves a list of USER models for staff with active DRC staff or admin accounts.
	 * @return CActiveDataProvider the data provider that can return the User models.
	 */
	public function staff()
	{
		$criteria=new CDbCriteria;
		//$criteria->with = array( 'authAssignments');
		$criteria->join = "JOIN AuthAssignment ON (username=userid)";
		$criteria->addCondition("AuthAssignment.userid=t.username");
		$criteria->addCondition("(AuthAssignment.itemname='staff' OR AuthAssignment.itemname='admin')");          
		
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
	 * Retrieves a list of book Models associated with the user and term defined by the current $this object.
	 * @return CActiveDataProvider the data provider that can return the Course models.
	 */
	public function xbooks()
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
		
		return new CActiveDataProvider('Book', array(
			'criteria'=>$criteria,
		 	'pagination' => false,
		));
	}
	
	/**
	 * Retrieves a list of books for this course based on the current request parameters.
	 * @return CActiveDataProvider the data provider that can return the models based on the request parameters.
	 */
	public function xxbooks()
	{
		$criteria=new CDbCriteria;
		$criteria->addCondition("id IN (SELECT book_id FROM bookUser WHERE term_code ='$this->term_code' AND class_num='$this->class_num')");          
		
		return new CActiveDataProvider('Book', array(
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
	 * Overrides parent to assign non input values.
	 * @return boolean whether the saving should be executed. Defaults to true.
	 */
	public function afterSave(){
		$now = date('Y-m-d H:i:s');
    	if (isset($this->role)){
	        // remove existing roles for user
	        // assumes we allow only one role per user
        	$userRoles = Yii::app()->authManager->getRoles($this->username);
        	foreach ($userRoles as $name => $authItem){
        		Yii::app()->authManager->revoke($name, $this->username);
        	}
            // Assign the role to the user 
            Yii::app()->authManager->assign($this->role, $this->username);
    	}
		return parent::afterSave();
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
	 * Retrieves a list of authentication roles assigned to the user defined by $this object.
	 * @return array, the roles for this user.
	 */
	public function getRoles()
	{
		$roles = array();
		$items = Yii::app()->authManager->getRoles($this->username);
		foreach($items as $name=>$item){
			$roles[]=$name;
		}
		return $roles;
	}
	
	/**
	 * Retrieves a URl to call the update action for this user.
	 * @return string, the url for the update action this user.
	 */
	public function getUrl()
	{
		return Yii::app()->createUrl('user/update', array('username'=>$this->username));
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
<?php

/**
 * This is the model class for table "user".
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
 * @property AuthItem[] $authItems
 * @property Assignment[] $assignments
 * @property Book[] $books
 * @property File[] $files
 * @property InstructorFiles[] $instructorFiles
 */
class User extends UCSCModel
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
			//'authItems' => array(self::MANY_MANY, 'AuthItem', 'AuthAssignment(userid, itemname)'),
			'authAssignments' => array(self::HAS_MANY,'AuthAssignment', 'userid, itemname'),
			//'drcRequests' => array(self::HAS_MANY, 'DrcRequest', 'emplid', 'joinType' => 'INNER JOIN'),
			'drcRequests' => array(self::HAS_MANY, 'DrcRequest', 'emplid'),
			'assignments' => array(self::HAS_MANY, 'Assignment', 'modified_by'),
			'books' => array(self::MANY_MANY, 'Book', 'book_purchase(username, book_id)'),
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
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function students()
	{
		$criteria=new CDbCriteria;
		$criteria->with = array( 'drcRequests', 'drcRequests.course');
		$criteria->compare('drcRequests.term_code',$this->term_code);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		 	'pagination' => false,
		));
	}

	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function faculty()
	{
		$criteria=new CDbCriteria;
		//$criteria->with = array( 'authAssignments');
		$criteria->join = "JOIN AuthAssignment ON (username=userid)";
		$criteria->addCondition("AuthAssignment.userid=t.username");
		$criteria->addCondition("(AuthAssignment.itemname='faculty')");          
				
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		 	'pagination' => false,
		));
	}

	
		/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
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
	 * Retrieves a list of courses based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function courses()
	{
		$criteria=new CDbCriteria; 
		$criteria->compare('t.term_code',$this->term_code);
		//$criteria->compare('emplid',$this->emplid);
		//$criteria->compare('username',$this->username);
		if ($this->emplid && strlen($this->emplid)>0) {
			$criteria->with = array( 'drcRequests' );
			$criteria->together = true;
			
			//$criteria->together = array( 'drcRequests', 'assignmentTypes' ); // might be needed
			$criteria->compare('drcRequests.emplid',$this->emplid);
			$criteria->compare('drcRequests.term_code',$this->term_code);
			//$criteria->addCondition("drcRequests.username = $username");         
			//$criteria->addCondition("assignmentTypes.type = drcRequests.type");          
		}
		//if ($this->term_code && $this->term_code>0) {
		//	$criteria->compare('term_code',$this->term_code);
		//}
		
		return new CActiveDataProvider('Course', array(
			'criteria'=>$criteria,
		 	'pagination' => false,
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
	 * Retrieves a list of course names for the courses associate with a users drc requests.
	 * @return string, the names of faculty for this course.
	 */
	public function drcRequestCourseNames()
	{
		//$names = '';
		$names = array();
		foreach($this->drcRequests as $request)
		{
			$names[] = $request->course->title;
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
			foreach($request->course->assignments as $assignment){
				if (!$assignment->is_complete) return false;
			}
		}
		return true;
	}
	
	/**
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
	 */
	public function getUrl()
	{
		return Yii::app()->createUrl('user/update', array('username'=>$this->username));
	} 
		
}
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
class AscorgaUser extends User
{
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
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name, role', 'required'),
			array('username, emplid, first_name, middle_name, last_name, modified_by', 'length', 'max'=>64),
			array('email, password, salt', 'length', 'max'=>128),
			array('phone', 'length', 'max'=>32),
			array('created, modified, term_code', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('username, emplid, first_name, middle_name, last_name, email, phone, created, modified, password, salt, modified_by', 'safe', 'on'=>'search'),
			array('username, emplid, first_name, middle_name, last_name, email, phone, isCurrent, 
				eff_date, division, department, title, div_data_id, created, modified, password, salt, modified_by, term_code, role', 'safe'),
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
			'emplid' => 'Emplid',
			'div_data_id' => 'Div Data Id',
			'middle_name' => 'Middle Name',
			'last_name' => 'Last Name',
			'email' => 'Email',
			'phone' => 'Phone',
			'isCurrent' => 'Is Current',
			'created' => 'Created',
			'eff_date' => 'Effective Date',
			'title' => 'Title',
			'division' => 'Division',
			'division' => 'Division',
			'department' => 'Department',
			'password' => 'Password',
			'salt' => 'Salt',
			'modified_by' => 'Modified By',
			'role' => 'Role',
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

}
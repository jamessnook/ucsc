<?php

/**
 * This is the model class for table "service_request".
 *
 * The followings are the available columns in table 'service_request':
 * @property integer $id
 * @property string $term_id
 * @property string $class_id
 * @property string $course
 * @property string $section
 * @property integer $course_id
 * @property integer $session_code
 * @property string $course_name
 * @property string $subject
 * @property string $catalog_nbr
 * @property string $instructor_id
 * @property string $student_id
 * @property string $username
 * @property string $type
 * @property string $type_name
 *
 * The followings are the available model relations:
 * @property User $username0
 */
class ServiceRequest extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ServiceRequest the static model class
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
		return 'service_request';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('term_id, class_id, section, instructor_id', 'required'),
			array('course_id, session_code', 'numerical', 'integerOnly'=>true),
			array('term_id, class_id, course, section, instructor_id, type, type_name', 'length', 'max'=>32),
			array('course_name, subject, catalog_nbr, student_id, username', 'length', 'max'=>64),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, term_id, class_id, course, section, course_id, session_code, course_name, subject, catalog_nbr, instructor_id, student_id, username, type, type_name', 'safe', 'on'=>'search'),
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
			'username0' => array(self::BELONGS_TO, 'User', 'username'),
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
			'course' => 'Course',
			'section' => 'Section',
			'course_id' => 'Course',
			'session_code' => 'Session Code',
			'course_name' => 'Course Name',
			'subject' => 'Subject',
			'catalog_nbr' => 'Catalog Nbr',
			'instructor_id' => 'Instructor',
			'student_id' => 'Student',
			'username' => 'Username',
			'type' => 'Type',
			'type_name' => 'Type Name',
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
		$criteria->compare('course',$this->course,true);
		$criteria->compare('section',$this->section,true);
		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('session_code',$this->session_code);
		$criteria->compare('course_name',$this->course_name,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('catalog_nbr',$this->catalog_nbr,true);
		$criteria->compare('instructor_id',$this->instructor_id,true);
		$criteria->compare('student_id',$this->student_id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('type_name',$this->type_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Override standard implementation to also create and save new users if defined.
	 */
	protected function afterSave()
	{
		if (isset($this->username)){
	        $user=User::model()->find('LOWER(username)=?',array($this->username));
	        // if user not found create a new one
	        if($user===null){
				$user = new User();
				$user->username = $this->username;
				$user->save();
                // Assign student role to the user
                Yii::app()->authManager->assign('student', $this->username);
	        }
		}
		
		 parent::afterSave();
		
	}
}
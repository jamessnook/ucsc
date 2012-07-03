<?php

/**
 * This is the model class for table "service_request".
 *
 * The followings are the available columns in table 'service_request':
 * @property integer $id
 * @property string $term_id
 * @property integer $class_number
 * @property string $class_section
 * @property string $session_code
 * @property integer $course_offer_number
 * @property string $course_id
 * @property string $course_name
 * @property string $subject
 * @property string $catalog_nbr
 * @property string $instructor_id
 * @property string $instructor_cruzid
 * @property string $student_id
 * @property string $username
 * @property string $accommodation_type
 * @property string $type_name
 * @property string $effective_date
 * @property string $created
 * @property string $last_changed
 * @property string $last_changed_by
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
			array('term_id', 'required'),
			array('class_number, course_offer_number', 'numerical', 'integerOnly'=>true),
			array('term_id, class_section, session_code, course_id, instructor_id, instructor_cruzid, accommodation_type, type_name, last_changed_by', 'length', 'max'=>32),
			array('course_name, subject, catalog_nbr, student_id, username', 'length', 'max'=>64),
			array('effective_date, created, last_changed', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, term_id, class_number, class_section, session_code, course_offer_number, course_id, course_name, subject, catalog_nbr, instructor_id, instructor_cruzid, student_id, username, accommodation_type, type_name, effective_date, created, last_changed, last_changed_by', 'safe', 'on'=>'search'),
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
			'class_number' => 'Class Number',
			'class_section' => 'Class Section',
			'session_code' => 'Session Code',
			'course_offer_number' => 'Course Offer Number',
			'course_id' => 'Course',
			'course_name' => 'Course Name',
			'subject' => 'Subject',
			'catalog_nbr' => 'Catalog Nbr',
			'instructor_id' => 'Instructor',
			'instructor_cruzid' => 'Instructor Cruzid',
			'student_id' => 'Student',
			'username' => 'Username',
			'accommodation_type' => 'Accommodation Type',
			'type_name' => 'Type Name',
			'effective_date' => 'Effective Date',
			'created' => 'Created',
			'last_changed' => 'Last Changed',
			'last_changed_by' => 'Last Changed By',
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
		$criteria->compare('class_number',$this->class_number);
		$criteria->compare('class_section',$this->class_section,true);
		$criteria->compare('session_code',$this->session_code,true);
		$criteria->compare('course_offer_number',$this->course_offer_number);
		$criteria->compare('course_id',$this->course_id,true);
		$criteria->compare('course_name',$this->course_name,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('catalog_nbr',$this->catalog_nbr,true);
		$criteria->compare('instructor_id',$this->instructor_id,true);
		$criteria->compare('instructor_cruzid',$this->instructor_cruzid,true);
		$criteria->compare('student_id',$this->student_id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('accommodation_type',$this->accommodation_type,true);
		$criteria->compare('type_name',$this->type_name,true);
		$criteria->compare('effective_date',$this->effective_date,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('last_changed',$this->last_changed,true);
		$criteria->compare('last_changed_by',$this->last_changed_by,true);

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
	
	/**
	 * get a name string built up from other values (for drop downs).
	 */
	public function getName()
    {
    	return $this->course_name.', '.$this->type_name;
    }
}
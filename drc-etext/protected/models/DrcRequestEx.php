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
class DrcRequestEx extends DrcRequest
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DrcRequest the static model class
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
		return 'drc_request';
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
			array('course_id, emplid, type', 'length', 'max'=>32),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('term_code, class_num, course_id, emplid, type, created, modified', 'safe', 'on'=>'search'),
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
			'assignments' => array(self::MANY_MANY, 'Assignment', 'assignment_type(accommodation_type, assignment_id)'),
			'termCode' => array(self::BELONGS_TO, 'Course', 'term_code'),
			'course' => array(self::BELONGS_TO, 'Course', 'class_num, term_code'),
			'empl' => array(self::BELONGS_TO, 'User', 'emplid'),
			'type0' => array(self::BELONGS_TO, 'FileType', 'type'),
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
			'course_id' => 'Course',
			'emplid' => 'Emplid',
			'type' => 'Type',
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
		$criteria->compare('course_id',$this->course_id,true);
		$criteria->compare('emplid',$this->emplid,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchEx()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		// needed columns
		// courseName: $data->course->title
		// classId: $data->course->subject.\' \'.$data->course->course_id.\' \'.$data->course->section',
		// faculty:  $data->course->courseInstructors

		$criteria=new CDbCriteria;

		$criteria->compare('term_code',$this->term_code);
		$criteria->compare('class_num',$this->class_num);
		$criteria->compare('course_id',$this->course_id,true);
		$criteria->compare('emplid',$this->emplid,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function studentCourses()
	{
		// for student's course list
		// SELECT title AS courseName,
		// CONCAT(" ", subject, course_id, section) AS classId,
		// GROUP_CONCAT( user.first_name || ' ' || user.last_name) AS faculty,
		// COUNT(id) AS assignments, 
		// MIN(is_complete) AS completed
		// FROM user JOIN drc_request ON (user.emplid = drc_request.emplid 
		// NATURAL JOIN assignment NATURAL JOIN course NATURAL JOIN course_instructor 
		// JOIN user ON(course_instructor.emplid = user.emplid)
		// WHERE user.username = $username
		// GROUP BY term_code, class_num
	}
		
	
}
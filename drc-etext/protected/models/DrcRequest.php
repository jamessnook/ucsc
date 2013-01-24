<?php

/**
 * This is the model class for table "drc_request".
 *
 * Represents a DRC request for alternate text for a student and a course.
 * Associates a student with a course and the type of alternate text they need.
 * This is supplied by the data feed from AIS.
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
 * @property Term $term
 * @property Course $course
 * @property User $user
 * @property FileType $type0
 *
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.models
 */
class DrcRequest extends CActiveRecord
{
	public $username; // for non emplid matches
	
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
			array('created, modified, username', 'safe'),
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
			'assignments' => array(self::HAS_MANY, 'Assignment', 'term_code, class_num'),
			'term' => array(self::BELONGS_TO, 'Term', 'term_code'),
			'course' => array(self::BELONGS_TO, 'Course', 'term_code, class_num'),
			'user' => array(self::BELONGS_TO, 'User', 'emplid'),
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
		$criteria=new CDbCriteria;

		$criteria->with=array('user',);
		//$criteria->with('users');
		$criteria->compare('term_code',$this->term_code);
		//$criteria->compare('class_num',$this->class_num);
		//$criteria->compare('course_id',$this->course_id,true);
		//$criteria->compare('emplid',$this->emplid,true);
		//$criteria->compare('type',$this->type,true);
		//$criteria->compare('user.username',$this->username);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		 	'pagination' => false,
		));
	}
	
}
<?php

/**
 * This is the model class for table "email_sent".
 *
 * Records when an email has been sent to teh instructors of a course.
 * Associates the email with the course.
 * 
 * The followings are the available columns in table 'email_sent':
 * @property integer $email_id
 * @property string $username
 * @property integer $term_code
 * @property integer $class_num
 * @property string $created
 * @property string $modified
 * @property string $modified_by
 *
 * The followings are the available model relations:
 * @property User $modifiedBy
 * @property Term $termCode
 * @property Course $classNum
 * @property Email $email
 * @property User $username0
 *
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.models
 */
class EmailSent extends BaseModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EmailSent the static model class
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
		return 'email_sent';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email_id, term_code', 'required'),
			array('email_id, term_code, class_num', 'numerical', 'integerOnly'=>true),
			array('username, modified_by', 'length', 'max'=>64),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('email_id, username, term_code, class_num, created, modified, modified_by', 'safe', 'on'=>'search'),
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
			'modifiedBy' => array(self::BELONGS_TO, 'User', 'modified_by'),
			'termCode' => array(self::BELONGS_TO, 'Term', 'term_code'),
			'classNum' => array(self::BELONGS_TO, 'Course', 'class_num'),
			'email' => array(self::BELONGS_TO, 'Email', 'email_id'),
			'username0' => array(self::BELONGS_TO, 'User', 'username'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'email_id' => 'Email',
			'username' => 'Username',
			'term_code' => 'Term Code',
			'class_num' => 'Class Num',
			'created' => 'Created',
			'modified' => 'Modified',
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

		$criteria->compare('email_id',$this->email_id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('term_code',$this->term_code);
		$criteria->compare('class_num',$this->class_num);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('modified_by',$this->modified_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
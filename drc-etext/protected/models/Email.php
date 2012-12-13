<?php

/**
 * This is the model class for table "email".
 *
 * Represents an email message which has been sent or is available to be sent to th einstructors of a course.

 * The followings are the available columns in table 'email':
 * @property integer $id
 * @property string $message
 * @property string $subject
 * @property string $created
 * @property string $modified
 * @property string $modified_by
 *
 * The followings are the available model relations:
 * @property User $modifiedBy
 * @property EmailSent[] $emailSents
 *
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.models
 */
class Email extends UCSCModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Email the static model class
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
		return 'email';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('message', 'length', 'max'=>1000),
			array('subject', 'length', 'max'=>250),
			array('modified_by, type', 'length', 'max'=>64),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, message, subject, created, modified, modified_by', 'safe', 'on'=>'search'),
			array('id, message, subject, type, enabled, created, modified, modified_by', 'safe'),
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
			'type' => array(self::BELONGS_TO, 'EmailType', 'type'),
			'emailSents' => array(self::HAS_MANY, 'EmailSent', 'email_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'message' => 'Message',
			'subject' => 'Subject',
			'type' => 'Type',
			'enabled' => 'Enabled',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('modified_by',$this->modified_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
<?php

/**
 * This is the model class for table "drc_request".
 *
 * The followings are the available columns in table 'drc_request':
 * @property integer $id
 * @property integer $term_code
 * @property integer $class_number
 * @property string $emplId
 * @property string $username
 * @property string $accommodation_type
 * @property string $effective_date
 * @property string $created
 *
 * The followings are the available model relations:
 * @property Assignment[] $assignments
 * @property User $username0
 */
class DrcRequest extends CActiveRecord
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
			array('term_code, class_number', 'numerical', 'integerOnly'=>true),
			array('emplId, accommodation_type', 'length', 'max'=>32),
			array('username', 'length', 'max'=>64),
			array('effective_date, created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, term_code, class_number, emplId, username, accommodation_type, effective_date, created', 'safe', 'on'=>'search'),
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
			'term_code' => 'Term Code',
			'class_number' => 'Class Number',
			'emplId' => 'Empl',
			'username' => 'Username',
			'accommodation_type' => 'Accommodation Type',
			'effective_date' => 'Effective Date',
			'created' => 'Created',
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
		$criteria->compare('term_code',$this->term_code);
		$criteria->compare('class_number',$this->class_number);
		$criteria->compare('emplId',$this->emplId,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('accommodation_type',$this->accommodation_type,true);
		$criteria->compare('effective_date',$this->effective_date,true);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
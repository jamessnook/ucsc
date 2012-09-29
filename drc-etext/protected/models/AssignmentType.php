<?php

/**
 * This is the model class for table "assignment_type".
 *
 * The followings are the available columns in table 'assignment_type':
 * @property integer $assignment_id
 * @property string $accommodation_type
 * @property boolean $is_complete
 */
class AssignmentType extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AssignmentType the static model class
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
		return 'assignment_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('assignment_id', 'numerical', 'integerOnly'=>true),
			array('accommodation_type', 'length', 'max'=>32),
			array('is_complete', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('assignment_id, accommodation_type, is_complete', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'assignment_id' => 'Assignment',
			'accommodation_type' => 'Accommodation Type',
			'is_complete' => 'Is Complete',
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

		$criteria->compare('assignment_id',$this->assignment_id);
		$criteria->compare('accommodation_type',$this->accommodation_type,true);
		$criteria->compare('is_complete',$this->is_complete);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
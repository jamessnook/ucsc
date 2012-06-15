<?php

/**
 * This is the model class for table "term".
 *
 * The followings are the available columns in table 'term':
 * @property integer $id
 * @property string $name
 * @property string $quarter
 * @property integer $year
 * @property string $begin_date
 * @property string $end_date
 *
 * The followings are the available model relations:
 * @property Section[] $sections
 */
class Term extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Term the static model class
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
		return 'term';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('year', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>512),
			array('quarter', 'length', 'max'=>128),
			array('begin_date, end_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, quarter, year, begin_date, end_date', 'safe', 'on'=>'search'),
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
			'sections' => array(self::HAS_MANY, 'Section', 'term_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'quarter' => 'Quarter',
			'year' => 'Year',
			'begin_date' => 'Begin Date',
			'end_date' => 'End Date',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('quarter',$this->quarter,true);
		$criteria->compare('year',$this->year);
		$criteria->compare('begin_date',$this->begin_date,true);
		$criteria->compare('end_date',$this->end_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
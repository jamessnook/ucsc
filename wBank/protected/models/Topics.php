<?php

/**
 * This is the model class for table "topics".
 *
 * The followings are the available columns in table 'topics':
 * @property string $id
 * @property string $topic
 * @property string $lower
 * @property integer $typeId
 * @property integer $inSubjectMap
 * @property integer $inPageMap
 * @property integer $inUse
 */
class Topics extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Topics the static model class
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
		return 'topics';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('topic', 'required'),
			array('typeId, inSubjectMap, inPageMap, inUse', 'numerical', 'integerOnly'=>true),
			array('topic, lower', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, topic, lower, typeId, inSubjectMap, inPageMap, inUse', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'topic' => 'Topic',
			'lower' => 'Lower',
			'typeId' => 'Type',
			'inSubjectMap' => 'In Subject Map',
			'inPageMap' => 'In Page Map',
			'inUse' => 'In Use',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('topic',$this->topic,true);
		$criteria->compare('lower',$this->lower,true);
		$criteria->compare('typeId',$this->typeId);
		$criteria->compare('inSubjectMap',$this->inSubjectMap);
		$criteria->compare('inPageMap',$this->inPageMap);
		$criteria->compare('inUse',$this->inUse);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
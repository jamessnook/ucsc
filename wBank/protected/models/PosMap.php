<?php

/**
 * This is the model class for table "posMap".
 *
 * The followings are the available columns in table 'posMap':
 * @property string $pos
 * @property string $name
 * @property string $wordNetPos
 * @property integer $ClassNum
 * @property string $Class
 */
class PosMap extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PosMap the static model class
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
		return 'posMap';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ClassNum', 'required'),
			array('ClassNum', 'numerical', 'integerOnly'=>true),
			array('pos, wordNetPos, Class', 'length', 'max'=>32),
			array('name', 'length', 'max'=>120),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pos, name, wordNetPos, ClassNum, Class', 'safe', 'on'=>'search'),
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
			'pos' => 'Pos',
			'name' => 'Name',
			'wordNetPos' => 'Word Net Pos',
			'ClassNum' => 'Class Num',
			'Class' => 'Class',
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

		$criteria->compare('pos',$this->pos,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('wordNetPos',$this->wordNetPos,true);
		$criteria->compare('ClassNum',$this->ClassNum);
		$criteria->compare('Class',$this->Class,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
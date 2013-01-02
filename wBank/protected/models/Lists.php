<?php

/**
 * This is the model class for table "lists".
 *
 * The followings are the available columns in table 'lists':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $username
 * @property integer $type
 * @property integer $groupId
 *
 * The followings are the available model relations:
 * @property Words[] $words
 */
class Lists extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Lists the static model class
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
		return 'lists';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, groupId', 'numerical', 'integerOnly'=>true),
			array('name, description', 'length', 'max'=>127),
			array('username', 'length', 'max'=>63),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, username, type, groupId', 'safe', 'on'=>'search'),
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
			'words' => array(self::MANY_MANY, 'Words', 'wordlist(lsitId, wordId)'),
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
			'description' => 'Description',
			'username' => 'Username',
			'type' => 'Type',
			'groupId' => 'Group',
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('groupId',$this->groupId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
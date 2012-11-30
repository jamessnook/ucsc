<?php

/**
 * This is the model class for table "book".
 *
 * The followings are the available columns in table 'book':
 * @property integer $id
 * @property integer $global_id
 * @property string $id_type
 * @property string $title
 * @property string $author
 * @property string $edition
 *
 * The followings are the available model relations:
 * @property IdType $idType
 * @property User[] $users
 */
class Book extends UCSCModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Book the static model class
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
		return 'book';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('global_id, id_type, title', 'required'),
			array('global_id', 'numerical', 'integerOnly'=>true),
			array('year', 'numerical', 'integerOnly'=>true),
			array('id_type', 'length', 'max'=>32),
			array('title', 'length', 'max'=>512),
			array('author, publisher, edition', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, global_id, id_type, title, author, publisher, edition, year', 'safe', 'on'=>'search'),
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
			'idType' => array(self::BELONGS_TO, 'IdType', 'id_type'),
			'users' => array(self::MANY_MANY, 'User', 'book_purchase(book_id, username)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'global_id' => 'Book Number',
			'id_type' => 'Book Number Type',
			'title' => 'Title',
			'author' => 'Author',
			'publisher' => 'Publisher',
			'edition' => 'Edition',
			'year' => 'Year',
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
		$criteria->compare('global_id',$this->global_id);
		$criteria->compare('id_type',$this->id_type,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('edition',$this->edition,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
	
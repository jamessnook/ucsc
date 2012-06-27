<?php

/**
 * This is the model class for table "book_request".
 *
 * The followings are the available columns in table 'book_request':
 * @property integer $id
 * @property integer $request_id
 * @property string $username
 * @property integer $book_id
 * @property integer $global_id
 * @property string $id_type
 * @property string $title
 * @property string $author
 * @property string $edition
 * @property string $notes
 *
 * The followings are the available model relations:
 * @property Book $idType
 * @property Book $global
 * @property Book $book
 * @property Request $request
 */
class BookRequest extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BookRequest the static model class
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
		return 'book_request';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('request_id, book_id, global_id', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>64),
			array('id_type', 'length', 'max'=>32),
			array('title', 'length', 'max'=>512),
			array('author, edition', 'length', 'max'=>128),
			array('notes', 'length', 'max'=>1024),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, request_id, username, book_id, global_id, id_type, title, author, edition, notes', 'safe', 'on'=>'search'),
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
			'idType' => array(self::BELONGS_TO, 'Book', 'id_type'),
			'global' => array(self::BELONGS_TO, 'Book', 'global_id'),
			'book' => array(self::BELONGS_TO, 'Book', 'book_id'),
			'request' => array(self::BELONGS_TO, 'Request', 'request_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'request_id' => 'Request',
			'username' => 'Username',
			'book_id' => 'Book',
			'global_id' => 'Global',
			'id_type' => 'Id Type',
			'title' => 'Title',
			'author' => 'Author',
			'edition' => 'Edition',
			'notes' => 'Notes',
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
		$criteria->compare('request_id',$this->request_id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('book_id',$this->book_id);
		$criteria->compare('global_id',$this->global_id);
		$criteria->compare('id_type',$this->id_type,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('edition',$this->edition,true);
		$criteria->compare('notes',$this->notes,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
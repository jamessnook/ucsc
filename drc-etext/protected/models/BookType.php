<?php

/**
 * This is the model class for table "book_type".
 *
 * The followings are the available columns in table 'book_type':
 * @property integer $book_id
 * @property string $type_id
 * @property boolean $is_complete
 * @property boolean $is_viewable
 */
class BookType extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BookType the static model class
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
		return 'book_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('book_id', 'required'),
			array('book_id', 'numerical', 'integerOnly'=>true),
			array('type_id', 'length', 'max'=>16),
			array('is_complete, is_viewable', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('book_id, type_id, is_complete, is_viewable', 'safe', 'on'=>'search'),
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
			'book_id' => 'Book',
			'type_id' => 'Type',
			'is_complete' => 'Is Complete',
			'is_viewable' => 'Is Viewable',
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

		$criteria->compare('book_id',$this->book_id);
		$criteria->compare('type_id',$this->type_id,true);
		$criteria->compare('is_complete',$this->is_complete);
		$criteria->compare('is_viewable',$this->is_viewable);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
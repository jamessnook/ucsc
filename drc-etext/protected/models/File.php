<?php

/**
 * This is the model class for table "file".
 *
 * The followings are the available columns in table 'file':
 * @property integer $id
 * @property string $name
 * @property string $path
 * @property string $caption
 * @property integer $text_id
 * @property integer $format_id
 * @property integer $type_id
 * @property integer $order_num
 * @property integer $pages
 * @property string $post_date
 * @property string $voice
 * @property string $speed
 * @property string $source
 * @property string $notes
 *
 * The followings are the available model relations:
 * @property Format $format
 * @property FileType $type
 * @property Text $text
 */
class File extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return File the static model class
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
		return 'file';
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
			array('text_id, format_id, type_id, order_num, pages', 'numerical', 'integerOnly'=>true),
			array('name, voice, speed, source', 'length', 'max'=>128),
			array('path', 'length', 'max'=>256),
			array('caption', 'length', 'max'=>512),
			array('notes', 'length', 'max'=>1000),
			array('post_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, path, caption, text_id, format_id, type_id, order_num, pages, post_date, voice, speed, source, notes', 'safe', 'on'=>'search'),
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
			'format' => array(self::BELONGS_TO, 'Format', 'format_id'),
			'type' => array(self::BELONGS_TO, 'FileType', 'type_id'),
			'text' => array(self::BELONGS_TO, 'Text', 'text_id'),
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
			'path' => 'Path',
			'caption' => 'Caption',
			'text_id' => 'Text',
			'format_id' => 'Format',
			'type_id' => 'Type',
			'order_num' => 'Order Num',
			'pages' => 'Pages',
			'post_date' => 'Post Date',
			'voice' => 'Voice',
			'speed' => 'Speed',
			'source' => 'Source',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('caption',$this->caption,true);
		$criteria->compare('text_id',$this->text_id);
		$criteria->compare('format_id',$this->format_id);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('order_num',$this->order_num);
		$criteria->compare('pages',$this->pages);
		$criteria->compare('post_date',$this->post_date,true);
		$criteria->compare('voice',$this->voice,true);
		$criteria->compare('speed',$this->speed,true);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('notes',$this->notes,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
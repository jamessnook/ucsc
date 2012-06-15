<?php

/**
 * This is the model class for table "section".
 *
 * The followings are the available columns in table 'section':
 * @property string $id
 * @property integer $course_id
 * @property integer $term_id
 * @property string $instructor_id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property Term $term
 * @property Course $course
 * @property Text[] $texts
 */
class Section extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Section the static model class
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
		return 'section';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, course_id, term_id, name', 'required'),
			array('course_id, term_id', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>32),
			array('instructor_id', 'length', 'max'=>64),
			array('name', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, course_id, term_id, instructor_id, name', 'safe', 'on'=>'search'),
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
			'term' => array(self::BELONGS_TO, 'Term', 'term_id'),
			'course' => array(self::BELONGS_TO, 'Course', 'course_id'),
			'texts' => array(self::MANY_MANY, 'Text', 'section_text(section_id, text_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'course_id' => 'Course',
			'term_id' => 'Term',
			'instructor_id' => 'Instructor',
			'name' => 'Name',
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
		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('term_id',$this->term_id);
		$criteria->compare('instructor_id',$this->instructor_id,true);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
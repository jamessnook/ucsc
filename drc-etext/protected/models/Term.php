<?php

/**
 * This is the model class for table "term".
 *
 * The followings are the available columns in table 'term':
 * @property string $term_code
 * @property string $description
 * @property string $start_date
 * @property string $end_date
 *
 * The followings are the available model relations:
 * @property Assignment[] $assignments
 * @property Course[] $courses
 * @property InstructorFiles[] $instructorFiles
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
			array('term_code, description', 'required'),
			array('term_code', 'length', 'max'=>32),
			array('description', 'length', 'max'=>512),
			array('start_date, end_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('term_code, description, start_date, end_date', 'safe', 'on'=>'search'),
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
			'assignments' => array(self::HAS_MANY, 'Assignment', 'term_code'),
			'courses' => array(self::HAS_MANY, 'Course', 'term_code'),
			'instructorFiles' => array(self::HAS_MANY, 'InstructorFiles', 'term_code'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'term_code' => 'Term Code',
			'description' => 'Description',
			'start_date' => 'Start Date',
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

		$criteria->compare('term_code',$this->term_code,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public static function currentAndPastTerms()
	{
		$now = date('Y-m-d');
		return self::model()->findAll(array('order'=>'term_code DESC', 'condition'=>"start_date < $now") );
	}

		/**
	 * @return array customized attribute labels (name=>label)
	 */
	public static function currentTermCode()
	{
		$now = date('Y-m-d');
		return self::model()->find(array('order'=>'term_code DESC', 'condition'=>"start_date < '$now'"))->term_code;
	}

}
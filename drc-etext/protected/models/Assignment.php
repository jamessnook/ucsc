<?php

/**
 * This is the model class for table "assignment".
 *
 * The followings are the available columns in table 'assignment':
 * @property integer $id
 * @property integer $term_code
 * @property integer $class_num
 * @property integer $book_id
 * @property string $created
 * @property string $modified
 * @property string $modified_by
 * @property string $notes
 * @property boolean $is_complete
 * @property boolean $has_zip_file
 *
 * The followings are the available model relations:
 * @property User $modifiedBy
 * @property Term $termCode
 * @property Course $classNum
 * @property DrcRequest[] $drcRequests
 */
class Assignment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Assignment the static model class
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
		return 'assignment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('term_code, class_num', 'required'),
			array('term_code, class_num, book_id', 'numerical', 'integerOnly'=>true),
			array('modified_by', 'length', 'max'=>64),
			array('notes', 'length', 'max'=>1024),
			array('created, modified, is_complete, has_zip_file', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, term_code, class_num, book_id, created, modified, modified_by, notes, is_complete, has_zip_file', 'safe', 'on'=>'search'),
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
			'modifiedBy' => array(self::BELONGS_TO, 'User', 'modified_by'),
			'termCode' => array(self::BELONGS_TO, 'Term', 'term_code'),
			'course' => array(self::BELONGS_TO, 'Course', 'class_num, term_code'),
			'drcRequests' => array(self::MANY_MANY, 'DrcRequest', 'assignment_type(assignment_id, accommodation_type)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'term_code' => 'Term Code',
			'class_num' => 'Class Num',
			'book_id' => 'Book',
			'created' => 'Created',
			'modified' => 'Modified',
			'modified_by' => 'Modified By',
			'notes' => 'Notes',
			'is_complete' => 'Is Complete',
			'has_zip_file' => 'Has Zip File',
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
		$criteria->compare('term_code',$this->term_code);
		$criteria->compare('class_num',$this->class_num);
		$criteria->compare('book_id',$this->book_id);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('modified_by',$this->modified_by,true);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('is_complete',$this->is_complete);
		$criteria->compare('has_zip_file',$this->has_zip_file);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	// for student's course list
	// SELECT title AS courseName,
	// CONCAT(" ", subject, course_id, section) AS classId,
	// GROUP_CONCAT( user.first_name || ' ' || user.last_name) AS faculty,
	// COUNT(id) AS assignments, 
	// MIN(is_complete) AS completed
	// FROM user JOIN drc_request ON (user.emplid = drc_request.emplid 
	// NATURAL JOIN assignment NATURAL JOIN course NATURAL JOIN course_instructor 
	// JOIN user ON(course_instructor.emplid = user.emplid)
	// WHERE user.username = $username
	// GROUP BY term_code, class_num
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search1()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('term_code',$this->term_code);
		$criteria->compare('class_num',$this->class_num);
		$criteria->compare('book_id',$this->book_id);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('modified_by',$this->modified_by,true);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('is_complete',$this->is_complete);
		$criteria->compare('has_zip_file',$this->has_zip_file);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
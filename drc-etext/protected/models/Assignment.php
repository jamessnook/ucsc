<?php

/**
 * This is the model class for table "assignment".
 *
 * The followings are the available columns in table 'assignment':
 * @property integer $id
 * @property integer $term_code
 * @property integer $class_number
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
 * @property Course $classNumber
 * @property Term $termCode
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
			array('term_code, class_number', 'required'),
			array('term_code, class_number, book_id', 'numerical', 'integerOnly'=>true),
			array('modified_by', 'length', 'max'=>32),
			array('notes', 'length', 'max'=>1024),
			array('created, modified, is_complete, has_zip_file', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, term_code, class_number, book_id, created, modified, modified_by, notes, is_complete, has_zip_file', 'safe', 'on'=>'search'),
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
			'classNumber' => array(self::BELONGS_TO, 'Course', 'class_number'),
			'termCode' => array(self::BELONGS_TO, 'Term', 'term_code'),
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
			'class_number' => 'Class Number',
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
		$criteria->compare('class_number',$this->class_number);
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
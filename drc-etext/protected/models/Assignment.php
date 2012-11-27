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
 * @property Term $term_code
 * @property Course $class_num
 * @property DrcRequest[] $drcRequests
 */
class Assignment extends CActiveRecord
{
	public $username;
	public $emplid;
	
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
			array('description', 'length', 'max'=>512),
			array('created, modified, is_complete, has_zip_file, title, description, due_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, term_code, class_num, book_id, created, modified, modified_by, notes, is_complete', 'safe', 'on'=>'search'),
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
			'term' => array(self::BELONGS_TO, 'Term', 'term_code'),
			//'book' => array(self::BELONGS_TO, 'Book', 'book_id', 'joinType' => 'LEFT OUTER JOIN'),
			'book' => array(self::BELONGS_TO, 'Book', 'book_id'),
			'course' => array(self::BELONGS_TO, 'Course', 'class_num, term_code'),
            'assignmentTypes'=>array(self::HAS_MANY, 'AssignmentType', 'assignment_id'),
			'fileIds'=>array(self::HAS_MANY, 'AssignmentFile', 'assignment_id'),
			'drcRequests' => array(self::HAS_MANY, 'DrcRequest', 'term_code, class_num'),
			'drcRequests1' => array(self::MANY_MANY, 'DrcRequest', 'assignment_type(assignment_id, type)'),
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
			'title' => 'Title',
			'description' => 'Description',
			'due_date' => 'Due Date',
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

	/**
	 * Retrieves a list of AssignemtnFile models for this Assignment based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function assignmentFiles()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('assignment_id',$this->id);
		
		return new CActiveDataProvider('AssignmentFile', array(
			'criteria'=>$criteria,
		 	'pagination' => false,
		));
	}

	/**
	 * Retrieves a count of the assignemtns for this course.
	 * @return integer, a count of the assignemtns for this course.
	 */
	public function fileCount()
	{
		return $this->fileIds? count($this->fileIds) : 0;
	}
	
	/**
	 * Retrieves a list of faculty names.
	 * @return string, the names of faculty for this course.
	 */
	public function types()
	{
		$types = '';
		foreach($this->assignmentTypes as $type)
		{
			$types .= $type . ' ';
		}
		return $types;
	}
	
	/**
	 * Retrieves a list of faculty names.
	 * @return string, the names of faculty for this course.
	 */
	public function types2()
	{
		$types = '';
		foreach($this->drcRequests as $request)
		{
			$types .= $request->type . ' ';
		}
		return $types;
	}
	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id=null, $term_code=null, $class_num=null, $username=null, $emplid=null)
	{
		if ($id){
			$model=Assignment::model()->findByPk($id);
		}
		if(!$id || $model===null){
			$model=new Assignment('search');
			$model->unsetAttributes();  // clear any default values
	
			$model->term_code = $term_code;
			$model->class_num = $class_num;
		}
		$model->username = $username;
		$model->emplid = $emplid;
		return $model;
	}
	
	
}
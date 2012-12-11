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
class Assignment extends UCSCModel
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
			array('id, term_code, class_num, book_id, created, modified, is_complete, has_zip_file, title, description, due_date, username, emplid', 'safe'),
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
			'book' => array(self::BELONGS_TO, 'Book', 'book_id'),
			'course' => array(self::BELONGS_TO, 'Course', 'class_num, term_code'),
			'fileIds'=>array(self::HAS_MANY, 'FileAssociation', 'model_id'),
			'drcRequests' => array(self::HAS_MANY, 'DrcRequest', 'term_code, class_num'),
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

		$criteria=new CDbCriteria;

		$criteria->compare('term_code',$this->term_code);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Retrieves a data provider that can provide a list of files uploaded for this Assignment.
	 * @return CActiveDataProvider the data provider that can return a list of File Association models.
	 */
	public function files()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('model_id',$this->id);
		$criteria->compare('model_name','Assignment');
		
		return new CActiveDataProvider('FileAssociation', array(
			'criteria'=>$criteria,
		 	'pagination' => false,
		));
	}

	/**
	 * Retrieves a data provider that can provide a list of files uploaded for this Assignment that are available to a prticular user.
	 * @return CActiveDataProvider the data provider that can return a list of File Association models.
	 */
	public function studentFiles()
	{
		$username = Yii::app()->user->name;
		$criteria=new CDbCriteria;
		$criteria->with = array( 'assignmentIds.assignment', 'assignmentIds.assignment.drcRequests');
		//$criteria->together = array( 'assignmentIds.assignment', 'assignmentIds.assignment.drcRequests'); // might be needed
		$criteria->compare('assignmentIds.assignment.id',$assignemntId);
		$criteria->compare('assignmentIds.assignment.drcRequests.username',$username);
		$criteria->compare('assignmentIds.assignment.drcRequests.type',$this->type);
		//$criteria->addCondition("drcRequests.username = $username");         
		
		$criteria=new CDbCriteria;
		$criteria->compare('model_id',$this->id);
		$criteria->compare('model_name','Assignment');
		$criteria->addCondition("model_id IN(SELECT assignment.id FROM assignement 
		      JOIN drc_request USING (term_code, class_num)JOIN user USING(emplid) 
		      JOIN file ON ( file_id = file.id)
		      WHERE user.username = $this->username AND drc_request.type=file.type)");         
		
		return new CActiveDataProvider('FileAssociation', array(
					'criteria'=>$criteria,
		 	'pagination' => false,
		));

	
			// create sql to retieve students who will use this book and whether they have purchased it.
		$sql = "SELECT DISTINCT user.username, user.first_name, user.last_name, book_user.purchased
			FROM user JOIN drc_request USING (emplid) JOIN assignment USING (term_code, class_num) LEFT JOIN book_user USING (username, book_id)
			WHERE assignment.book_id=" . $this->id;
		
		return new CSqlDataProvider($sql, array(
		 	'pagination' => false,
		 	'keyField' => 'username',
		));
	}
	
	/**
	 * Retrieves a count of the files for this assignment.
	 * @return integer, a count of the assignemtns for this course.
	 */
	public function fileCount()
	{
		return $this->fileIds? count($this->fileIds) : 0;
	}
	
	/**
	 * Retrieves an array of file types needed for this assignment.
	 * @return array, the names of file types for this course.
	 */
	public function types()
	{
		$types = array();
		foreach($this->drcRequests as $request)
		{
			$types[$request->type] = $request->type; // use value as key to prevent duplicates
		}
		return $types;
	}
	
}
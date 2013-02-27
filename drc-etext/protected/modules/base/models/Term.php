<?php

/**
 * This is the model class for table "term".
 *
 * Identifies the set of terms (quarters) which can be associated with 
 * courses, drcRequests and assignemtns.
 * Is used to populate menu.
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
 *
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.models
 */
class Term extends BaseModel
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
			'drcRequests' => array(self::HAS_MANY, 'DrcRequest', 'term_code'),
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
	 * Retrieves a list of Term models which have data in the data base 
	 * for the user with the username in the model supplied.
	 * @return an array of Term models.
	 */
	public static function terms($model=null)
	{
		$criteria=new CDbCriteria;
		$criteria->join = 'JOIN drc_request USING (term_code) JOIN user USING(emplid)';
		$criteria->distinct = true;
		$criteria->select = 't.term_code, t.description';
		if ($model && $model->username && strlen($model->username)>0){
			$criteria->compare('user.username',$model->username);
		}
		$criteria->order = 'term_code DESC';
		
		return Term::model()->findAll($criteria);
	}

	/**
	 * Retrieves a list of Term models which have data in the data base for the model supplied.
	 * An alternatre way of the above using straight SQL, returns data reader
	 * @return an array of Term models.
	 */
	public static function currentTerms($model=null)
	{
		$terms = array();
		// create sql to retieve term data for the current user (default is for all users who have drc requests)
		$sql = "SELECT DISTINCT term.term_code, term.description FROM term JOIN drc_request using (term_code)";
		if ($model && $model->username && strlen($model->username)>0){
			$sql .= " JOIN user using (emplid) WHERE user.username = '$model->username'";
		}
		$sql .= " ORDER BY term_code DESC";
		$command=Yii::app()->db->createCommand($sql);
		return $command->query();   // execute a query SQL and returns a data reader
	}

	/**
	 * Get the term_code for the most recent term (Quarter) with data in the database.
	 * @return integer, the term code for the most recent term with data in the database.
	 */
	public static function currentTermCode()
	{
		// get first ellement from array
		$terms = Term::terms();
		return reset($terms)->term_code;
	}

}
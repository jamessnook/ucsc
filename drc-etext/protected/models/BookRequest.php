<?php

/**
 * This is the model class for table "book_request".
 *
 * The followings are the available columns in table 'book_request':
 * @property integer $id
 * @property integer $request_id
 * @property integer $global_id
 * @property string $id_type
 * @property string $title
 * @property string $author
 * @property string $edition
 * @property string $created
 * @property string $last_changed
 * @property string $last_changed_by
 * @property string $notes
 * @property boolean $is_complete
 * @property boolean $has_zip_file
 *
 * The followings are the available model relations:
 * @property IdType $idType
 * @property ServiceRequest $request
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
			array('request_id, global_id', 'numerical', 'integerOnly'=>true),
			array('id_type, last_changed_by', 'length', 'max'=>32),
			array('title', 'length', 'max'=>512),
			array('author, edition', 'length', 'max'=>128),
			array('notes', 'length', 'max'=>1024),
			array('created, last_changed, is_complete, has_zip_file', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, request_id, global_id, id_type, title, author, edition, created, last_changed, last_changed_by, notes, is_complete, has_zip_file', 'safe', 'on'=>'search'),
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
			'idType' => array(self::BELONGS_TO, 'IdType', 'id_type'),
			'request' => array(self::BELONGS_TO, 'ServiceRequest', 'request_id'),
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
			'global_id' => 'Global',
			'id_type' => 'Id Type',
			'title' => 'Title',
			'author' => 'Author',
			'edition' => 'Edition',
			'created' => 'Created',
			'last_changed' => 'Last Changed',
			'last_changed_by' => 'Last Changed By',
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
		//$criteria->with=array('request',);
		$criteria->join="JOIN service_request ON (request_id = service_request.id)";                           
		$criteria->compare('id',$this->id);
		$criteria->compare('request_id',$this->request_id);
		$criteria->compare('service_request.term_id',$this->request->term_id);
		$criteria->compare('service_request.username',$this->request->username);
		$criteria->compare('service_request.accommodation_type',$this->request->accommodation_type);
		$criteria->compare('service_request.subject',$this->request->subject);
		$criteria->compare('service_request.course_name',$this->request->course_name);
		$criteria->compare('global_id',$this->global_id);
		$criteria->compare('id_type',$this->id_type,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('is_complete',$this->is_complete);
		$criteria->compare('has_zip_file',$this->has_zip_file);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Retrieves a list of models associated wit hthe current user.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function findForUser($username)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->join="JOIN service_request ON (request_id = service_request.id)";                           
		$criteria->condition="username='$username'";                           

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Retrieves a list of models associated wit hthe current user.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function findForUserAndTerm($username, $termId)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->join="JOIN service_request ON (request_id = service_request.id)";                           
		$criteria->condition="username='$username' AND term_id = '$termId'";                           
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
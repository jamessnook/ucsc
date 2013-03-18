<?php

/**
 * This is the model class for table "file".
 *
 * Represents a single file which has been uploaded and associated with a book or assignment.
 *
 * The followings are the available columns in table 'file':
 * @property integer $id
 * @property string $name
 * @property string $path
 * @property string $caption
 * @property integer $parent_id
 * @property integer $type_id
 * @property integer $order_num
 * @property string $created
 * @property string $modified
 * @property string $modified_by
 *
 * The followings are the available model relations:
 * @property FileType $type
 * @property BookRequest $parent
 * @property User $modifiedBy
 *
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.models
 */
class File extends BaseModel
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
			array('parent_id, type_id, order_num', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>128),
			array('title', 'length', 'max'=>128),
			array('path', 'length', 'max'=>256),
			array('description', 'length', 'max'=>512),
			array('modified_by', 'length', 'max'=>32),
			array('type, label, created, modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, path, type, label, title, description, parent_id, type_id, order_num, created, modified, modified_by', 'safe', 'on'=>'search'),
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
			//'type' => array(self::BELONGS_TO, 'FileType', 'type_id'),
			'modifiedBy' => array(self::BELONGS_TO, 'User', 'modified_by'),
			'assignmentIds' => array(self::HAS_MANY, 'FileAssociation', 'file_id'),
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
			'label' => 'Label',
			'title' => 'Title',
			'description' => 'Description',
			'parent_id' => 'Parent',
			'type_id' => 'Type Id',
			'type' => 'Type',
			'order_num' => 'Order Num',
			'created' => 'Created',
			'modified' => 'Modified',
			'modified_by' => 'Modified By',
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('type',$this->type);
		$criteria->compare('order_num',$this->order_num);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('modified_by',$this->modified_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Overrides parent to delet efile from file system.
	 */
	public function afterDelete(){
    	$pathAndName = Yii::app()->getBasePath() . $this->path .  "/" . $this->name;
	    if(!empty($pathAndName)){
            if (file_exists( $pathAndName )){
	    	   	unlink($pathAndName);
			}
 	    }
		return parent::afterDelete();
	}
	
	/**
	 * if type not set get file extension.
	 */
	public function getType(){
		$type = $this->type;
		if (!$this->type || $this->type = ''){
			$type = pathinfo($this->name, PATHINFO_EXTENSION);
		}
		return $type;
	}
	
	
}
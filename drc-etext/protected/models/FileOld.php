<?php

/**
 * This is the model class for table "file".
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
			array('parent_id, type_id, order_num', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>128),
			array('path', 'length', 'max'=>256),
			array('caption', 'length', 'max'=>512),
			array('modified_by', 'length', 'max'=>32),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, path, caption, parent_id, type_id, order_num, created, modified, modified_by', 'safe', 'on'=>'search'),
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
			'type' => array(self::BELONGS_TO, 'FileType', 'type_id'),
			'parent' => array(self::BELONGS_TO, 'BookRequest', 'parent_id'),
			'modifiedBy' => array(self::BELONGS_TO, 'User', 'modified_by'),
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
			'parent_id' => 'Parent',
			'type_id' => 'Type',
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
		$criteria->compare('caption',$this->caption,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('order_num',$this->order_num);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('modified_by',$this->modified_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 */
	public function getFullPath()
	{
		$path = (isset($this->path) ? rtrim($this->path, '/') :'');
		$path = (strlen($path)>0 ? $path . '/' : '');
		$fileRoot = rtrim(Yii::app()->params->fileRoot, '/\\').'/';
        return $fileRoot . $path . $this->name;
	}
	
	/**
	 */
	public function getDirPath()
	{
		$fileRoot = rtrim(Yii::app()->params->fileRoot, '/\\').'/';
        return $fileRoot . rtrim($this->path, '/\\').'/';
	}
	
	/**
	 */
	public function getExtension()
	{
        return substr ( $this->name , strrpos($this->name, '.' )+1);
	}
	
	/**
	 */
	public function getFileRoot()
	{
        return rtrim(Yii::app()->params->fileRoot, '/\\').'/';
	}

}
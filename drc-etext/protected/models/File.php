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
 * @property string $type
 * @property integer $order_num
 * @property string $post_date
 * @property string $poster_id
 *
 * The followings are the available model relations:
 * @property User $poster
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
			array('parent_id, order_num', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>128),
			array('path', 'length', 'max'=>256),
			array('caption', 'length', 'max'=>512),
			array('type', 'length', 'max'=>32),
			array('poster_id', 'length', 'max'=>64),
			array('post_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, path, caption, parent_id, type, order_num, post_date, poster_id', 'safe', 'on'=>'search'),
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
			'poster' => array(self::BELONGS_TO, 'User', 'poster_id'),
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
			'type' => 'Type',
			'order_num' => 'Order Num',
			'post_date' => 'Post Date',
			'poster_id' => 'Poster',
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('order_num',$this->order_num);
		$criteria->compare('post_date',$this->post_date,true);
		$criteria->compare('poster_id',$this->poster_id,true);

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
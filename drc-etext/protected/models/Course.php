<?php

/**
 * This is the model class for table "course".
 *
 * The followings are the available columns in table 'course':
 * @property integer $term_code
 * @property integer $class_number
 * @property string $section
 * @property string $course_id
 * @property string $subject
 * @property string $description
 * @property string $title
 * @property string $catalog_nbr
 * @property string $created
 *
 * The followings are the available model relations:
 * @property Assignment[] $assignments
 * @property InstructorFiles[] $instructorFiles
 */
class Course extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Course the static model class
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
		return 'course';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('term_code', 'required'),
			array('term_code, class_number', 'numerical', 'integerOnly'=>true),
			array('section, course_id', 'length', 'max'=>32),
			array('subject, catalog_nbr', 'length', 'max'=>64),
			array('description', 'length', 'max'=>512),
			array('title', 'length', 'max'=>128),
			array('created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('term_code, class_number, section, course_id, subject, description, title, catalog_nbr, created', 'safe', 'on'=>'search'),
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
			'assignments' => array(self::HAS_MANY, 'Assignment', 'class_number'),
			'instructorFiles' => array(self::HAS_MANY, 'InstructorFiles', 'class_number'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'term_code' => 'Term Code',
			'class_number' => 'Class Number',
			'section' => 'Section',
			'course_id' => 'Course',
			'subject' => 'Subject',
			'description' => 'Description',
			'title' => 'Title',
			'catalog_nbr' => 'Catalog Nbr',
			'created' => 'Created',
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

		$criteria->compare('term_code',$this->term_code);
		$criteria->compare('class_number',$this->class_number);
		$criteria->compare('section',$this->section,true);
		$criteria->compare('course_id',$this->course_id,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('catalog_nbr',$this->catalog_nbr,true);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Updates Model from data in a SimpleXMLElement object.
	 * @param SimpleXMLElement $elem the attribute name
	 */
	public static function updateFromSimpleXML($elem, $className = null)
	{
		if (!$className){
			$className = $elem->getName();
		}
		if (class_exists($className)) {
			$model = new $className;
			//$className = get_called_class();
			//if ($elem->getName() == $className){
			//$model = new $className;
			//$model = new static();
			
			//create model from new data
			foreach ($elem->children() as $node) {
				//$attribs[$node->getName()] = (string)$node;
				//$this->{$node->getName()} = (string)$node;
				$model->setAttribute($node->getName(),(string)$node); // safely returns false if attribute does not exist
			}
			$modelPrior = $model->findByPk($model->getPrimaryKey());  
			//now check if the model is null
			if(!$modelPrior) {
				$model->save();			
			} else{
				// update
				$modelPrior->updateByPk($model->getPrimaryKey(), $model->getAttributes());			
			}
		}
		// ......
	}

}
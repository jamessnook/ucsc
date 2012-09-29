<?php

/**
 * This is the model class for table "term".
 *
 * The followings are the available columns in table 'term':
 * @property string $id
 * @property string $name
 * @property string $quarter
 * @property integer $year
 * @property string $begin_date
 * @property string $end_date
 */
class Term extends CActiveRecord
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
			array('id, name', 'required'),
			array('year', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>32),
			array('name', 'length', 'max'=>512),
			array('quarter', 'length', 'max'=>128),
			array('begin_date, end_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, quarter, year, begin_date, end_date', 'safe', 'on'=>'search'),
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
			'quarter' => 'Quarter',
			'year' => 'Year',
			'begin_date' => 'Begin Date',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('quarter',$this->quarter,true);
		$criteria->compare('year',$this->year);
		$criteria->compare('begin_date',$this->begin_date,true);
		$criteria->compare('end_date',$this->end_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * get the id of the current term.
	 */
	public function getCurrentTermId()
    {
    	$date = getdate();
    	return $this->getIdForDate($date);
    }
	
	/**
	 * get the id of a term.
	 */
	public function getIdForDate($date)
    {
    	if ($date['yday']>350 && $date['yday']<80 ) $quarter = 0;
    	else if ($date['yday']<175 ) $quarter = 2;
    	else if ($date['yday']<240 ) $quarter = 4;
    	else  $quarter = 8;
    	return (intval($date['year']/1000)*100 + $date['year']%100)*10 + $quarter;
    }
	
	/**
	 * get the name of a term.
	 */
	public function getNameForDate($date)
    {
    	if ($date['yday']>350 && $date['yday']<80 ) $quarter = 'Winter';
    	else if ($date['yday']<175 ) $quarter = 'Spring';
    	else if ($date['yday']<240 ) $quarter = 'Summer';
    	else  $quarter = 'Fall';
    	return $quarter . ' ' . $date['year'];
    }
	
	/**
	 * get the name of a term.
	 */
	public function getNameForTermId($termId)
    {
    	if ($termId % 10 < 2 ) $quarter = 'Winter';
    	else if ($termId % 10 < 4 ) $quarter = 'Spring';
    	else if ($termId % 10 < 8  ) $quarter = 'Summer';
    	else  $quarter = 'Fall';
    	if ($termId < 1000) {
    		$century = '19';
    	}else {
    		 $century = '20';
    	}
   		return $quarter . ' ' . $century . intval(($termId % 1000)/10);
    }
	
    /**
	 * get array of name value paisa for nearby terms.
	 */
	public function getTerms()
    {
    	$terms = array();
    	$termId = getCurrentTermId() - 20;
    	for($i=0; i<12; $i++){
    		$terms[$termId] = getNameForTermId($termId);
    		$termId = getNextTermId($termId);
    	}
     	return $terms;
    }
        
    /**
	 * get next termId.
	 */
	public function getNextTermId($termId)
    {
    	$newTermId = $termId + 2;
    	if ($newTermId % 10 == 6) $newTermId+=2;
    	return $newTermId;
    }
}
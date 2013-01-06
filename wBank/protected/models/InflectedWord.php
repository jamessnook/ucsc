<?php

/**
 * This is the model class for table "inflectedword".
 *
 * The followings are the available columns in table 'inflectedword':
 * @property integer $id
 * @property string $word
 * @property string $flectType
 * @property string $transInfl
 * @property string $inflection
 * @property integer $celexWordId
 * @property integer $lemmaId
 * @property double $zenoFreq
 */
class InflectedWord extends UCSCModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InflectedWord the static model class
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
		return 'inflectedWord';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('celexWordId, lemmaId', 'numerical', 'integerOnly'=>true),
			array('zenoFreq', 'numerical'),
			array('word', 'length', 'max'=>60),
			array('flectType, transInfl, inflection', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, word, flectType, transInfl, inflection, celexWordId, lemmaId, zenoFreq', 'safe', 'on'=>'search'),
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
			'words' => array(self::HAS_MANY, 'Words', 'lemmaId'),
		);
	}

	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'word' => 'Word',
			'flectType' => 'Type',
			'transInfl' => 'Structure',
			'inflection' => 'Inflection',
			'celexWordId' => 'Celex Word Id',
			'lemmaId' => 'Lemma Id',
			'zenoFreq' => 'Frequency',
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
		$criteria->compare('word',$this->word,true);
		$criteria->compare('flectType',$this->flectType,true);
		$criteria->compare('transInfl',$this->transInfl,true);
		$criteria->compare('inflection',$this->inflection,true);
		$criteria->compare('celexWordId',$this->celexWordId);
		$criteria->compare('lemmaId',$this->lemmaId);
		$criteria->compare('zenoFreq',$this->zenoFreq);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
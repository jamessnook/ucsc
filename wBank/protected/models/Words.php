<?php

/**
 * This is the model class for table "words".
 *
 * The followings are the available columns in table 'words':
 * @property integer $id
 * @property string $word
 * @property string $pos
 * @property integer $isPubWord
 * @property integer $lemmaId
 * @property string $head
 * @property integer $headCnt
 * @property integer $polysemyCnt
 * @property integer $concrete
 * @property integer $senseNum
 * @property string $senseText
 * @property string $definition
 * @property integer $synsetId
 * @property integer $posHeadCnt
 * @property integer $wordNetId
 */
class Words extends UCSCModel
{
	//public $wid = array();  // for passed in list of word ids to include in new list
	public $chk = array();  // for passed in list of checked or not checked word ids
	public $tid = array();  // for passed in list of topic ids to use to create new list
	public $exp = 0;        // expansion level to expand page range matches by
	public $subjectId;      // class subject
	public $grade;          // class grade
	public $maxFrequency=1000000;   // word frequency
	public $minFrequency=0;   // word frequency
	public $topicId;   		// word frequency
	public $addToList = false;    // true if add new search results to previous list
	public $saveOldList = false;    // true if save list
	public $saveNewList = false;    // true if save list to new name and Id
	public $loadList = false;    // true if load old list from db
	public $downloadTsv = false;    // download file to users pc
	public $viewInflections = false;    // display page of inflected forms of words in list 
	public $viewLemmaMorph = false;    // display page of lemma Morpology and Derivation info
	public $downloadInflections = false;    // display page of inflected forms of words in list
	public $removeChecked = false;    // remove checked words from list
	public $removeUnchecked = false;    // remove unchecked words from list
	public $listName = "default";    // save list as
	public $listId = 0;    // save list as
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Words the static model class
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
		return 'words';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('isPubWord, lemmaId, headCnt, polysemyCnt, concrete, zenoFreq, senseNum, synsetId, posHeadCnt, wordNetId', 'numerical', 'integerOnly'=>true),
			array('word, head', 'length', 'max'=>60),
			array('pos', 'length', 'max'=>16),
			array('senseText, definition', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			/*array('id, word, pos, isPubWord, lemmaId, head, headCnt, zenoFreq, polysemyCnt, concrete, 
			senseNum, senseText, definition, synsetId, posHeadCnt, wordNetId, maxFrequency, minFrequency, 
			subject, grade, exp, topic', 'safe', 'on'=>'search'),*/
			array('id, word, pos, isPubWord, lemmaId, head, headCnt, zenoFreq, polysemyCnt, concrete, 
			senseNum, senseText, definition, synsetId, posHeadCnt, wordNetId, maxFrequency, minFrequency, 
			subject, grade, exp, topic', 'safe'),
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
			'word' => 'Word',
			'pos' => 'Part of Speech',
			'isPubWord' => 'Is Publisher Word',
			'lemmaId' => 'Lemma',
			'head' => 'Head',
			'headCnt' => 'Head Cnt',
			'polysemyCnt' => 'Polysemy Count',
			'concrete' => 'Concrete',
			'senseNum' => 'Sense Num',
			'senseText' => 'Sense Text',
			'definition' => 'Definition',
			'synsetId' => 'Synset',
			'posHeadCnt' => 'Pos Head Cnt',
			'grade' => 'Grade',
			'subjectId' => 'Subject',
			'topicId' => 'Topic',
			'minFrequency' => 'Min Word Frequency',
			'maxFrequency' => 'Max Word Frequency',
			'concrete' => 'Conceteness',
			'wordNetId' => 'Word Net Id',
			'zenoFreq' => 'Frequency',
			'listId' => 'Existing Lists',
			'listName' => 'New List Name',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{

		$criteria=new CDbCriteria;
	
		if (isset($this->word) && strlen($this->word)>1){
			$word = str_replace('*', '%', $this->word);
			$criteria->addCondition("word LIKE '{$word}' ");          
		}
		$criteria->compare('id',$this->id);
		$criteria->compare('pos',$this->pos,true);
		$criteria->compare('isPubWord',$this->isPubWord);
		$criteria->compare('lemmaId',$this->lemmaId);
		$criteria->compare('head',$this->head,true);
		//$criteria->compare('headCnt',$this->headCnt);
		$criteria->compare('polysemyCnt','>' . $this->polysemyCnt);
		$criteria->compare('concrete',$this->concrete);
		$criteria->compare('senseNum',$this->senseNum);
		$criteria->compare('zenoFreq','>=' . $this->minFrequency);
		$criteria->compare('zenoFreq','<' . $this->maxFrequency);
		//echo ("concrete= $this->concrete, Freq  >= $this->minFrequency  < $this->maxFrequency");
		//$criteria->compare('senseText',$this->senseText,true);
		//$criteria->compare('definition',$this->definition,true);
		//$criteria->compare('synsetId',$this->synsetId);
		//$criteria->compare('posHeadCnt',$this->posHeadCnt);
		//$criteria->compare('wordNetId',$this->wordNetId);
		if ($this->subjectId>0){
			$criteria->addCondition("id IN (SELECT wordId FROM wordSubjects WHERE subjectId =$this->subjectId)");          
		}
		if ($this->grade>0){
			$criteria->addCondition("id IN (SELECT wordId FROM wordGrade WHERE grade =$this->grade)");          
		}
		if ($this->topicId>0){
			$criteria->addCondition("id IN (SELECT wordId FROM wordTopic JOIN topicMap USING (topicId) WHERE  parentId =$this->topicId AND exp <=$this->exp)");          
		}
		//if(isset($_POST['addToList'])) {
		if($this->addToList) {
			//foreach ($this->wid as $id){
			foreach ($this->chk as $id=>$checked){
				$criteria->compare('id',$id, false, 'OR');
			}
		}
		foreach ($this->tid as $id){
			$criteria->addCondition("id IN (SELECT wordId FROM wordTopic WHERE topicId =$id AND exp <=$this->exp)");          
		}
		if($this->loadList) {
			$criteria=new CDbCriteria;
			if ($this->listId){
				$criteria->addCondition("id IN (SELECT wordId FROM wordList WHERE listId =$this->listId)");   
			} else {
				$criteria->addCondition("id IN (SELECT wordId FROM wordList JOIN lists ON (id=listId) WHERE name ='$this->listName')");   
			}       
		}
		if($this->downloadTsv) {
			$criteria=new CDbCriteria;
			foreach ($this->chk as $id=>$checked){
				$criteria->compare('id',$id, false, 'OR');
			}
		}
		
		if($this->removeChecked) {
			$criteria=new CDbCriteria;
			$criteria->compare('id',-1, false, 'OR'); // base for OR so if no checked words we doen't get all of the records
			foreach ($this->chk as $id=>$checked){
				if (!$checked){
					$criteria->compare('id',$id, false, 'OR');
				}
			}
		}
		
		if($this->removeUnchecked) {
			$criteria=new CDbCriteria;
			$criteria->compare('id',-1, false, 'OR'); // base for OR so if no checked words we doen't get all of the records
			foreach ($this->chk as $id=>$checked){
				if ($checked){
					$criteria->compare('id',$id, false, 'OR');
				}
			}
		}
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		 	'pagination' => false,
		));
	}
	
	
	/**
	 * Retrieves a data provider that can provide list of emails for this Course.
	 * @return CActiveDataProvider the data provider that can return a list of Email models.
	 */
	public function inflections()
	{
		$where = " WHERE inflection!='' AND inflection!='IRR' AND (";
		foreach ($this->chk as $id=>$checked){
				$where .= "words.id=$id OR ";
		}
		$where .= "words.id=-2)"; // terminate list with extra special case
		// create sql to retieve emails sent or available to be sent ot istructors for this course.
		$sql = "SELECT DISTINCT inflectedWord.word, head, transInfl, inflection, transDer, strucLab, immSubCat, inflectedWord.zenoFreq
			FROM words JOIN inflectedWord USING (lemmaId)" . $where;
		
		return new CSqlDataProvider($sql, array(
		 	'pagination' => false,
		 	'keyField' => 'word',
		));
	}

	
	/**
	 * Retrieves a data provider that can provide list of emails for this Course.
	 * @return CActiveDataProvider the data provider that can return a list of Email models.
	 */
	public function lemmaMorph()
	{
		$where = " WHERE ";
		foreach ($this->chk as $id=>$checked){
				$where .= "words.id=$id OR ";
		}
		$where .= "words.id=-2"; // terminate list with extra special case
		// create sql to retieve emails sent or available to be sent ot istructors for this course.
		$sql = "SELECT DISTINCT head, transDer, strucLab, immSubCat
			FROM words JOIN inflectedWord USING (lemmaId)" . $where;
		
		return new CSqlDataProvider($sql, array(
		 	'pagination' => false,
		 	'keyField' => 'head',
		));
	}

	
	/**
	 * ---
	 */
	public function createList()
	{
		$list = new Lists();
		$list->name = $this->listName;
		$list->username = Yii::app()->user->name;
		$list->save();
		//foreach ($this->wid as $id){
		foreach ($this->chk as $id=>$checked){
			$item = new WordList();
			$item->wordId = $id;
			$item->listId = $list->id;
			$item->save();
		}
	}

	/**
	 * ---
	 */
	public function updateList()
	{
		if ($this->listId) {
			$list=Lists::model()->findByPk($this->listId);
		} else{
			$list=Lists::model()->findByAttributes(array('name'=>$this->listName));
		}
		if($list===null){
			return;
			$list = new Lists();  // set error
		}
		$list->name = $this->listName;
		$list->username = Yii::app()->user->name;
		$list->save();
		foreach ($list->wordList as $item){ // delete old entries
			$item->delete();
		}
		//foreach ($this->wid as $id){
		foreach ($this->chk as $id=>$checked){
			$item = new WordList();
			$item->wordId = $id;
			$item->listId = $list->id;
			$item->save();
		}
	}


	
}
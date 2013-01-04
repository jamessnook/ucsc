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
	public $wid = array();  // for passed in list of word ids to include in new list
	public $tid = array();  // for passed in list of topic ids to use to create new list
	public $exp = 0;        // expansion level to expand page range matches by
	public $subjectId;      // class subject
	public $grade;          // class grade
	public $maxFrequency=1000000;   // word frequency
	public $minFrequency=1000;   // word frequency
	public $topicId;   		// word frequency
	public $addToList = false;    // true if add new search results to previous list
	public $saveOldList = false;    // true if save list
	public $saveNewList = false;    // true if save list to new name and Id
	public $loadList = false;    // true if load old list from db
	public $download = false;    // download file to users pc
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
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

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
		$criteria->compare('headCnt',$this->headCnt);
		$criteria->compare('polysemyCnt',$this->polysemyCnt);
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
			foreach ($this->wid as $id){
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
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		 	'pagination' => false,
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
		foreach ($this->wid as $id){
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
		foreach ($this->wid as $id){
			$item = new WordList();
			$item->wordId = $id;
			$item->listId = $list->id;
			$item->save();
		}
	}


	/**
	 * Retrieves a data provider that can provide list of students for this Book.
	 * @return CActiveDataProvider the data provider that can return a list of User models.
	 */
	public function lists()
	{
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
	 * Retrieves a list of books for this course based on the current request parameters.
	 * @return CActiveDataProvider the data provider that can return the models based on the request parameters.
	 */
	public function books()
	{
		$criteria=new CDbCriteria;
		$criteria->addCondition("id IN (SELECT book_id FROM assignment WHERE term_code ='$this->term_code' AND class_num='$this->class_num')");          
		
		return new CActiveDataProvider('Book', array(
			'criteria'=>$criteria,
		 	'pagination' => false,
		));
	}
	
}
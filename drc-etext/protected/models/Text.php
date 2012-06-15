<?php

/**
 * This is the model class for table "text".
 *
 * The followings are the available columns in table 'text':
 * @property integer $id
 * @property string $title
 * @property string $author
 * @property string $publisher
 * @property integer $year_published
 * @property string $edition
 * @property string $isbn
 * @property integer $poster_id
 * @property string $post_date
 * @property integer $format_id
 * @property boolean $is_complete
 * @property boolean $is_viewable
 * @property string $description
 *
 * The followings are the available model relations:
 * @property Section[] $sections
 * @property Format $format
 * @property User $poster
 */
class Text extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Text the static model class
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
		return 'text';
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
			array('year_published, poster_id, format_id', 'numerical', 'integerOnly'=>true),
			array('title, description', 'length', 'max'=>512),
			array('author, publisher, edition', 'length', 'max'=>128),
			array('isbn', 'length', 'max'=>64),
			array('post_date, is_complete, is_viewable', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, author, publisher, year_published, edition, isbn, poster_id, post_date, format_id, is_complete, is_viewable, description', 'safe', 'on'=>'search'),
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
			'sections' => array(self::MANY_MANY, 'Section', 'section_text(text_id, section_id)'),
			'format' => array(self::BELONGS_TO, 'Format', 'format_id'),
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
			'title' => 'Title',
			'author' => 'Author',
			'publisher' => 'Publisher',
			'year_published' => 'Year Published',
			'edition' => 'Edition',
			'isbn' => 'Isbn',
			'poster_id' => 'Poster',
			'post_date' => 'Post Date',
			'format_id' => 'Format',
			'is_complete' => 'Is Complete',
			'is_viewable' => 'Is Viewable',
			'description' => 'Description',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('publisher',$this->publisher,true);
		$criteria->compare('year_published',$this->year_published);
		$criteria->compare('edition',$this->edition,true);
		$criteria->compare('isbn',$this->isbn,true);
		$criteria->compare('poster_id',$this->poster_id);
		$criteria->compare('post_date',$this->post_date,true);
		$criteria->compare('format_id',$this->format_id);
		$criteria->compare('is_complete',$this->is_complete);
		$criteria->compare('is_viewable',$this->is_viewable);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
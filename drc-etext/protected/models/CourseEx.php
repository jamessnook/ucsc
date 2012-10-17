<?php

/**
 * This is the model class for table "Course".
 *
 * The followings are the available columns in table 'Course':
 * @property integer $term_code
 * @property integer $class_num
 * @property string $section
 * @property string $course_id
 * @property string $subject
 * @property string $description
 * @property string $title
 * @property string $catalog_num
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property Assignment[] $assignments
 * @property Term $termCode
 * @property CourseInstructor[] $courseInstructors
 * @property CourseInstructor[] $courseInstructors1
 * @property DrcRequest[] $drcRequests
 * @property DrcRequest[] $drcRequests1
 * @property InstructorFiles[] $instructorFiles
 */
class CourseEx extends Course
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
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'term_code' => 'Term Code',
			'class_num' => 'Class Num',
			'section' => 'Section',
			'course_id' => 'Course',
			'subject' => 'Subject',
			'description' => 'Description',
			'title' => 'Title',
			'catalog_num' => 'Catalog Num',
			'created' => 'Created',
			'modified' => 'Modified',
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
		$criteria->compare('class_num',$this->class_num);
		$criteria->compare('section',$this->section,true);
		$criteria->compare('course_id',$this->course_id,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('catalog_num',$this->catalog_num,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	/**
	 * Retrieves a list of faculty names.
	 * @return string, the names of faculty for this course.
	 */
	public function faculty()
	{
		$names = '';
		foreach($this->instructors as $instructor)
		{
			$names .= $instructor->user->first_name . ' ' . $instructor->user->last_name . ', ';
		}
		return substr($names, 0, -2);
	}
	
}
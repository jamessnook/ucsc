<?php

class CourseController extends Controller
{
	/**
	 * Display data about a course.
	 */
	public function actionDescription($termCode=null, $classNum=null)
	{
		$model=new Course('search');
		//$this->term = $model->find();
		$model->unsetAttributes();  // clear any default values

		if (!$termCode) $termCode = Term::currentTermCode();
		if (!$classNum) {echo 'Error!'; return;}  //temp error code
		$model->term_code = $termCode;
		$model->class_num = $classNum;
		
		$this->render('description',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAssignments($termCode=null, $classNum=null, $username=null)
	{
		$model=new Course('search');
		//$this->term = $model->find();
		$model->unsetAttributes();  // clear any default values

		if (!$termCode) $termCode = Term::currentTermCode();
		$model->username = $username;
		$model->term_code = $termCode;
		$model->class_num = $classNum;

		$this->render('assignments',array(
			'model'=>$model,
		));
	}

	/**
	 * s.
	 */
	public function actionAssignmentsForUser($termCode=null, $classNum=null, $username=null)
	{
		if (!$username) $username = Yii::app()->user->name;
		$this->actionAssignments($termCode, $classNum, $username);
	}
	
	/**
	 * .
	 */
	public function actionBooks($termCode=null, $classNum=null, $username=null)
	{
		$model=new Course('search');
		//$this->term = $model->find();
		$model->unsetAttributes();  // clear any default values

		if (!$termCode) $termCode = Term::currentTermCode();
		$model->username = $username;
		$model->term_code = $termCode;
		$model->class_num = $classNum;

		$this->render('books',array(
			'model'=>$model,
		));
	}
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
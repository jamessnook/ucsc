<?php

class CourseController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

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
	public function actionAssignments($termCode=null, $classNum=null, $username=null, $emplid=null)
	{
		if ($termCode && $classNum){
			$model=Course::model()->findByAttributes(array('term_code'=>$termCode, 'class_num'=>$classNum,));
		} else {
			$model=new Course('search');
			$model->unsetAttributes();  // clear any default values
		}
		$model->username = $username;
		$model->emplid = $emplid;
		
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
	 * Creates a new Assignment model.
	 */
	public function actionNewAssignment($termCode=null, $classNum=null)
	{
		$model=Course::model()->findByPk(array('term_code'=>$termCode, 'class_num'=>$classNum));
		if($model===null)
			throw new CHttpException(404,'The requested course does not exist.');
				
		$contentModel=new Assignment('search');
		//$this->term = $model->find();
		$contentModel->unsetAttributes();  // clear any default values

		$contentModel->term_code = $termCode;
		$contentModel->class_num = $classNum;

		$this->render('newAssignment',array(
			'model'=>$model,
			'contentModel' => $contentModel,
		));
	}

	/**
	 * Updates a particular Assignment model.
	 * @param integer $assignmentId the ID of the model to be updated
	 */
	public function actionUpdateAssignment($assignmentId)
	{
		$contentModel= Assignment::model()->findByPk($assignmentId);
		$model=Course::model()->findByPk(array('term_code'=>$contentModel->term_code, 'class_num'=>$contentModel-class_num));
		if($contentModel===null || $model===null)
			throw new CHttpException(404,'The requested course and assignment do not exist.');

		$this->render('updateAssignment',array(
			'model'=>$model,
			'contentModel' => $contentModel,
		));
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

	/**
	 * Creates a new Book model.
	 */
	public function actionCreateBook($termCode=null, $classNum=null)
	{
		$model=Course::model()->findByPk(array('term_code'=>$termCode, 'class_num'=>$classNum));
		if($model===null)
			throw new CHttpException(404,'The requested course does not exist.');
		
		$contentModel=new Book('search');
		//$this->term = $model->find();
		$contentModel->unsetAttributes();  // clear any default values

		$this->render('newBook',array(
			'model'=>$model,
			'contentModel' => $contentModel,
		));
	}

	/**
	 * Updates a particular Book model.
	 * @param integer $bookId the ID of the model to be updated
	 */
	public function actionUpdateBook($termCode=null, $classNum=null, $bookId)
	{
		$contentModel= Book::model()->findByPk($bookId);
		$model=Course::model()->findByPk(array('term_code'=>$termCode, 'class_num'=>$classNum));
		if($contentModel===null || $model===null)
			throw new CHttpException(404,'The requested course and book do not exist.');

		$this->render('updateBook',array(
			'model'=>$model,
			'contentModel' => $contentModel,
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
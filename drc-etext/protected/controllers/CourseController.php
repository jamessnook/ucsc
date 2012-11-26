<?php

class CourseController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/noLayout';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform view type actions
				'actions'=>array('description','assignments','assignmentsForUser','books','courses','students','assignmentFiles'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('createAssignment','updateAssignment', 'saveAssignment', 'createBook','updateBook', 'saveABook', 'studentAssignments'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Display data about a course.
	 */
	public function actionDescription($termCode=null, $classNum=null, $username=null, $emplid=null)
	{
		$model = $this->loadModel($termCode, $classNum, $username, $emplid);
		
		$this->render('description',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAssignments($termCode=null, $classNum=null, $username=null, $emplid=null)
	{
		$model = $this->loadModel($termCode, $classNum, $username, $emplid);
				
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
	public function actionCreateAssignment($termCode=null, $classNum=null)
	{
		$model=Course::model()->findByPk(array('term_code'=>$termCode, 'class_num'=>$classNum));
		if($model===null)
			throw new CHttpException(404,'The requested course does not exist.');
				
		$contentModel=Assignment::model()->loadModel(null, $termCode, $classNum);

		$this->render('createAssignment',array(
			'model'=>$model,
			'contentModel' => $contentModel,
		));
	}
	
	/**
	 * Updates a particular Assignment model.
	 * @param integer $assignmentId the ID of the model to be updated
	 */
	public function actionUpdateAssignment($id, $username=null)
	{
		$contentModel=Assignment::model()->loadModel($id, null, null, $username);
		$model = $this->loadModel($contentModel->term_code, $contentModel->class_num, $username);
		
		$view = 'updateAssignment';
		if (!Yii::app()->user->checkAccess('admin'))
			$view = 'updateAssignment';
			
		$this->render($view,array(
			'model'=>$model,
			'contentModel' => $contentModel,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionSaveAssignment($id=null, $termCode=null, $classNum=null)
	{
		$contentModel=Assignment::model()->loadModel($id, $termCode, $classNum);
		if(isset($_POST['Completed'])) {
			$contentModel->is_complete=true; // because it is not a form field in the post data
			$contentModel->attributes=$_POST['Completed'];
		}
		if(isset($_POST['Assignment']))
		{
			$contentModel->attributes=$_POST['Assignment'];
		}
		if(!$contentModel->save()) echo "ERROR could not save assignment."; // temporary error code
		$this->redirect(array('assignments','termCode'=>$model->term_code,'classNum'=>$model->class_num));
	}

	/**
	 * .
	 */
	public function actionBooks($termCode=null, $classNum=null, $username=null, $emplid=null)
	{
		$model = $this->loadModel($termCode, $classNum, $username, $emplid);
				
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

		$this->render('createBook',array(
			'model'=>$model,
			'contentModel' => $contentModel,
		));
	}
	
	/**
	 * Creates a new Book model. Alternate name
	 */
	public function actionNewBook($termCode=null, $classNum=null)
	{
		$this->actionCreateBook($termCode=null, $classNum=null);
	}
		
	
	/**
	 * Updates a particular Book model.
	 * @param integer $bookId the ID of the model to be updated
	 */
	public function actionUpdateBook($termCode=null, $classNum=null, $id=null)
	{
		$contentModel= Book::model()->findByPk($id);
		$model=Course::model()->findByPk(array('term_code'=>$termCode, 'class_num'=>$classNum));
		if($contentModel===null || $model===null)
			throw new CHttpException(404,'The requested course and book do not exist.');
			
		$this->render('updateBook',array(
			'model'=>$model,
			'contentModel' => $contentModel,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionSaveBook($termCode=null, $classNum=null, $id=null)
	{
		//$model=new Book;
		if ($id) $model=Book::model()->findByPk($id);
		if (!$model) $model=new Book;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Book']))
		{
			$model->attributes=$_POST['Book'];
			if($model->save())
				$this->redirect(array('books','termCode'=>$termCode,'classNum'=>$classNum));
		}
		$this->redirect(array('newBook','termCode'=>$termCode,'classNum'=>$classNum));
	}

	/**
	 * .
	 */
	public function actionStudents($termCode=null, $classNum=null)
	{
		$model = $this->loadModel($termCode, $classNum);
				
		$this->render('students',array(
			'model'=>$model,
		));
	}

	/**
	 * Display courses for a term.
	 */
	public function actionCourses($termCode=null)
	{
		$model=new Course('search');
		$model->unsetAttributes();  // clear any default values
		$model->term_code = $termCode;
		if (!Yii::app()->user->checkAccess('admin')){
			$model->username = Yii::app()->user->name;
		}
		$this->render('courses',array(
			'model'=>$model,
		));
	}

	
	/**
	 * Display List of Files for an assignment and user.
	 */
	public function actionAssignmentFiles($id, $username=null)
	{
		$contentModel= Assignment::model()->findByPk($id);
		if($contentModel===null)
			throw new CHttpException(404,'The requested assignment does not exist.');
		$model = $this->loadModel($contentModel->term_code, $contentModel->class_num, $username);
		$contentModel->username = $username;
		$this->render('assignmentFiles',array(
			'model'=>$model,
			'contentModel' => $contentModel,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($termCode=null, $classNum=null, $username=null, $emplid=null)
	{
		if ($termCode && $classNum){
			$model=Course::model()->findByAttributes(array('term_code'=>$termCode, 'class_num'=>$classNum,));
		} else {
			$model=new Course('search');
			$model->unsetAttributes();  // clear any default values
		}
		$model->term_code = $termCode;
		$model->username = $username;
		$model->emplid = $emplid;
		return $model;
	}

}
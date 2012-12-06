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
				'actions'=>array('index','assignmentsForUser','books','courses','students','assignmentFiles'),
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
	 * Updates a particular Assignment model.
	 * @param integer $assignmentId the ID of the model to be updated
	 */
	public function actionUpdateAssignment()
	{
		$contentModel=Assignment::loadModel();
		$model = Course::loadModel(array('term_code' => $contentModel->term_code, 'class_num' => $contentModel->class_num));
		
		$view = 'updateAssignment';
		if (!Yii::app()->user->checkAccess('admin'))
			$view = 'view';
			
		$this->render($view,array(
			'model'=>$model,
			'contentModel' => $contentModel,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionSaveAssignment()
	{
		$contentModel=Assignment::loadModel();
		if(isset($_POST['Completed'])) {
			$contentModel->is_complete=true; // because it is not a form field in the post data
			$contentModel->attributes=$_POST['Completed'];
		}
		if(isset($_POST['Completed'])||isset($_POST['Assignment'])) {
			if(!$contentModel->save())
				throw new CHttpException(404,'ERROR could not save assignment.'); // temporary error code
		}
		$this->redirect(array('assignments','term_code'=>$contentModel->term_code,'class_num'=>$contentModel->class_num));
	}

	/**
	 * Updates a particular Book model.
	 * @param integer $bookId the ID of the model to be updated
	 */
	public function actionUpdateBook()
	{
		$contentModel=Book::loadModel();
		$model = Course::loadModel();
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
	public function actionSaveBook()
	{
		$contentModel=Book::loadModel();

		if(isset($_POST['Book']))
		{
			if(!$contentModel->save())
				throw new CHttpException(404,'ERROR could not save book.'); // temporary error code
		}
		$this->redirect(array('books','term_code'=>$contentModel->term_code,'class_num'=>$contentModel->class_num));
	}

	/**
	 * Display courses for a term.
	 */
	public function actionCourses($term_code=null)
	{
		$model = Course::loadModel();
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
	public function actionAssignmentFiles()
	{
		$contentModel=Assignment::loadModel();
		$model = Course::loadModel($contentModel->attributes);
		$this->render('assignmentFiles',array(
			'model'=>$model,
			'contentModel' => $contentModel,
		));
	}

	/**
	 * sets up default view options for rendering, called by super class render and passed to  view.
	 */
	public function setDefaultViewOptions($model)
	{
		$this->viewOptions['menuView'] = '../layouts/_courseMenu';  // default
		$this->viewOptions['title'] = $model->title .' (' .$model->idString().')';
		$this->viewOptions['activeTab'] = "courses";
	}
	
	
}
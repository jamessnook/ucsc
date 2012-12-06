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
				'actions'=>array('createAssignment','updateAssignment', 'saveAssignment', 'createBook','updateBook', 'saveBook', 'studentAssignments', 'description', 'assignments', 'books', 'students', 'createAssignment', 'createBook'),
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
	    if (!Yii::app()->user->checkAccess('admin')){
			return $this->actionViewAssignment();
	    }
		$this->contentModel=Assignment::loadModel();
		$this->model = Course::loadModel(array('term_code' => $this->contentModel->term_code, 'class_num' => $this->contentModel->class_num));
		$this->renderView(array(
			'contentView' => '../assignment/_edit',
			'contentTitle' => 'Update Assignment',
			'createNew'=>false,
			'titleNavRight' => '<a href="' . $this->createUrl('course/createAssignment', array('content'=> 'assignment', 'term_code'=> $this->model->term_code, 'class_num'=>$this->model->class_num)) . '"><i class="icon-plus"></i> Add Request</a>',
			'action'=>Yii::app()->createUrl("course/saveAssignment", array('term_code'=>$this->model->term_code, 'class_num'=>$this->model->class_num, 'id'=>$this->contentModel->id)),
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
		$this->contentModel=Book::loadModel();
		if($this->contentModel===null)
			throw new CHttpException(404,'The requested book does not exist here.');
			
		$this->renderView(array(
			'contentView' => '../book/_edit',
			'contentTitle' => 'Update Book',
			'createNew'=>false,
			'titleNavRight' => '<a href="' . $this->createUrl('book/create') . '"><i class="icon-plus"></i> Add Request</a>',
			'action'=>Yii::app()->createUrl("course/saveBook", array('term_code'=>$this->model->term_code, 'class_num'=>$this->model->class_num, 'id'=>$this->contentModel->id)),
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
		// if you are not staf or admin you can only see your own courses
		if (!Yii::app()->user->checkAccess('admin') && !Yii::app()->user->checkAccess('staff')){
			$this->model->username = Yii::app()->user->name;
		}
		$this->renderView(array(
			'contentView' => '../course/_list',
			'menuView' => '../layouts/_termMenu',
			'menuRoute' => 'course/courses',
			'title' => 'All Courses',
		));
	}

	
	/**
	 * Display List of Files for an assignment and user.
	 */
	public function actionAssignmentFiles()
	{
		$this->contentModel=Assignment::loadModel();
		$this->model = Course::loadModel($this->contentModel->attributes);
		$this->renderView(array(
			'contentView' => '../assignment/_listFiles',
		));
	}

	/**
	 * display students for the course.
	 */
	public function actionStudents()
	{
		$this->renderView(array(
			'contentView' => '../user/_list',
			'dataProvider' => $this->model->students(),
			'contentTitle' => 'Course Students',
		));
	}
	
	/**
	 * display students for the course.
	 */
	public function actionBooks()
	{
		$this->renderView(array(
			'contentView' => '../book/_list',
			'titleNavRight' => '<a href="' . $this->createUrl('course/createBook', array('content'=> 'book', 'term_code'=> $this->model->term_code, 'class_num'=>$this->model->class_num)) . '"><i class="icon-plus"></i> New Book </a>',
		));
	}
	
	/**
	 * display students for the course.
	 */
	public function actionAssignments()
	{
		$this->renderView(array(
			'contentView' => '../assignment/_list',
			'titleNavRight' => '<a href="' . $this->createUrl('course/createAssignment', array('content'=> 'assignment', 'term_code'=> $this->model->term_code, 'class_num'=>$this->model->class_num)) . '"><i class="icon-plus"></i> Add Request</a>',
		));
	}
	
	/**
	 * display students for the course.
	 */
	public function actionViewAssignment()
	{
		$this->contentModel=Assignment::loadModel();
		$this->renderView(array(
			'contentView' => '../assignment/_view',
		));
	}
	
	/**
	 * display students for the course.
	 */
	public function actionCreateBook()
	{
		$this->renderView(array(
			'contentView' => '../book/_edit',
			'contentTitle' => 'Create Book',
			'createNew'=>true,
			'action'=>Yii::app()->createUrl("course/saveBook", array('term_code'=>$this->model->term_code, 'class_num'=>$this->model->class_num)),
		));
	}
	
	/**
	 * display students for the course.
	 */
	public function actionCreateAssignment()
	{
		$this->renderView(array(
			'contentView' => '../assignment/_edit',
			'contentTitle' => 'Create Assignment',
			'createNew'=>true,
			'action'=>Yii::app()->createUrl("course/saveAssignment", array('term_code'=>$model->term_code, 'class_num'=>$model->class_num)),
		));
	}
	
	/**
	 * display students for the course.
	 */
	public function actionDescription()
	{
		$this->renderView(array(
			'contentView' => '_description',
		));
	}
	
	
	/**
	 * sets up default view options for rendering, called by super class render and passed to  view.
	 */
	public function setDefaultViewOptions()
	{
		$this->viewOptions['menuView'] = '../layouts/_courseMenu';  // default
		$this->viewOptions['title'] = $this->model->title .' (' .$this->model->idString().')';
		$this->viewOptions['activeTab'] = "courses";
	}
	
	
}
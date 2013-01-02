<?php

/**
 * AssignmentController is the controller class for viewing and managing courses and related data.
 *
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.controllers
 */
class CourseController extends Controller
{
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
				'actions'=>array('index','assignments','books','courses','students','assignmentFiles', 'updateAssignment', 'description'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('createAssignment','updateAssignment', 'saveAssignment', 
					'createBook','updateBook', 'saveBook', 'studentAssignments', 'description', 
					'assignments', 'books', 'students', 'createAssignment', 'createBook', 'manageBook',
					'emails', 'saveEmail', 'updateEmail', 'createEmail', 'sendEmail', 'removeEmail'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a page to alow editing of an existing Assignment model. 
	 * Get and Post parameters are obtained from request. 
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
			'action'=>Yii::app()->createUrl("course/saveAssignment", array('term_code'=>$this->model->term_code, 'class_num'=>$this->model->class_num, 'id'=>$this->contentModel->id)),
			'navRight' => array(
				'label'=>' Add Assignment',
				'url'=>$this->createUrl('course/saveAssignment', array('term_code'=>$this->model->term_code, 'class_num'=>$this->model->class_num, 'content'=> 'assignment', )),
			),
		));
	}

	/**
	 * Saves a new Assignment model or updates an old Assignment model in the database. 
	 * Get and Post parameters are obtained from request. 
	 */
	public function actionSaveAssignment()
	{
		$contentModel=Assignment::loadModel();
		if(isset($_POST['Completed'])) {
			$contentModel->is_complete=true; // because it is not a form field in the post data
			$contentModel->attributes=$_POST['Completed'];
		}
		if(!$contentModel->save())
			throw new CHttpException(404,'ERROR could not save assignment.'); // temporary error code
		$this->redirect(array('assignments','term_code'=>$contentModel->term_code,'class_num'=>$contentModel->class_num));
	}

	/**
	 * Displays a page to allow editing of an existing Book model. 
	 */
	public function actionUpdateBook()
	{
		$this->contentModel=Book::loadModel();
		$this->renderView(array(
			'contentView' => '../book/_edit',
			'contentTitle' => 'Update Book',
			'createNew'=>false,
			'navRight' => array(
				'label'=>' New Book',
				'url'=>$this->createUrl('course/createBook', array('term_code'=>$this->model->term_code, 'class_num'=>$this->model->class_num,)),
			),
			'action'=>Yii::app()->createUrl("course/saveBook", array('term_code'=>$this->model->term_code, 'class_num'=>$this->model->class_num, 'id'=>$this->contentModel->id)),
		));
	}

	/**
	 * Displays page to manage files and book purchase records associated with a particular Book model.
	 */
	public function actionManageBook()
	{
		$this->contentModel=Book::loadModel();
		$this->renderView(array(
			'contentView' => '../book/_manage',
			'contentTitle' => 'Manage Book: &nbsp;' . $this->contentModel->title,
			'navRight' => array(
				'label'=>' New Book',
				'url'=>$this->createUrl('course/createBook', array('term_code'=>$this->model->term_code, 'class_num'=>$this->model->class_num,)),
			),
			'action'=>Yii::app()->createUrl("course/saveBook", array('term_code'=>$this->model->term_code, 'class_num'=>$this->model->class_num, 'id'=>$this->contentModel->id)),
		));
	}

	/**
	 * Displays a page to allow editing of an existing Email model. 
	 */
	public function actionUpdateEmail()
	{
		$this->contentModel=Email::loadModel();
		$this->renderView(array(
			'contentView' => '../email/_edit',
			'contentTitle' => 'Update Email',
			'createNew'=>false,
			'titleNavRight' => '<a href="' . $this->createUrl('course/createEmail', array('term_code'=>$this->model->term_code, 'class_num'=>$this->model->class_num,)) . '"><i class="icon-plus"></i> New Email</a>',
			'action'=>Yii::app()->createUrl("course/saveEmail", array('term_code'=>$this->model->term_code, 'class_num'=>$this->model->class_num, 'id'=>$this->contentModel->id)),
		));
	}

	/**
	 * Saves a new Email model or updates an old Email model in the database. 
	 */
	public function actionSaveEmail($id=null)
	{
		$contentModel=Email::loadModel();
		$contentModel->setIsNewRecord(true); // force save as a new version, we need to keep for reference but disable the old one
		$contentModel->id = null;
		$contentModel->enabled=1;
		if(!$contentModel->save()){
			throw new CHttpException(404,'ERROR could not save email.'); // temporary error code
		}
		$this->actionRemoveEmail($id);
	}

	/**
	 * Clears the enabled flag of an email in the database so it will not be offered for use any more.
	 */
	public function actionRemoveEmail($id=null)
	{
		if (isset($id)){  // mark previous version as disabled
			$oldEmail = Email::model()->findByPk($id);
			$oldEmail->enabled=0;
			$oldEmail->save();
		}
		$this->redirect(array('emails','term_code'=>$this->model->term_code,'class_num'=>$this->model->class_num));
	}

	/**
	 * Sends an email to the instructors of a course and records teh event in the database.
	 */
	public function actionSendEmail()
	{
		$contentModel=EmailSent::loadModel();
		// add code to actually send the email here
		if(!$contentModel->save())
				throw new CHttpException(404,'ERROR could not send email.'); // temporary error code
		$this->redirect(array('emails','term_code'=>$this->model->term_code,'class_num'=>$this->model->class_num));
	}

	/**
	 * Saves a new Book model or updates an old Book model in the database. 
	 */
	public function actionSaveBook()
	{
		$contentModel=Book::loadModel();

		if(isset($_POST['Book']))
		{
			if(!$contentModel->save())
				throw new CHttpException(404,'ERROR could not save book.'); // temporary error code
		}
		$this->redirect(array('books','term_code'=>$this->model->term_code,'class_num'=>$this->model->class_num));
	}

	/**
	 * Display a list of courses for a term.
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
	 * Display a list of Files for an assignment and user.
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
	 * display a lis t of students for a course.
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
	 * display a list of emails sent or availabe to be sent for the course.
	 */
	public function actionEmails()
	{
		$this->renderView(array(
			'contentView' => '../email/_list',
			'titleNavRight' => '<a href="' . $this->createUrl('course/createEmail', array( 'term_code'=> $this->model->term_code, 'class_num'=>$this->model->class_num)) . '"><i class="icon-plus"></i> New Email </a>',
		));
	}
	
	/**
	 * display a list of books associated with a course.
	 */
	public function actionBooks()
	{
		$this->renderView(array(
			'contentView' => '../book/_list',
			'titleNavRight' => '<a href="' . $this->createUrl('course/createBook', array('content'=> 'book', 'term_code'=> $this->model->term_code, 'class_num'=>$this->model->class_num)) . '"><i class="icon-plus"></i> New Book </a>',
		));
	}
	
	/**
	 * display a list of assignments associated with a course.
	 */
	public function actionAssignments()
	{
		$this->renderView(array(
			'contentView' => '../assignment/_list',
			'titleNavRight' => '<a href="' . $this->createUrl('course/createAssignment', array('content'=> 'assignment', 'term_code'=> $this->model->term_code, 'class_num'=>$this->model->class_num)) . '"><i class="icon-plus"></i> Add Assignment </a>',
		));
	}
	
	/**
	 * display data for an assignemnt associated with a course course.
	 */
	public function actionViewAssignment()
	{
		$this->contentModel=Assignment::loadModel();
		$this->model = Course::loadModel(array('term_code' => $this->contentModel->term_code, 'class_num' => $this->contentModel->class_num));
		$this->renderView(array(
			'contentView' => '../assignment/_view',
		));
	}
	
	/**
	 * Displays a page to fill in the data and save a new Email model. 
	 */
	public function actionCreateEmail()
	{
		$this->contentModel=Email::loadModel();
		$this->renderView(array(
			'contentView' => '../email/_edit',
			'contentTitle' => 'Create Email',
			'createNew'=>true,
			'action'=>Yii::app()->createUrl("course/saveEmail", array('term_code'=>$this->model->term_code, 'class_num'=>$this->model->class_num)),
		));
	}
	/**
	 * Displays a page to fill in the data and save a new Book model. 
	 */
	public function actionCreateBook()
	{
		$this->contentModel=Book::loadModel();
		$this->renderView(array(
			'contentView' => '../book/_edit',
			'contentTitle' => 'Create Book',
			'createNew'=>true,
			'action'=>Yii::app()->createUrl("course/saveBook", array('term_code'=>$this->model->term_code, 'class_num'=>$this->model->class_num)),
		));
	}
	
	/**
	 * Displays a page to fill in the data and save a new Assignment model. 
	 */
	public function actionCreateAssignment()
	{
		$this->contentModel=Assignment::loadModel();
		$this->renderView(array(
			'contentView' => '../assignment/_edit',
			'contentTitle' => 'Create Assignment',
			'createNew'=>true,
			'action'=>Yii::app()->createUrl("course/saveAssignment", array('term_code'=>$this->model->term_code, 'class_num'=>$this->model->class_num)),
		));
	}
	
	/**
	 * display the description page for the course.
	 */
	public function actionDescription()
	{
		$this->renderView(array(
			'contentView' => '_description',
		));
	}
	
	
	/**
	 * sets up default view options for rendering, called by super class render and passed to view.
	 */
	public function setDefaultViewOptions()
	{
		$this->viewOptions['menuView'] = '../layouts/_courseMenu';  // default
		$this->viewOptions['title'] = $this->model->title .' (' .$this->model->idString().')';
		$this->viewOptions['activeTab'] = "courses";
	}
	
	
}
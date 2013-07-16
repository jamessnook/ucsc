<?php

/**
 * AssignmentController is the controller class for viewing and managing users and related data.
 *
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.controllers
 */
class DrcUserController extends UserController
{
	/**
	 * @var string the default layout for the views.  Set to use file with no layout.
	 * Layout is instead provided by //layouts/_main which is container for all views in this app.
	 * This is done so parameters can be passed to the layout without modifying standard Yii classes.
	 */
	//public $layout='/modules/base/views/layouts/noLayout';
	
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
			array('allow', // allow authenticated user to perform 'courses' and 'view' actions
				'actions'=>array('index', 'view'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform view type actions
				'actions'=>array('courses',),
				'expression'=>'$user->name == $_REQUEST["username"]',
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete','save','update', 'courses', 'index', 'view', 'create', 'students', 'faculty', 'staff', 'setFileType'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	
	/**
	 * Displays form to update data for an existing user.
	 */
	public function actionUpdate()
	{
	    if (!Yii::app()->user->checkAccess('admin')){
			return $this->actionView();
	    }
		$this->model = DrcUser::loadModel();
		if($this->model===null)
			throw new CHttpException(404,'The requested user does not exist.');
		$this->renderView(array(
			'contentView' => '../drcUser/_edit',
			'contentTitle' => 'Update User Data',
			'createNew'=>false,
			'titleNavRight' => '<a href="' . $this->createUrl('base/user/create') . '"><i class="icon-plus"></i> Add User </a>',
			'action'=>Yii::app()->createUrl("user/save", array('username'=>$this->model->username)),
		));
	}
	
	
	/**
	 * Displays a list of students for a specific term.
	 */
	public function actionStudents()
	{
		//$this->model = User::loadModel();
		$this->renderView(array(
			'contentView' => '//drcUser/_list',
			'dataProvider' => $this->model->students(),
			'contentTitle' => 'DRC Students',
			'titleNavRight' => '<a href="' . $this->createUrl('base/user/create') . '"><i class="icon-plus"></i> Add User </a>',
			'menuView' => 'base.views.layouts._termMenu',
		));
	}
	
	/**
	 * Displays a list of staff.
	 */
	public function actionStaff()
	{
		//$this->model = User::loadModel();
		$this->renderView(array(
			'contentView' => '../drcUser/_staff',
			'title' => 'DRC User Accounts',
			'titleNavRight' => '<a href="' . $this->createUrl('base/user/create') . '"><i class="icon-plus"></i> Add User </a>',
			'menuView' => '',
			'activeTab' => 'staff',
		));
	}
	
	/**
	 * Displays a list of faculty for a specific term.
	 */
	public function actionFaculty()
	{
		//$this->model = User::loadModel();
		$this->renderView(array(
			'contentView' => '../drcUser/_list',
			'dataProvider' => $this->model->faculty(),
			'contentTitle' => 'Faculty',
			'titleNavRight' => '<a href="' . $this->createUrl('base/user/create') . '"><i class="icon-plus"></i> Add User </a>',
			'menuView' => 'base.views.layouts._termMenu',
			'menuRoute' => 'drcUser/faculty',
			'activeTab' => 'faculty',
		));
	}
	
	/**
	 * Displays a list of courses for a drc student or faculty and term.
	 */
	public function actionCourses()
	{
		//echo "In Courses";
		if (!isset($_REQUEST['username'])){
			$_REQUEST['username'] = Yii::app()->user->name;
		}
		//if (!Yii::app()->user->checkAccess('admin')){
		//	$this->model=User::model()->findByPk(Yii::app()->user->name);
		//} else {
			$this->model = DrcUser::loadModel();
			//}
		//$title = "Title";
		//$contentTitle = "Courses: title";
		$title = "({$this->model->username}) {$this->model->first_name} {$this->model->last_name}";
		$contentTitle = "Courses: {$this->model->term->description}";
		if (!Yii::app()->user->checkAccess('admin') && !Yii::app()->user->checkAccess('staff')){
			$title = $this->model->term->description;
			$contentTitle = "Courses";
		}
		$this->renderView(array(
			'title' => $title,
			'contentView' => '../course/_list',
			'contentTitle' => $contentTitle,
			'menuView' => 'base.views.layouts._termMenu',
			'menuRoute' => 'drcUser/courses',
			'titleNavRight' => '<a href="' . $this->createUrl('drcUser/update', array('term_code'=> $this->model->term_code, 'username'=>$this->model->username)) . '"><i class="icon-plus"></i> User Profile</a>',
		));
	}
	
	/**
	 * Displays a list of courses for a drc student or faculty and term.
	 */
	public function actionSetFileType()
	{
		$contentModel=DrcRequest::loadModel();
		if (isset($_REQUEST['username']) && isset($_REQUEST['term_code']) && isset($_REQUEST['class_num'])){
			if(!$contentModel->save())
				throw new CHttpException(404,'ERROR could not update filetype.'); // temporary error code
		}
		//throw new CHttpException(404,'Data saved: username = ' . $contentModel->username . ', term: '
		//  . $contentModel->term_code . ', class: ' . $contentModel->class_num  . ', type: ' . $contentModel->type ); // temporary debug code
		$this->redirect(array('drcUser/courses','username'=>$this->model->username,'term_code'=>$this->model->term_code));
		//return $this->actionCourses();
	}
	
	/**
	 * sets up default view options for rendering, called by super class renderView and passed to views.
	 */
	
	public function setDefaultViewOptions()
	{
		parent::setDefaultViewOptions();
		$this->viewOptions['menuView']='//layouts/_userMenu';
		$this->viewOptions['activeTab'] = "students";
		$model = $this->model;
		if ($model->username){
			if(Yii::app()->authManager->checkAccess('staff', $model->username))
				$this->viewOptions['activeTab'] = "staff";
			if (Yii::app()->authManager->checkAccess('admin', $model->username)) 
				$this->viewOptions['activeTab'] = "staff";
			if (Yii::app()->authManager->checkAccess('faculty', $model->username)) 
				$this->viewOptions['activeTab'] = "faculty";
		}
	}
	
}

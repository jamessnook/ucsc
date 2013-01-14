<?php

/**
 * AssignmentController is the controller class for viewing and managing users and related data.
 *
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.controllers
 */
class UserController extends Controller
{
	/**
	 * @var string the default layout for the views.  Set to use file with no layout.
	 * Layout is instead provided by //layouts/_main which is container for all views in this app.
	 * This is done so parameters can be passed to the layout without modifying standard Yii classes.
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
			array('allow', // allow authenticated user to perform 'courses' and 'view' actions
				'actions'=>array('index', 'courses', 'view'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete','save','update', 'courses', 'index', 'view', 'create', 'users', 'faculty', 'staff'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Saves a new User model or updates an old User model in the database. 
	 * Get and Post parameters are obtained from request. 
	 */
	public function actionSave()
	{
		$model = User::loadModel();

		if(isset($_POST['User'])){
			//echo $model->first_name . '  ' . $_POST['User']['first_name'];
			if(!$model->save()) {
				throw new CHttpException(404,'ERROR could not save user data.'); // temporary error code
			}
		}
		//echo "save";
		$this->redirect(Yii::app()->request->getUrlReferrer()); // back from wence yee came
	}

	/**
	 * Deletes a particular User model.
	 * If deletion is successful, the browser will be redirected to the caller page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			User::loadModel()->delete();
			$this->redirect(Yii::app()->request->getUrlReferrer());
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Displays data for a single user.
	 */
	public function actionView()
	{
		//$this->model = User::loadModel();
		$this->renderView(array(
			'contentView' => '../user/_view',
			'menuView' => '../layouts/_userMenu',
		));
	}
	

	/**
	 * Displays a list of all users
	 */
	public function actionUsers()
	{
		//$this->model = User::loadModel();
		$this->renderView(array(
			'contentView' => '../user/_list',
			'dataProvider' => $this->model->users(),
			'contentTitle' => 'All Word List Users',
			'titleNavRight' => '<a href="' . $this->createUrl('user/create') . '"><i class="icon-plus"></i> Add User </a>',
			'menuView' => '../layouts/_userMenu',
			'menuRoute' => 'user/students',
		));
	}
	
	/**
	 * Displays a list of staff.
	 */
	public function actionStaff()
	{
		//$this->model = User::loadModel();
		$this->renderView(array(
			'contentView' => '../user/_staff',
			'title' => 'DRC User Accounts',
			'titleNavRight' => '<a href="' . $this->createUrl('user/create') . '"><i class="icon-plus"></i> Add User </a>',
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
			'contentView' => '../user/_list',
			'dataProvider' => $this->model->faculty(),
			'contentTitle' => 'Faculty',
			'titleNavRight' => '<a href="' . $this->createUrl('user/create') . '"><i class="icon-plus"></i> Add User </a>',
			'menuView' => '../layouts/_termMenu',
			'menuRoute' => 'user/faculty',
			'activeTab' => 'faculty',
		));
	}
	
	/**
	 * Displays form to update data for an existing user.
	 */
	public function actionUpdate()
	{
	    if (!Yii::app()->user->checkAccess('admin')){
			return $this->actionView();
	    }
		echo "update";
	    $this->model = User::loadModel();
		if($this->model===null)
			throw new CHttpException(404,'The requested user does not exist.');
		$this->renderView(array(
			'contentView' => '../user/_edit',
			'contentTitle' => 'Update User Data',
			'createNew'=>false,
			'titleNavRight' => '<a href="' . $this->createUrl('user/create') . '"><i class="icon-plus"></i> Add User </a>',
			'action'=>Yii::app()->createUrl("user/save", array('username'=>$this->model->username)),
			'menuView' => '../layouts/_userMenu',
		));
	}
	
	/**
	 * Displays form to create data for a new user.
	 */
	public function actionCreate()
	{
		//$this->model = User::loadModel();
		$this->renderView(array(
			'contentView' => '../user/_edit',
			'contentTitle' => 'Create New User',
			'createNew'=>true,
			'activeTab'=>'staff',
			'action'=>$this->createUrl("user/save"),
			'titleNavRight' => '<a href="' . $this->createUrl('user/create') . '"><i class="icon-plus"></i> Add User </a>',
			'menuView' => '../layouts/_userMenu',
		));
	}
	
	/**
	 * Displays a list of courses for a drc student or faculty and term.
	 */
	public function actionCourses()
	{
		//if (!Yii::app()->user->checkAccess('admin')){
		//	$this->model=User::model()->findByPk(Yii::app()->user->name);
		//} else {
			$this->model = User::loadModel();
		//}
		$this->renderView(array(
			'contentView' => '../course/_list',
			'menuView' => '../layouts/_termMenu',
			'menuRoute' => 'user/courses',
			'titleNavRight' => '<a href="' . $this->createUrl('user/update', array('term_code'=> $this->model->term_code, 'username'=>$this->model->username)) . '"><i class="icon-plus"></i> User Profile</a>',
		));
	}
	
	/**
	 * sets up default view options for rendering, called by super class renderView and passed to views.
	 */
	public function setDefaultViewOptions()
	{
		//echo 'tc: ' . $this->model->term_code;
		$model = $this->model;
		$this->viewOptions['title']="($model->username) $model->first_name $model->last_name";
		if (!$model->username || $model->username ==''){
			$this->viewOptions['title'] = "Users";
		}
		$this->viewOptions['activeTab'] = "users";
		$this->viewOptions['action'] = Yii::app()->createUrl("user/save", array('username'=>$this->model->username));
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

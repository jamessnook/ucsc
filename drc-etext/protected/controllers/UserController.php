<?php

class UserController extends Controller
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
			array('allow', // allow authenticated user to perform 'courses' and 'view' actions
				'actions'=>array('index', 'courses', 'view'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete','save','update', 'courses', 'index', 'view', 'create', 'students', 'faculty', 'staff'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionSave()
	{
		$model = User::loadModel();

		if(isset($_POST['User'])){
			if(!$model->save()) {
				throw new CHttpException(404,'ERROR could not save user data.'); // temporary error code
			}
		}
		$this->redirect(Yii::app()->request->getUrlReferrer()); // back from wence yee came
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			User::loadModel()->delete();
			$this->redirect(Yii::app()->request->url);
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

		/**
	 * load form to update user data.
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
	 * load form to update user data.
	 */
	public function actionStudents()
	{
		//$this->model = User::loadModel();
		$this->renderView(array(
			'contentView' => '../user/_list',
			'dataProvider' => $this->model->students(),
			'contentTitle' => 'DRC Students',
			'titleNavRight' => '<a href="' . $this->createUrl('user/create') . '"><i class="icon-plus"></i> Add User </a>',
			'menuView' => '../layouts/_termMenu',
			'menuRoute' => 'user/students',
		));
	}
	
	/**
	 * load form to update user data.
	 */
	public function actionStaff()
	{
		//$this->model = User::loadModel();
		$this->renderView(array(
			'contentView' => '../user/_staff',
			'title' => 'Curent DRC User Accounts',
			'titleNavRight' => '<a href="' . $this->createUrl('user/create') . '"><i class="icon-plus"></i> Add User </a>',
			'menuView' => '',
			'activeTab' => 'staff',
		));
	}
	
		/**
	 * load form to update user data.
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
	 * load form to update user data.
	 */
	public function actionUpdate()
	{
	    if (!Yii::app()->user->checkAccess('admin')){
			return $this->actionView();
	    }
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
	 * load form to create new user.
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
	 * Display courses for a drc student.
	 */
	public function actionCourses()
	{
		if (!Yii::app()->user->checkAccess('admin')){
			$this->model=User::model()->findByPk(Yii::app()->user->name);
		} else {
			$this->model = User::loadModel();
		}
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
		if (!isset($this->model->term_code)){
			$this->model->term_code = Term::currentTermCode();
		}
		//echo 'tc: ' . $this->model->term_code;
		$model = $this->model;
		$this->viewOptions['title']="($model->username) $model->first_name $model->last_name";
		if (!$model->username || $model->username ==''){
			$this->viewOptions['title'] = "Users";
			if ($model->term_code){
				//$term=Term::model()->findByPk($model->term_code);
				//$this->viewOptions['title'] = $term->description;
			}
		}
		$this->viewOptions['activeTab'] = "students";
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

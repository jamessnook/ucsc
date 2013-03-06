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
				'actions'=>array('delete','save','update', 'courses', 'index', 'view', 'create', 'students', 'faculty', 'staff'),
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
			if(!$model->save()) {
				throw new CHttpException(404,'ERROR could not save user data.'); // temporary error code
			}
		}
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
		$this->model = User::loadModel();
		if($this->model===null)
			throw new CHttpException(404,'The requested user does not exist.');
		$this->renderView(array(
			'contentView' => '../user/_edit',
			'contentTitle' => 'Update User Data',
			'createNew'=>false,
			'titleNavRight' => '<a href="' . $this->createUrl('user/create') . '"><i class="icon-plus"></i> Add User </a>',
			'action'=>Yii::app()->createUrl("user/save", array('username'=>$this->model->username)),
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
		));
	}
	
	/**
	 * sets up default view options for rendering, called by super class renderView and passed to views.
	 */
	public function setDefaultViewOptions()
	{
		parent::setDefaultViewOptions();
		if (!isset($this->model->term_code)){
			$this->model->term_code = Term::currentTermCode();
		}
		//echo 'tc: ' . $this->model->term_code;
		$model = $this->model;
		$this->viewOptions['menuView']='../layouts/_userMenu';
		$this->viewOptions['title']="($model->username) $model->first_name $model->last_name";
		if (!$model->username || $model->username ==''){
			$this->viewOptions['title'] = "Users";
			if ($model->term_code){
				//$term=Term::model()->findByPk($model->term_code);
				//$this->viewOptions['title'] = $term->description;
			}
		}
	}
	
}

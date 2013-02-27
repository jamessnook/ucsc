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
			'menuView' => 'base.views.layouts._termMenu',
			'menuRoute' => 'drcUser/courses',
			'titleNavRight' => '<a href="' . $this->createUrl('base/user/update', array('term_code'=> $this->model->term_code, 'username'=>$this->model->username)) . '"><i class="icon-plus"></i> User Profile</a>',
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

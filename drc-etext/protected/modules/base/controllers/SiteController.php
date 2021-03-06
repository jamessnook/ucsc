<?php

/**
 * SiteController is the controller class for site wide actions not related to a specific model.
 *
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.controllers
 */
class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
			// import databases to mysql
			'import'=>array(
				'class'=>'modules.base.components.actions.ImportDbAction',
                'fileName'=>'etext.sql',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		//$this->render('index');
		$this->redirect(Yii::app()->createUrl('login/login'));
	}

	/**
	 * This dumps a big page of PHP config information.
	 */
	public function actionPhpinfo()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		//$this->render('index');
		phpinfo();
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else {
	        	//$this->render('error', $error);
	        	$this->_model = $error;
				$this->renderView(array(
					'contentView' => 'base.views.site.error',
					'title' => 'Error ' . $error['code'] ,
					'message' =>  $error['message'] ,
					'menuView' => 'none',
				));
	    	}
	    }
	}

	/**
	 * This is the action to display an about page.
	 */
	public function actionAbout()
	{
		$this->renderView(array(
			'contentView' => 'base.views.site.about',
			'title' => 'About ' . Yii::app()->name,
			'menuView' => 'none',
		));
	}

	/**
	 * Displays the contact page / not currently used
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$this->redirect(Yii::app()->createUrl('login/login'));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	/**
	 * Requests data from web service feed and updates local database.
	 */
	public function actionUpdate($server='AIS', $service='classes')
	{
		$params = array();
		if (isset($_GET['emplid'])){
			$params['emplid']=$_GET['emplid'];
		}
		Yii::app()->updater->update($server, $service, $params);
		//$this->redirect(Yii::app()->homeUrl);
	}
	
	/**
	 * Displays the login page
	 */
	public function actionCreateITR()
	{
		$this->_model = new ITRForm;
		// collect user input data
		if(isset($_POST['ITRForm']))
		{
			$this->model->attributes=$_POST['ITRForm'];
			//validate user input and redirect to the previous page if valid
			if($this->model->validate() && $this->model->createITR()){
				$this->redirect($this->model->returnUrl);
			}
		}
		// display the ITR form
		$this->renderView(array(
			'contentView' => 'base.views.site.createITR',
			'title' => 'Create ITR Ticket',
			'menuView' => 'none',
		));
	}

	/**
	 * Returns the model for this controller.
	 * Creates model if not yet set.
	 */
	public function getModel()
	{
		return $this->_model;
	}
}
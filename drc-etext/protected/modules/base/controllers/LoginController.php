<?php

require_once('UserIdentity.php');

Yii::import('base.vendors.simplesaml.*');		
Yii::import('base.vendors.simplesaml.lib.*');		
Yii::import('base.vendors.simplesaml.lib.SimpleSAML.*');		
Yii::import('base.vendors.simplesaml.lib.SimpleSAML.Auth.*');		
Yii::import('base.vendors.simplesaml.config.*');		
require_once('_autoload.php');
require_once('Simple.php');
require_once('Session.php');
require_once('SessionHandler.php');
require_once('Store.php');

/**
 * LoginController is the controller class for managing user login and logout.
 *
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.controllers
 */
class LoginController extends Controller
{
	public $userEmailTag = 'urn:oid:1.3.6.1.4.1.5923.1.1.1.6';
	
	public function actionIndex()
	{
			$this->actionLogin();
	}

	/**
	 * Chooses the login method if any
	 */
	public function actionLogin()
	{
		if(Yii::app()->params['samlLogin'] == true){
			$this->actionSamlLogin();
		}
		else if(Yii::app()->params['localLogin'] == true){
			$this->actionLocalLogin();
		}
		else {
			$this->login('guest');
		}
	}
	
	/**
	 * Complete the login
	 */
	public function login($username)
	{
		// login the user to yii app
		$identity=new UserIdentity($username,'');
		if ($identity->authenticate()){
			Yii::app()->user->login($identity);
			if (Yii::app()->user->checkAccess('admin')){
				$this->redirect($this->createUrl('user/students'));
			} else {
				$this->redirect($this->createUrl('user/courses', array('username'=>Yii::app()->user->name,)));
			}
		} else {
			$this->render('loginFail');
		}
	}
	
	/**
	 * Displays the login page
	 */
	public function actionLocalLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				//$this->redirect(Yii::app()->user->returnUrl);
				if (Yii::app()->user->checkAccess('admin')){
					$this->redirect($this->createUrl( Yii::app()->params['adminHomePage']));
				} else {
					$this->redirect($this->createUrl( Yii::app()->params['homePage'], array('username'=>Yii::app()->user->name,)));
				}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
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
	 * Initiates SimpleSaml login and authentication 
	 */
	public function actionSamlLogin()
	{
		// login the user to yii app
		$identity=new SamlUserIdentity($username,'');
		if ($identity->authenticate()){
			$this->login($identity->username);
		} else {
			$this->render('loginFail');
		}
	}
	

}
<?php

require_once('UserIdentity.php');

/**
 * LoginController is the controller class for managing user login and logout.
 *
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.controllers
 */
class LoginController extends Controller
{
	
	public function actionIndex()
	{
			$this->actionIntro();
	}

	/**
	 * Go to initial landing page if needed
	 */
	public function actionIntro()
	{
		// display the login form
		$this->render('intro');
	}
	
	/**
	 * Go to initial landing page if needed
	 */
	public function actionSwitchUser()
	{
		// display the login form
			$this->login($_REQUEST['username']);
	}
	
	/**
	 * Chooses the login method if any
	 */
	public function actionLogin()
	{
		if(Yii::app()->params['samlLogin'] == true){
			$this->actionSamlLogin();
		}
		else if(Yii::app()->params['localLogin'] == true && isset($_POST['LoginForm'])){
			//$this->actionLocalLogin();
				$this->login($_POST['LoginForm']['username']);
			
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
				$this->redirect($this->createUrl( Yii::app()->params['adminHomePage']));
			} else {
				$this->redirect($this->createUrl( Yii::app()->params['homePage'], array('username'=>Yii::app()->user->name,)));
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
		//$identity=new SamlUserIdentity();
		$identity=Yii::app()->saml;
		if ($identity->authenticate()){
			$this->login($identity->username);
		} else {
			$this->render('loginFail');
		}
	}
	

}
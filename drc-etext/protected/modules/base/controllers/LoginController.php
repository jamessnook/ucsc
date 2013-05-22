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
		//$this->render('intro');
		$this->renderView(array(
			'title' => 'Welcome',
			'contentView' => 'base.views.login.intro',
			'menuView' => 'none',
		));
	}
	
	/**
	 * Go to initial landing page if needed
	 */
	public function actionSwitchUser()
	{
		// re- login the user to yii app
		if(isset($_POST['LoginForm']))
		{
			$username=$_POST['LoginForm']['username'];
		} else {
			$username = $_REQUEST['username'];
		}
		$identity=new UserIdentity($username,'');
		if ($identity->authenticate()){
			Yii::app()->user->login($identity);
			$this->finishLogin();			
		} else {
			//$this->render('loginFail');
			$this->renderView(array(
				'contentView' => 'base.views.login.loginFail',
				'title' => 'Login Failed',
				'menuView' => 'none',
			));
		}
	}
	
	/**
	 * Chooses the authentication method if any
	 */
	public function actionLogin()
	{
		if(Yii::app()->params['samlLogin'] == true){
			$this->actionSamlLogin();
		}
		else if(Yii::app()->params['localLogin'] == true ){
			$this->actionLocalLogin();
			
		}
		else {
			$this->login('guest');
		}
	}
	
	/**
	 * Complete the login
	 */
	public function authorize($username)
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
			//$this->render('loginFail');
			$this->renderView(array(
				'contentView' => 'base.views.login.loginFail',
				'title' => 'Login Failed',
				'menuView' => 'none',
			));
		}
	}
	
	/**
	 * Displays the login page
	 */
	public function actionLocalLogin()
	{
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$this->model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($this->model->validate() && $this->model->login())
				$this->finishLogin();			
		}
		// display the login form
		//$this->render('login',array('model'=>$model));
		$this->renderView(array(
			'contentView' => 'base.views.login.login',
			'title' => 'Login',
			'menuView' => 'none',
		));
	}

			
	/**
	 * Complete the login and displays the login page
	 */
	public function finishLogin()
	{
		if (Yii::app()->user->checkAccess('admin')){
            Yii::app()->user->setState('isAdmin', true);
			$this->redirect($this->createUrl( Yii::app()->params['adminHomePage']));
		} else {
			$this->redirect($this->createUrl( Yii::app()->params['homePage'], array('username'=>Yii::app()->user->name,)));
		}
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
			$identity=new UserIdentity($username,'');
			if ($identity->authenticate()){
				Yii::app()->user->login($identity);
				$this->finishLogin();			
				return;
			}
		}
		//$this->render('loginFail');
		$this->renderView(array(
			'contentView' => 'base.views.login.loginFail',
			'title' => 'Login Failed',
			'menuView' => 'none',
		));
	}
	
	/**
	 * Returns the model for this controller.
	 * Creates model if not yet set.
	 */
	public function getModel()
	{
		if (!$this->_model){
			$this->_model = new LoginForm;
		}
		return $this->_model;
	}
	
}
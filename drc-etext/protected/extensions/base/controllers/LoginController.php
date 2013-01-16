<?php
Yii::import('application.extensions.*');
require_once('base/components/UserIdentity.php');
Yii::import('application.vendors.simplesamlphp.*');		
Yii::import('application.vendors.simplesamlphp.lib.*');		
//require_once('_autoload.php');

/**
 * AssignmentController is the controller class for managing user login and logout.
 *
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.controllers
 */
class LoginController extends Controller
{
	/**
	 * Override parent empty method to provide needed initialization.
	 */
	public function actionLoginSimpleSaml()
	{
		// set up for simple saml
	    // temporary disable Yii autoloader
	    spl_autoload_unregister(array('YiiBase','autoload'));
	
	    // create 3rd-party object
	    require_once('_autoload.php');
	    // enable Yii autoloader
	    spl_autoload_register(array('YiiBase','autoload'));
	
		$as = new SimpleSAML_Auth_Simple('default-sp');
		$as->requireAuth();
		// or to specify login params
		//$as->requireAuth($params);
		/*
		 * Return the user to the frontpage after authentication, don't post
		 * the current POST data.
		 */
		$as->requireAuth(array(
		    'ReturnTo' => 'https://sp.example.org/',
		    'KeepPost' => FALSE,
		));
		print("Hello, authenticated user!");
		// test
		$attributes = $as->getAttributes();
		print_r($attributes);
		// test
		if (!$as->isAuthenticated()) {
		    /* Show login link. */
		    print('<a href="/login">Login</a>');
		}
		// option use specific idp
		$as->login(array(
    		'saml:idp' => 'https://idp.example.org/',
		));
		
	}
	
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
			$this->samlAuthRequest();
		}
		else if(Yii::app()->params['localLogin'] == true){
			$this->loginLocal();
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
			//$this->redirect(Yii::app()->homeUrl);
			//$this->redirect($this->createUrl('user/students'));
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
	public function loginLocal()
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
					$this->redirect($this->createUrl('user/students'));
				} else {
					$this->redirect($this->createUrl('user/courses', array('username'=>Yii::app()->user->name,)));
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
	 * Redirects the user to the remote SAML2 authentication server.
	 */
	public function samlAuthRequest()
	{
		//Yii::app()->saml->settings->spReturnUrl = $this->createAbsoluteUrl('login/samlResponse');
		$this->redirect(Yii::app()->saml->getRedirectUrl()); // create url 
		//$this->renderPartial('dumpPage', array( 'data'=>Yii::app()->saml->settings->spReturnUrl, ));
	}
	
	/**
	 * Evaluates the response from the remote SAML2 authentication server
	 * and logs the user on if they are OK.
	 */
	public function actionSamlResponse()
	{
		$username = Yii::app()->saml->getUsernameFromResponse($_POST['SAMLResponse']);
		// need to add user authorization and verification of account in this app
		$this->login($username);
	}

	/**
	 * Evaluates the response from the remote SAML2 authentication server
	 * and logs the user on if they are OK.
	 * Alias for actionSamlResponse
	 */
	public function actionShibbolethResponse()
	{
		$this->actionSamlResponse();
	}

	/**
	 * Provides he service provider SAML metadata for this app.
	 */
	public function actionSamlMetadata()
	{
		$this->renderPartial('xmlPage', array( 'xmlString'=>Yii::app()->saml->getMetadata(), ));
	}
		
}
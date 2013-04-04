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
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 * 
 * @author JSnook <jsnook@ucsc.edu>
 * @package drc-etext.protected.components
 */
class SamlUserIdentity extends CUserIdentity
{

	/**
     * The resolved subfolder to upload the file to
     * @var string
     */
    private $_subfolder = "";
    
	/**
	 * Authenticates a user
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
    public function authenticate()
    {
        $username=strtolower($this->username);
        $user=User::model()->find('LOWER(username)=?',array($username));
        if($user===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else
        {
            $this->username=$user->username;
            $this->errorCode=self::ERROR_NONE;
        }
	    return $this->errorCode==self::ERROR_NONE;
    }
    
    /**
	 * Uploads files and Creates new models.
	 * This version works with the yii xupload extension widget
     * @author JSnook
     */
    public function run( ) 
	{
		$as = $this->getSimpleSaml();
		// checks if user is authenticated, if not resopnds with redirect to saml idp server for authentication
		$as->requireAuth(array(
		    'ReturnTo' => $this->createUrl('login/samlResponse'),
		    'KeepPost' => FALSE,
		));
		// only returns if user is already authenticated
		$as = $this->getSimpleSaml();
		$this->login($this->getUsernameFromResponse($as));
	}

		/**
	 * returns a simpleSAML_Auth_Simple object
	 */
	public function getSimpleSaml()
	{
		// set up for simple saml
	    // temporary disable Yii autoloader
	    spl_autoload_unregister(array('YiiBase','autoload'));
	
	    // create 3rd-party object
	    require_once('_autoload.php');
	    // enable Yii autoloader
	    spl_autoload_register(array('YiiBase','autoload'));
	
		return new SimpleSAML_Auth_Simple('ucsc-test--sp');
	}
	
	/**
	 * Initiates SimpleSaml login and authentication 
	 */
	public function actionSimpleSaml()
	{
		$as = $this->getSimpleSaml();

		$as->requireAuth(array(
		    'ReturnTo' => $this->createUrl('login/samlResponse'),
		    'KeepPost' => FALSE,
		));
	}
	
	/**
	 * Evaluates the response from the remote SAML2 authentication server
	 * and logs the user on if they are OK.
	 */
	public function actionSamlResponse()
	{
		$as = $this->getSimpleSaml();
		$this->login($this->getUsernameFromResponse($as));
	}

	/**
	 * Parses the username (cruzid) from the response from the remote SAML2 authentication server
	 * and logs the user on if they are OK.
	 */
	public function getUsernameFromResponse($auth)
	{
		$attrs = $auth->getAttributes();
		if (!isset($attrs[$this->userEmailTag][0])) {
		    throw new Exception('eduPersonPrincipalName attribute missing.');
		}
		$email = $attrs[$this->userEmailTag][0];
		
		// load and parse response
		return substr($email, 0, strpos($email, "@"));
	}
	
    
}

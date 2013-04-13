<?php
require_once('UserIdentity.php');


/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 * 
 * @author JSnook <jsnook@ucsc.edu>
 * @package drc-etext.protected.components
 */
class SamlUserIdentity extends CApplicationComponent
{

	/**
     * The path to the simplsamlphp files
     * @var string
     */
    public $simplesamlPath= "";
    
    
    /**
	 * Authenticates a user
	 * @return boolean whether authentication succeeds.
     * @author JSnook
     */
    public function authenticate( ) 
	{
		$this->enableSimpleSamlAutoload();
		$as = new SimpleSAML_Auth_Simple('ucsc-test--sp');
		// checks if user is authenticated, if not resopnds with redirect to saml idp server for authentication
		$as->requireAuth(array(
		    'ReturnTo' => Yii::app()->request->url, // the url used to get here
		    'KeepPost' => FALSE,
		));
		// only returns if user is already authenticated
		$this->username = $this->getUsernameFromResponse($as);
		if (strlen($this->username>0)){
            $this->errorCode=CUserIdentity::ERROR_NONE;
		}else{
            $this->errorCode=CUserIdentity::ERROR_USERNAME_INVALID;
		}
		$this->enableYiiAutoload();
		return $this->errorCode==CUserIdentity::ERROR_NONE;
	}
	    
	/**
	 * enables simplesaml class autoloader
	 */
	public function enableSimpleSamlAutoload()
	{
		// set up for simple saml
	    // temporary disable Yii autoloader
	    spl_autoload_unregister(array('YiiBase','autoload'));
	
	    // saml autoload 
	    require_once($this->simplesamlPath. '/lib/_autoload.php');
	}
	
		/**
	 * enables yii class autoloader
	 */
	public function enableYiiAutoload()
	{
	    // enable Yii autoloader
	    spl_autoload_register(array('YiiBase','autoload'));
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

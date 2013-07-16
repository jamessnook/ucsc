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
     * The path to the simplsamlphp top directory (the directory which contains the 'lib' subdirectory.)
     * This is required as a config setting for this component
     * @var string
     */
    public $simplesamlPath= "";
	
	/**
     * The id string used in the simplesaml config/authsources file 
     * to idnetify the service provider configurtion to use
     * This is required as a config setting for this component
     * @var string
     */
    public $serviceProviderId = 'default';
	
    /**
     * The xml tag for user emali in saml response
     * @var string
     */
	public $userEmailTag = 'urn:oid:1.3.6.1.4.1.5923.1.1.1.6';
	
    
	/**
     * The username of the authenticated user
     * @var string
     */
    public $username= "";
    
	/**
     * The error code for
     * @var string
     */
    public $errorCode = 0;
    
    
    /**
	 * Authenticates a user
	 * @return boolean whether authentication succeeds.
     * @author JSnook
     */
    public function authenticate( ) 
	{
		$this->errorCode=CUserIdentity::ERROR_NONE;
		$this->enableSimpleSamlAutoload();
		$as = new SimpleSAML_Auth_Simple($this->serviceProviderId);
		// checks if user is authenticated, if not, responds with redirect to saml idp server for authentication
		$as->requireAuth(array(
		    'ReturnTo' => Yii::app()->request->url, // the url used to get here
		    'KeepPost' => FALSE,
		));
		// only returns if user is already authenticated
		$this->enableYiiAutoload();
		$this->username = $this->getUsernameFromResponse($as);
		if (strlen($this->username)==0){
            $this->errorCode=CUserIdentity::ERROR_USERNAME_INVALID;
            return false;
		}
		return true;
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

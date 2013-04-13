<?php
require_once('UserIdentity.php');

Yii::import('simplesaml.*');		
Yii::import('simplesaml.lib.*');		
Yii::import('simplesaml.lib.SimpleSAML.*');		
Yii::import('simplesaml.lib.SimpleSAML.Auth.*');		
Yii::import('simplesaml.config.*');		
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
     * The path to the simplsamlphp files
     * @var string
     */
    public $simplesamlPath= "";
    
    
    /**
	 * Authenticates a user
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
     * @author JSnook
     */
    public function authenticate( ) 
	{
		$as = $this->getSimpleSaml();
		// checks if user is authenticated, if not resopnds with redirect to saml idp server for authentication
		$as->requireAuth(array(
		    'ReturnTo' => Yii::app()->request->url, // the url used to get here
		    'KeepPost' => FALSE,
		));
		// only returns if user is already authenticated
		$as = $this->getSimpleSaml();
		$this->username = $this->getUsernameFromResponse($as);
		if (strlen($this->username>0)){
            $this->errorCode=self::ERROR_NONE;
		}else{
            $this->errorCode=self::ERROR_USERNAME_INVALID;
		}
	    return $this->errorCode==self::ERROR_NONE;
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
	    
		$className= $this->simplesamlPath . '/lib/SimpleSAML/Auth/Simple';
		$aModel=new $className(null);
	    return new SimpleSAML_Auth_Simple('ucsc-test--sp');
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

<?php
/**
 * DownloadAction class file.
 *
 */

/**
 * UploadAction
 * =============
 * Basic file download functionality 
 * @author JSnook 
 * @package base.components.actions
 */
class SamlAuthAction extends CAction {

    /**
     * The name of the model to associate the file with an instance of using 'id'.
     *
     * @var string
     */
    public $modelName;

    /**
     * The resolved subfolder to upload the file to
     * @var string
     */
    private $_subfolder = "";
    
    /**
     * The resolved subfolder to upload the file to
     * @var string
     */
    public $redirectUrl = null;
    
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

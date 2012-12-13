<?php
/**
 * SamlLogin class file.
 *
 */

// import SAML2 library for Shibboleth remote authentication
Yii::import('application.vendors.onelogin.src.OneLogin.Saml.*');		
Yii::import('application.vendors.onelogin.ext.xmlseclibs.*');	
Yii::import('application.vendors.customizations.*');	
// yii autoloader can not handle file names that are not the same as class names
// so we need these extra lines or our own autoloader
require_once 'AuthRequest.php';	
require_once 'Settings.php';	
require_once 'XmlSec.php';	
require_once 'xmlseclibs.php';	

/**
 * SamlLogin encapsulates the configuration  and use of the OneLogin
 * open source libray for remote user authentication using the SAML xml protocol.
 * This includes Shibboleth authentication.
 * 
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.components
*/
class SamlLogin extends CApplicationComponent
{

    /**
     * User Email tag.
     * @var string
     */
	public $userEmailTag;
	
    /**
     * The URL to submit SAML authentication requests to.
     * @var string
     */
    public $idpSingleSignOnUrl = '';

    /**
     * The x509 certificate used to authenticate the request.
     * @var string
     */
    public $idpPublicCertificate = '';

    /**
     * The URL where to the SAML Response/SAML Assertion will be posted.
     * @var string
     */
    public $spReturnRoute = '';

    /**
     * The name of the application.
     * @var string
     */
    public $spIssuer = 'php-saml';

    /**
     * Specifies what format to return the authentication token, i.e, the email address.
     * @var string
     */
    public $requestedNameIdFormat = '';
	
    /**
     * Specifies what format to return the authentication token, i.e, the email address.
     * @var string
     */
    public $settings = null;
	
    /**
	 * Initialize settings for SAML remote user authorization.
	 */
    public function initSamlSettings()
	{
		// set up data for auth request
		$this->settings = new OneLogin_Saml_Settings();

		// When using Service Provider Initiated SSO (starting at index.php), this URL asks the IdP to authenticate the user.
		//$settings->idpSingleSignOnUrl = 'https://app.onelogin.com/saml/signon/6171';
		$this->settings->idpSingleSignOnUrl = $this->idpSingleSignOnUrl; // put in corect IdP url
		
		// The certificate for the users account in the IdP
		$this->settings->idpPublicCertificate = $this->idpPublicCertificate;

		// The URL where to the SAML Response/SAML Assertion will be posted
		//$settings->spReturnUrl = 'http://localhost/php-saml/consume.php';
		$this->settings->spReturnUrl = Yii::app()->controller->createAbsoluteUrl($this->spReturnRoute, array(), 'https');
		
		// id Name of this application
		$this->settings->spIssuer = $this->spIssuer;

		// Tells the IdP to return the email address of the current user
		//$settings->requestedNameIdFormat = OneLogin_Saml_Settings::NAMEID_TRANSIENT;
		$this->settings->requestedNameIdFormat = 'urn:mace:shibboleth:1.0:nameIdentifier';
		
	}
    
	/**
	 * Initializes the application component.
	 * This method overrides the parent implementation,
	 */
	public function init()
	{
		parent::init();
		$this->initSamlSettings();
	}

	public function getRedirectUrl()
	{
		// generate auth request
		$authRequest = new OneLogin_Saml_AuthRequest($this->settings);
		return $authRequest->getRedirectUrl();
	}

	public function getUsernameFromResponse($response)
	{
		// load and parse response
		$samlResponse = new IDPResponse($this->settings, $response);
		
		// validate response xml, check certificates to make sure it from a real idp
		if ($samlResponse->isValid()) {
	    	//get attributes from response xml
	    	$attributes = $samlResponse->getAttributes();
	    	$eMail = $attributes[ $this->userEmailTag][0];  
	    	// pick cruzId out of email
			return substr($eMail, 0, strpos($eMail, "@"));
	    }
	    else {
			throw new CException('Could not login user. Invalid SAML response.');	   
	    }
	}

	public function getMetadata()
	{
		$samlMetadata = new SPMetadata($this->settings);
		return $samlMetadata->getXml();
	}
		
	
}
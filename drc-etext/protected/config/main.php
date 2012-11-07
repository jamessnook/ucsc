<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'eText Library',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'aliases' => array(
	    //assuming you extracted the files to the extensions folder
	    'xupload' => 'ext.xupload'
	),
	
	'modules'=>array(
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'eggplant',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			//'ipFilters'=>array('127.0.0.1','::1'),
		),
    ),
	
	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl'=>array('/login/login'),
    	),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/etext.db',
		),
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
		'authManager'=>array(
            'class'=>'CDbAuthManager',
            'connectionID'=>'db',
			'defaultRoles'=>array('student'),
        ),		
        'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// un comment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'updater'=>array(
			//.....
			'class'=>'XMLUpdater',
			'servers'=>array(
				// could get feeds from multiple servers or addresses
				'AIS' => array(
					'uri' =>  'https://ais-dev-dmz-6.ucsc.edu:1821/PSIGW/HttpListeningConnector',
					'operation' => 'SCX_ETEXT.v1',
					'from' => 'SCX_ETEXT_NODE',
					'to' => 'PSFT_CSDEV',
					'uName' => 'ETEXT',
					'pWord' => 'j@bberw0cky',
					// models map xml tag to model class
			    	'services' => array(
						'classes'  => array(
							'class' => array(  // element is named 'class'
								'model'=>'Course',
								//'mapper'=>'CourseMapper',  optional mapper class skips rest of config for this model class
								'children' => array(
									'emplid' => array(
										'model'=>'CourseInstructor',
										'thisAsAttribute'=>'emplid',
										'parentAttributes' => array(
											'termCode'=>'term_code',
											'classNum'=>'class_num',
										),
									),
								),
							),
						),
						'terms'  => array(
						),
						'enrollments'  => array(
						),
						'accommodations'  => array(
						),
						'students'  => array(
							'person' => array(  // element is named 'person'
								'model'=>'User',
								'attributes' => array(
									'cruzid'=>'username',
								),
							),
						),
					),
				),
			),
		),
		'saml'=>array(
			'class'=>'SamlLogin',
			// the next steps set up Shibboleth Authentication if we are sing it
			// the entity id for this app as registered with the Shibboleth 
			//identity provider (authentication server):
			'spIssuer'=>'ucsc.phpfogapp.com/drc-etext',
			// the controller and action path to call with the authorization response Post
			'spReturnRoute'=>'login/samlResponse',
			// the xml tag used by the identity provider to identify the 
			//users email address which is where we get their cuzId: 
			'userEmailTag'=>'urn:oid:1.3.6.1.4.1.5923.1.1.1.6',
			// the url our app uses to access the Shibboleth identity provider:
			// We get this from the identity providers xml metadata file.  
			// (provided by Jeffrey Crawford
			'idpSingleSignOnUrl'=>'https://test-idp.ucsc.edu:444/idp/profile/SAML2/Redirect/SSO',
			// this is the public key x509 certificate for the identity provider 
			// so we can validate their response.  
			// We get this from the identiy providers xml metadata file.  		
			'idpPublicCertificate'=><<<CERTIFICATE
-----BEGIN CERTIFICATE-----
MIIEnjCCA4agAwIBAgIJAN/oJ2XPfzjhMA0GCSqGSIb3DQEBBQUAMIGQMQswCQYD
VQQGEwJVUzETMBEGA1UECBMKQ2FsaWZvcm5pYTETMBEGA1UEBxMKU2FudGEgQ3J1
ejEtMCsGA1UEChMkVW5pdmVyc2l0eSBvZiBDYWxpZm9ybmlhLCBTYW50YSBDcnV6
MQwwCgYDVQQLEwNJVFMxGjAYBgNVBAMTEXRlc3QtaWRwLnVjc2MuZWR1MB4XDTEw
MTEyMjE5MDIyNloXDTEzMTEyMTE5MDIyNlowgZAxCzAJBgNVBAYTAlVTMRMwEQYD
VQQIEwpDYWxpZm9ybmlhMRMwEQYDVQQHEwpTYW50YSBDcnV6MS0wKwYDVQQKEyRV
bml2ZXJzaXR5IG9mIENhbGlmb3JuaWEsIFNhbnRhIENydXoxDDAKBgNVBAsTA0lU
UzEaMBgGA1UEAxMRdGVzdC1pZHAudWNzYy5lZHUwggEiMA0GCSqGSIb3DQEBAQUA
A4IBDwAwggEKAoIBAQCt4Tlynjhy5iISkopIGFR1H6lqcM1FTM4sS75w+dm8Tzm5
SVVvY0K+Gc7nDmUEIu5Ri9MPemCWlbqOvLIsGpBOEh1IU8/lRDFK335iHdYAHj7G
5aL3BzxLDrtyeRUQVf3XqaxABW85/AUlv4L8UqcjQxezHJi8Kw4pcd1gbeHbSE2A
m6H3EDQIqGrBCtVv4bqpe1nCX5QKPi9xpWlF7cLMT6VcYSxvClIesMXI3O6iXKIX
UnpN94Vi79ukY7kDGLpWdr2pF5E1pvbYMbDSDUdp1OkYXHE8d1LtRVEFt/gcb+yh
mQbr40AOYnPt9e6aa9SG226GpG2ecPMUt8rwlirZAgMBAAGjgfgwgfUwHQYDVR0O
BBYEFO25eNbR0EHwf6HR0ioZ3j38egveMIHFBgNVHSMEgb0wgbqAFO25eNbR0EHw
f6HR0ioZ3j38egveoYGWpIGTMIGQMQswCQYDVQQGEwJVUzETMBEGA1UECBMKQ2Fs
aWZvcm5pYTETMBEGA1UEBxMKU2FudGEgQ3J1ejEtMCsGA1UEChMkVW5pdmVyc2l0
eSBvZiBDYWxpZm9ybmlhLCBTYW50YSBDcnV6MQwwCgYDVQQLEwNJVFMxGjAYBgNV
BAMTEXRlc3QtaWRwLnVjc2MuZWR1ggkA3+gnZc9/OOEwDAYDVR0TBAUwAwEB/zAN
BgkqhkiG9w0BAQUFAAOCAQEAYOA6H6AYWzJqgdaCFvNuDhMZ0yO/U9VgbS0Uhyu4
feBQA2QZBt8KAlIlk0Gu7mDoUQNTd3C9kzUq/LgtfJ1oXfEVM1uEtHbEdAsW+FsS
fY220DOcGaJ92VGORRiQGWMOstX56uQvah7IiRBIYGO0YL56zqVlBB6k0ynF/tik
LETdvPF6zKpRvY1ghr/0kL4nYYKvlG9W+05lLXCMt75J0WGHzSoQe8BO8k3lKpz6
jTcjJdbG19DaAjd7ejPVWCh+tj5QdLCrMcJH0eGdkdEqvbX5yJ1X3hQA5ZfqXSzo
rUJJPkOD/6nCS4sMeXfVzQXoyj67v00xiNwRo2h7/qnAUQ==
-----END CERTIFICATE-----
CERTIFICATE
			,
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',

		// the next two set up the type of user authentication we are using
		'samlLogin'=>false,  // true if using shibboleth authentication
		'localLogin'=>true,	// true if using local authentication
		
		// location for uploaded files
		'fileRoot'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'../files',
	
	),
);
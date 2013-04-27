<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.


return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'defaultController'=> 'base/login',
	'name'=>'eText Library',
	'homeUrl'=>array('/base/login/intro'),

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.controllers.*',
		'application.modules.base.models.*',
		'application.modules.base.controllers.*',
		'application.modules.base.components.*',
	),

	'aliases' => array(
	    //assuming you extracted the files to the extensions folder
	    'xupload' => 'modules.extensions.xupload'
	),
	
	'modules'=>array(
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'eggplant',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			//'ipFilters'=>array('127.0.0.1','::1'),
		),
        'base'=>array(
			//'tabMenu' => new DrcTabMenu,
			//'tabMenuClass' => 'DrcTabMenu',
		),
	),
	// application controllers from base extension etc.
    /*
    'controllerMap'=>array(
        'login'=>array(
            'class'=>'ext.base.controllers.LoginController',
        ),
        'user'=>array(
            'class'=>'ext.base.controllers.UserController',
        ),
        'site'=>array(
            'class'=>'ext.base.controllers.SiteController',
        ),
        // other controllers
    ),
    */
		
    // application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl'=>array('base/login/login'),
    	),
        'saml'=>array(
            'class'=>'base.extensions.saml.SamlUserIdentity',
			//'simplesamlPath' => Yii::app()->request->baseUrl . '/../simplesaml/simplesaml',
			'simplesamlPath' => dirname(__FILE__) . '/../../../simplesaml/simplesaml',
			'serviceProviderId' => 'ucsc-test--sp',
    	),
    	// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				//'<controller:(course)>/<view:(description|assignments|books|students|createAssignment|createBook)>/*'=>'<controller>/index',
				//'<controller:(assignment)>/<view:(manage)>/*'=>'<controller>/index',
    			//'<controller:(user)>/<view:(view|create|students|faculty|staff)>/*'=>'<controller>/index',
    			//'<controller:(gii)>/*'=>'<controller>/index',
    			//'<controller:\w+>/<id:\d+>'=>'<controller>/view',
    			//'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				//'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/etext.db',
		),
		*/
		// uncomment the following to use a MySQL database
		'db'=>array(
 			'class'=>'CloudDbConnection',			
 			'connectionString' => 'mysql:host=localhost;dbname=etext',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'serviceName' => 'etext',
		),
		'authManager'=>array(
            'class'=>'CDbAuthManager',
            'connectionID'=>'db',
			'defaultRoles'=>array('student'),
        ),		
        'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'base/site/error',
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
							'drcAccommodation' => array(  // element is named 'person'
								'model'=>'DrcAccommodation',
							),
						),
						'students'  => array(
							'person' => array(  // element is named 'person'
								'model'=>'User',
								'attributes' => array(
									'cruzid'=>'username',
								),
								'defaults' => array(
									'role'=>'student',
								),
							),
						),
						'instructors'  => array(
							'person' => array(  // element is named 'person'
								'model'=>'User',
								'attributes' => array(
									'cruzid'=>'username',
								),
								'defaults' => array(
									'role'=>'faculty',
								),
							),
						),
					),
				),
			),
		),
	),
		
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// These are used by certain classes and views in the base module
		'tabMenuClass' => 'DrcTabMenu',
		'mainView' => 'base.views.layouts._main',
		'homePage' => '/drcUser/courses',
		'adminHomePage' => '/drcUser/students',
	
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',

		// the next two set up the type of user authentication we are using
		'samlLogin'=>false,  // true if using shibboleth authentication
		'localLogin'=>true,	// true if using local authentication
		
		// location for uploaded files
		'fileRoot'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'../files',
	   	'filePath' => realpath( Yii::app( )->getBasePath( )."/../files/uploads/" )."/",
    	//'publicFilePath' => Yii::app( )->getBaseUrl( )."/files/uploads/",
	
	),
);
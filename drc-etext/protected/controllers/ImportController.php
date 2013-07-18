<?php

/**
 * SiteController is the controller class for site wide actions not related to a specific model.
 *
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.controllers
 */
class ImportController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// import databases to mysql
			'importDB'=>array(
				'class'=>'modules.base.components.actions.ImportDbAction',
                'fileName'=>'etext.sql',
			),
			// import divData
			'divData'=>array(
				'class'=>'ImportDataAction',
				'feed' => array(
	            	'class'=>'FileDataFeed',
					'location'=>'C:\Users\jsnook\phpfog\ucsc\ascorga\testusers.csv',
				),
				'reader' => array(
	            	'class'=>'CSVReader',
					'model'=>'User',
					/*'fields'=>array(
						'username',
						'emplid',
						'first_name',
						'last_name'
					),*/
					'defaults'=>array(
						'role'=>'faculty',
					),
				),
			),
			'AISCourse'=>array(
				'class'=>'ImportDataAction',
				'feed' => array(
	            	'class'=>'ServiceDataFeed',
					'location'=>'https://ais-dev-dmz-6.ucsc.edu:1821/PSIGW/HttpListeningConnector',
					'operation' => 'SCX_ETEXT.v1',
					'from' => 'SCX_ETEXT_NODE',
					'to' => 'PSFT_CSDEV',
					'uName' => 'ETEXT',
					'pWord' => 'xxxxx',
					'serevice' => 'classes',
				),
				'reader' => array(
	            	'class'=>'XMLReader',
					'elements' => array(
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
				),
			),
			'AISTerm'=>array(
				'class'=>'ImportDataAction',
				'feed' => array(
	            	'class'=>'ServiceDataFeed',
					'location'=>'https://ais-dev-dmz-6.ucsc.edu:1821/PSIGW/HttpListeningConnector',
					'operation' => 'SCX_ETEXT.v1',
					'from' => 'SCX_ETEXT_NODE',
					'to' => 'PSFT_CSDEV',
					'uName' => 'ETEXT',
					'pWord' => 'xxxxx',
					'serevice' => 'terms',
				),
				'reader' => array(
	            	'class'=>'XMLReader',
					'elements'  => array(
						'term' => array(  // element is named 'class'
							'model'=>'Term',
						),
					),
				),
			),
			'AISEnrollment'=>array(
				'class'=>'ImportDataAction',
				'feed' => array(
	            	'class'=>'ServiceDataFeed',
					'location'=>'https://ais-dev-dmz-6.ucsc.edu:1821/PSIGW/HttpListeningConnector',
					'operation' => 'SCX_ETEXT.v1',
					'from' => 'SCX_ETEXT_NODE',
					'to' => 'PSFT_CSDEV',
					'uName' => 'ETEXT',
					'pWord' => 'xxxxx',
					'serevice' => 'enrollments',
				),
				'reader' => array(
	            	'class'=>'XMLReader',
				),
			),
			'AISAccomodation'=>array(
				'class'=>'ImportDataAction',
				'feed' => array(
	            	'class'=>'ServiceDataFeed',
					'location'=>'https://ais-dev-dmz-6.ucsc.edu:1821/PSIGW/HttpListeningConnector',
					'operation' => 'SCX_ETEXT.v1',
					'from' => 'SCX_ETEXT_NODE',
					'to' => 'PSFT_CSDEV',
					'uName' => 'ETEXT',
					'pWord' => 'xxxxx',
					'serevice' => 'accommodations',
				),
				'reader' => array(
	            	'class'=>'XMLReader',
					'elements' => array(
						'drcAccommodation' => array(  // element is named 'person'
							'model'=>'DrcAccommodation',
						),
					),
				),
			),
			'AISStudent'=>array(
				'class'=>'ImportDataAction',
				'feed' => array(
	            	'class'=>'ServiceDataFeed',
					'location'=>'https://ais-dev-dmz-6.ucsc.edu:1821/PSIGW/HttpListeningConnector',
					'operation' => 'SCX_ETEXT.v1',
					'from' => 'SCX_ETEXT_NODE',
					'to' => 'PSFT_CSDEV',
					'uName' => 'ETEXT',
					'pWord' => 'xxxxx',
					'serevice' => 'students',
				),
				'reader' => array(
	            	'class'=>'XMLReader',
					'elements' => array(
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
				),
			),
			'AISInstructor'=>array(
				'class'=>'ImportDataAction',
				'feed' => array(
	            	'class'=>'ServiceDataFeed',
					'location'=>'https://ais-dev-dmz-6.ucsc.edu:1821/PSIGW/HttpListeningConnector',
					'operation' => 'SCX_ETEXT.v1',
					'from' => 'SCX_ETEXT_NODE',
					'to' => 'PSFT_CSDEV',
					'uName' => 'ETEXT',
					'pWord' => 'xxxxx',
					'serevice' => 'instructors',
				),
				'reader' => array(
	            	'class'=>'XMLReader',
					'elements'  => array(
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
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		//$this->render('index');
		$this->redirect(Yii::app()->createUrl('login/login'));
	}

	/**
	 * Requests data from web service feed and updates local database.
	 */
	public function actionDivDataOld()
	{
		Yii::app()->divDataImporter->update();
		//$this->redirect(Yii::app()->homeUrl);
	}
	
	/**
	 * Returns the model for this controller.
	 * Creates model if not yet set.
	 */
	public function getModel()
	{
		return $this->_model;
	}
}
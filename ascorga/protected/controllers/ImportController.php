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
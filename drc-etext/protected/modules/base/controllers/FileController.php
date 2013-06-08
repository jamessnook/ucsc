<?php

/**
 * SiteController is the controller class for site wide actions not related to a specific model.
 *
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.controllers
 */
class FileController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('view'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete', 'manage', 'index', 'uploadFile'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 * Deletes a particular file association with another mdole and if it is the only one for this file it also deletes the file.
	 * If deletion is successful, the browser will be redirected to the page that the delete request came from.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id, $model_id, $model_name)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$file = File::loadModel();
			FileAssociation::loadModel()->delete();
			if (count($file->associations) <= 1){
				$file->delete();
			}
			$this->redirect(Yii::app()->request->getUrlReferrer());
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	}
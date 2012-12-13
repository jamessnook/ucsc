<?php

/**
 * BookController is the controller class for viewing and managing books and related data.
 *
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.controllers
 */
class BookController extends Controller
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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete','togglePurchased', 'uploadFile'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Defines actions for this controller that will be handeled by code in seperate action classes.
	 */
	public function actions()
    {
        return array(
            'uploadFile'=>array(
                'class'=>'UploadAction',
                'modelName'=>'Book',
        		'path' =>'/../files/books',
        		'subfolderVar' =>'id',
        	),
        );
    }
	
	/**
	 * Deletes a particular Book model.
	 * If deletion is successful, the browser will be redirected to the page where the toggle button is.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionTogglePurchased()
	{
		$model = BookUser::loadModel();
		$model->purchased = !$model->purchased;
		//echo "p=$model->purchased n=$model->username book_id=$model->book_id";
		$model->save();	
		$this->redirect(Yii::app()->request->getUrlReferrer());
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the page that the delete request came from.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			Book::loadModel()->delete();
			$this->redirect(Yii::app()->request->getUrlReferrer());
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	
}

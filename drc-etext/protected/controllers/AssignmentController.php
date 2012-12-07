<?php

class AssignmentController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/noLayout';

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

    public function actions()
    {
        return array(
            'uploadFile'=>array(
                'class'=>'UploadAction',
                'modelName'=>'Assignment',
        		'path' =>'/../files/assignments',
        		'subfolderVar' =>'id',
        	),
        );
    }
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			Assignment::loadModel()->delete();
			$this->redirect(Yii::app()->request->url);
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * sets up default view options for rendering, called by super class render and passed to  view.
	 */
	public function setDefaultViewOptions()
	{
		$this->viewOptions['menuView'] = '../layouts/_termMenu';
		$this->viewOptions['title'] = $this->model->title;
		if (!$this->model->title || $this->model->title =='') {
			$this->viewOptions['title'] = "Assignments";
		}
		$this->viewOptions['activeTab'] = "assignment";
	}

		/**
	 * display students for the course.
	 */
	public function actionManage()
	{
		$this->renderView(array(
			'contentView' => '_adminList',
		));
	}
	
	
}

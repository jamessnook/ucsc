<?php

class WordsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'list'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('create','update', 'admin','delete'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Words;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Words']))
		{
			$model->attributes=$_POST['Words'];
			//if($model->save())
				//$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Words']))
		{
			$model->attributes=$_POST['Words'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
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
			//$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Words');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Words('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Words']))
			$model->attributes=$_GET['Words'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Words::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
 	
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='words-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * 
	 */
	public function actionList()
	{
		// set default word
		if (!isset($_REQUEST['word'])){
			$_REQUEST['word']='a*';
		}
		if($this->model->saveNewList){
			$this->model->createList();
		}
		elseif($this->model->saveOldList){
			$this->model->updateList();
		}
		elseif($this->model->downloadTsv){
			$this->renderPartial('delimitedList',array(
				'model'=>$this->model,
			));
			exit;
		}
		elseif($this->model->downloadInflections){
			$this->renderPartial('delimitedInflectionList',array(
			'model'=>$this->model,
			));
			exit;
		}
		if($this->model->viewInflections){
			$this->renderView(array(
				'title' => 'List Builder',
				'contentView' => '../words/_inflectionList',
				'menuView' => '../words/_select',
				'contentTitle' => 'Inflected Word List',
			));
		} else if($this->model->viewLemmaMorph){
			$this->renderView(array(
				'title' => 'List Builder',
				'contentView' => '../words/_lemmaMorphList',
				'menuView' => '../words/_select',
				'contentTitle' => 'Lemma Morpology and Derivation',
			));
		} else {
			$this->renderView(array(
				'title' => 'List Builder',
				'contentView' => '../words/_list',
				'menuView' => '../words/_select',
				'contentTitle' => 'Word List',
			));
		}
	}

	/**
	 * sets up default view options for rendering, called by super class render and passed to view.
	 */
	public function setDefaultViewOptions()
	{
		$this->viewOptions['menuView'] = '../words/_select';  // default
		$this->viewOptions['title'] = 'Title';
		$this->viewOptions['activeTab'] = "courses";
		$this->viewOptions['action'] = Yii::app()->createUrl("words/list");
	}

}

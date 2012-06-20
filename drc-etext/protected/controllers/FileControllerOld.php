<?php

class FileController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','upload','download'),
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
		$model=new File;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['File'])===true)
		{
			$model->attributes=$_POST['File'];
			if($model->save()!==false)
				$this->redirect(array('view','id'=>$model->id));
		}
		if(isset($_GET['text_id']))
			$model->text_id=$_GET['text_id'];
		
		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * 
	 */
	public function actionDownload()
	{
		$model=new File;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		
		//if(isset($_Get['download']) && isset($_Get['text_id']) && isset($_Get['name'] ) !== false)
		if(isset($_GET['name']))
		{
            //echo 'found file<br />';
			$name = $_GET['name'];
			$text_id = $_GET['text_id'];
			$filecontent=file_get_contents(Yii::getPathOfAlias('webroot').'/files/'. $text_id . '/' . $name);
			header("Content-Type: text/plain");
			header("Content-disposition: attachment; filename=$name");
			header("Pragma: no-cache");
			echo $filecontent;
			exit;
		}
		if(isset($_GET['text_id']))
		{
            //echo 'found text_id<br />';
			$model->text_id=$_GET['text_id'];
		}
		$this->render('download',array(
			'model'=>$model,
		));
	}

	/**
	 * Uploads files and Creates new models.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpload()
	{
		$model=new File;
		
		// Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model);
 
        if(isset($_POST['File'])) {
 
            $model->attributes=$_POST['File'];
 
            // THIS is how you capture those uploaded images: remember that in your CMultiFile widget, you set 'name' => 'images'
            $files = CUploadedFile::getInstancesByName('files');
            //echo 'in file controller<br />';
            
            // proceed if the images have been set
            if (isset($files) && count($files) > 0) {
                //echo 'found files<br />';
            	
                // go through each uploaded image
                foreach ($files as $key => $file) {
                    //echo $file->name.'<br />';
                    $dirPath = Yii::getPathOfAlias('webroot').'/files/'. $model->text_id . '/';
					if (!file_exists( $dirPath )){
						mkdir( $dirPath, 0775, true);
		            }
                    //if ($file->saveAs(Yii::getPathOfAlias('webroot').'/files/'.$file->name)) {
                    if ($file->saveAs($dirPath . $file->name)) {
                    	// add it to the main model now
                        $file_add = new File();
                        $file_add->name = $file->name; 
                        $file_add->format_id = $model->format_id; 
                        $file_add->text_id = $model->text_id; 
                        $file_add->post_date = new CDbExpression('DATE()');
                        $file_add->save(); // DONE
                        //or// ($model->save())
                    }
                    else {
						$this->render('login/loginFail');
                   	}
                }
                $this->redirect(array('admin'));
            }
        }
		if(isset($_GET['text_id']))
			$model->text_id=$_GET['text_id'];
		
       $this->render('upload',array('model'=>$model,));
       
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

		if(isset($_POST['File']))
		{
			$model->attributes=$_POST['File'];
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
			$this->loadModel($id)->delete();

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
		$dataProvider=new CActiveDataProvider('File');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new File('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['File']))
			$model->attributes=$_GET['File'];
			//$model->setAttributes($_GET['File'], false);
		if(isset($_GET['text_id']))
			$model->text_id=$_GET['text_id'];
			
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
		$model=File::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='file-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

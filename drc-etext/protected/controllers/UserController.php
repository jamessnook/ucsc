<?php

class UserController extends Controller
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
			array('allow', // allow authenticated user to perform 'courses' and 'view' actions
				'actions'=>array('view', 'courses'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete','create','update', 'students', 'courses', 'save'),
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
	 * Creates a new User model.
	 */
	public function actionCreate($termCode=null)
	{
        $model = new User;
		$model->term_code = $termCode;
        $this->render('create',array(
                'model'=>$model,
        ));
	}

	/**
	 * Updates a particular Book model.
	 * @param integer $bookId the ID of the model to be updated
	 */
	public function actionUpdate($username, $termCode=null)
	{
	    $model = $this->loadModel($username);
		$model->term_code = $termCode;
	    $view = 'update';
	    if (!Yii::app()->user->checkAccess('admin'))
			$view = 'view';
	    
		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionSave($username=null)
	{
		$model=new User;
		if ($username) $model = $this->loadModel($username);
		//if (!$model) $model=new User;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
	        if( $model->save()!==false )
	        {
	            // remove existing roles for user
	            // assumes we allow only one role per user
		        $userRoles = Yii::app()->authManager->getRoles($model->username);
		        foreach ($userRoles as $name => $authItem){
		        	Yii::app()->authManager->revoke($name, $model->username);
		        }
	            // Assign the role to the user 
                Yii::app()->authManager->assign($_POST['roleName'], $model->username);
                $this->redirect(array('students','username'=>$model->username));
	        }
		}
		$this->redirect(array('create'));
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
	 * Display data for a drc student.
	 */
	public function actionStudents($termCode=null)
	{
		$model=new User('search');
		//$this->term = $model->find();
		$model->unsetAttributes();  // clear any default values

		if (!$termCode) $termCode = Term::currentTermCode();
		$model->term_code = $termCode;

		$this->render('students',array(
			'model'=>$model,
		));
	}

	/**
	 * Display courses for a drc student.
	 */
	public function actionCourses($termCode=null, $username=null, $emplid=null)
	{
		if (!Yii::app()->user->checkAccess('admin')){
			$username = Yii::app()->user->name;
			$model=User::model()->findByPk($username);
		}
		if ($username){
			$model=User::model()->findByPk($username);
		} else if ($emplid) {
			$model=User::model()->findByAttributes(array('emplid'=>$emplid));
		} else {
			$model=new User('search');
			$model->unsetAttributes();  // clear any default values
		}

		if (!$termCode) $termCode = Term::currentTermCode();
		$model->term_code = $termCode;
		
		$this->render('courses',array(
			'model'=>$model,
		));
	}

	/**
	 * Display data about a student.
	 */
	public function actionProfile($username=null)
	{
		if ($termCode && $classNum){
			$model=Course::model()->findByAttributes(array('term_code'=>$termCode, 'class_num'=>$classNum,));
		} else {
			$model=new Course('search');
			$model->unsetAttributes();  // clear any default values
		}
		
		$this->render('description',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($username)
	{
		$model=User::model()->findByPk($username);
		if($model===null)
			throw new CHttpException(404,'The requested user does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

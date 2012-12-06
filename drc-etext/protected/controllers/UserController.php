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
				'actions'=>array('index', 'courses'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete','save','update', 'courses', 'index'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Updates a particular User model.
	 * @param integer $username the username of the model to be updated
	 */
	public function actionUpdate()
	{
		$model=User::loadModel();
		if($model===null)
			throw new CHttpException(404,'The requested user does not exist.');
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
	public function actionSave()
	{
		$model = User::loadModel();

		if(isset($_POST['User'])){
			if(!$model->save()) {
				throw new CHttpException(404,'ERROR could not save user data.'); // temporary error code
			}
		}
		$this->redirect(Yii::app()->request->getUrlReferrer()); // back from wence yee came
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			User::loadModel()->delete();
			$this->redirect(Yii::app()->request->url);
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}


	/**
	 * Display courses for a drc student.
	 */
	public function actionCourses($term_code=null, $username=null, $emplid=null)
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

		if (!$term_code) $term_code = Term::currentTermCode();
		$model->term_code = $term_code;
		
		$this->model = $model;
		$this->renderView(array(
			'contentView' => '../course/_list',
			'menuView' => '../layouts/_termMenu',
			'menuRoute' => 'user/courses',
			'titleNavRight' => '<a href="' . $this->createUrl('user/update', array('term_code'=> $model->term_code, 'username'=>$model->username)) . '"><i class="icon-plus"></i> User Profile</a>',
		));
	}
	
	/**
	 * sets up default view options for rendering, called by super class render and passed to  view.
	 */
	public function setDefaultViewOptions($model)
	{
		$options['title']="($model->username) $model->first_name $model->last_name";
		if (!$model->username || $model->username ==''){
			$options['title'] = "Users";
			if ($model->term_code){
				$term=Term::model()->findByPk($model->term_code);
				$options['title'] = $term->description;
			}
		}
		$options['activeTab'] = "students";
		if ($model->username){
			if(Yii::app()->authManager->checkAccess('staff', $model->username))
				$options['activeTab'] = "staff";
			if (Yii::app()->authManager->checkAccess('admin', $model->username)) 
				$options['activeTab'] = "staff";
			if (Yii::app()->authManager->checkAccess('faculty', $model->username)) 
				$options['activeTab'] = "faculty";
		}
		$this->viewOptions = $options;
	}
	
}

<?php

class AssignmentFileController extends Controller
{
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/

	/**
	 * Display List of Files for an assignment and user.
	 */
	public function actionStudentAssignmentFiles($assignmentId=null, $username=null)
	{
		$model=new AssignmentFile('search');
		//$this->term = $model->find();
		$model->unsetAttributes();  // clear any default values

		if (!$username) $username = Yii::app()->user->name;
		if (!$assignmentId) {echo 'Error!'; return;}  //temp error code
		$model->id = $assignmentId;

		$this->render('studentAssignmentFiles',array(
			'model'=>$model,
		));
	}

}
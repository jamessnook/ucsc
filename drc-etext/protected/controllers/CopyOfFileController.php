<?php

class FileController extends Controller
{
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		//$model=$this->loadModel($id);
		// make the directory to store the pic:
		//if(!is_dir(Yii::getPathOfAlias('webroot').'/files/'. $model->name)) {
		//   mkdir(Yii::getPathOfAlias('webroot').'/files/'. $model->name);
		//   chmod(Yii::getPathOfAlias('webroot').'/files/'. $model->name, 0755); 
		   // the default implementation makes it under 777 permission, which you could possibly change recursively before deployment, but here's less of a headache in case you don't
		//}		
 
        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model);
 
        //if(isset($_POST['Topic'])) {
 
            //$model->attributes=$_POST['Topic'];
 
            // THIS is how you capture those uploaded images: remember that in your CMultiFile widget, you set 'name' => 'images'
            $files = CUploadedFile::getInstancesByName('files');
            echo 'in file controller<br />';
            
            // proceed if the images have been set
            if (isset($files) && count($files) > 0) {
                echo 'found files<br />';
            	
                // go through each uploaded image
                foreach ($files as $key => $file) {
                    echo $file->name.'<br />';
                    //if ($file->saveAs(Yii::getPathOfAlias('webroot').'/files/'.$file->name)) {
                    if ($file->saveAs(Yii::getPathOfAlias('webroot').'/files/'.$file->name)) {
                    	// add it to the main model now
                        //$img_add = new Picture();
                        //$img_add->filename = $pic->name; //it might be $img_add->name for you, filename is just what I chose to call it in my model
                        //$img_add->topic_id = $model->id; // this links your picture model to the main model (like your user, or profile model)
 
                        //$img_add->save(); // DONE
                    }
                    else {
						$this->render('login/loginFail');
                   	}
                }
 
                // save the rest of your information from the form
                //if ($model->save()) {
                //    $this->redirect(array('view','id'=>$model->id));
                //}
            }
        //}
 
       //$this->render('upload',array('model'=>$model,));
       $this->render('upload');
       
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpload()
	{
        $this->render('upload');
	}
	

	function actionDownload(){
		//$filecontent=file_get_contents('path_to_file'.$name);
		$name = 'spconfig';
		$filecontent=file_get_contents(Yii::getPathOfAlias('webroot').'/files/'. $name);
		header("Content-Type: text/plain");
		header("Content-disposition: attachment; filename=$name");
		header("Pragma: no-cache");
		echo $filecontent;
		exit;
	}
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
}
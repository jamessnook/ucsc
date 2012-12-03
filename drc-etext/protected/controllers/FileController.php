<?php

class FileController extends Controller
{
	public $file = null;
	
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
				'actions'=>array('admin','delete', 'download', 'upload', 'xUpload'),
				'roles'=>array('admin'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('download'),
				'roles'=>array('student'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actions()
    {
        return array(
            'upload'=>array(
                'class'=>'xupload.actions.XUploadAction',
                'path' =>Yii::app() -> getBasePath() . "/../uploads",
                'publicPath' => Yii::app() -> getBaseUrl() . "/uploads",
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

		if(isset($_POST['File']))
		{
			$model->attributes=$_POST['File'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * 
	 */
	public function actionDownloadMultiple()
	{
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		
		if(isset($_GET['parent_id']))
		{
			$parentId = $_GET['parent_id'];
			$request = BookRequest::model()->findByPk($parentId);
			if (isset($request) && $request->has_zip_file){
				$this->download("zips/req$parentId.zip");
			} else{
				$files = File::model()->findAllByAttributes(array('parent_id'=>$parentId));
				$fileCount = count($files);
				//if ($fileCount < 1 || !$request->is_complete){
				if ($fileCount < 1 ){
					// error
					echo "Request not complete or no files found for book request #$parentId.";
					
				}
				else if ($fileCount == 1){
					$model = $files[0];
					$this->download("$model->path" . "/" . "$model->name");
				}
				else {
					$model=new File;
					$model->parent_id=$parentId;
					$this->render('download',array(
						'model'=>$model,
					));
				}
			}
		}
		else if(isset($_GET['name']))
		{
			$name = $_GET['name'];
			$path = (isset($_GET['path']) ? rtrim($_GET['path'], '/') :'');
			$path = (strlen($path)>0 ? $path . '/' : '');
			$this->download($path . $name);
		}
	}

	/**
	 * 
	 */
	public function actionDownload($id)
	{
		$model=$this->loadModel($id);
		$this->download("$model->path" . "/" . "$model->name");
		
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
 
            // THIS is how you capture those uploaded files: remember that in your CMultiFile widget, you set 'name' => 'images'
            $files = CUploadedFile::getInstancesByName('files');
            
            // proceed if the images have been set
            if (isset($files) && count($files) > 0) {
            	
                // go through each uploaded file
                foreach ($files as $key => $file) {
                    // get file path from form if set
                    //$fileExtension = substr ( $file->name , strrpos($file->name, '.' )+1);
                    $fileTypeId = FileType::model()->findByAttributes(array('name'=>$file->extensionName))->id;
                    $dirPath = Yii::app()->params['fileRoot'] . "/" . $model->path;
					if (!file_exists( $dirPath )){
						mkdir( $dirPath, 0775, true);
		            }
                    if ($file->saveAs($dirPath . "/" . $file->name)) {
                    	// add it to the main model now
                        $file_add = new File();
                        $file_add->name = $file->name; 
                        $file_add->type_id = $fileTypeId; 
                        $file_add->path = $model->path; 
                        $file_add->parent_id = $model->parent_id; 
                        $file_add->save(); // DONE
                    }
                    else {
						$this->render('login/loginFail');
                   	}
                }
                //$this->redirect(array('admin'));
            }
        }
		if(isset($_GET['parent_id'])){
			$model->parent_id=$_GET['parent_id'];
			$model->path='book' . $_GET['parent_id'];
		}
        
       $this->render('upload',array('model'=>$model,));
       
	}

	/**
	 * Uploads files and Creates new models.
	 * This version works with the yii xupload extension widget
	 */
	public function actionXUpload($modelName=null, $parent_id=null, $path='')
	{
		//This is for IE which doens't handle 'Content-type: application/json' correctly
	    header( 'Vary: Accept' );
	    if( isset( $_SERVER['HTTP_ACCEPT'] ) 
	        && (strpos( $_SERVER['HTTP_ACCEPT'], 'application/json' ) !== false) ) {
	        header( 'Content-type: application/json' );
	    } else {
	        header( 'Content-type: text/plain' );
	    }
	 
	    //Here we check if we are deleting and uploaded file
	    if( isset( $_GET["_method"] ) ) {
	        if( $_GET["_method"] == "delete" ) {
	            if( $_GET["file"][0] !== '.' ) {
	                $file = $path.$_GET["file"];
	                if( is_file( $file ) ) {
	                    unlink( $file );
	                }
	            }
	            echo json_encode( true );
	        }
	    }
		else {
	        $file = CUploadedFile::getInstanceByName('file' );
	        //We check that the file was successfully uploaded
	        if( $file !== null ) {
                $fileType = $file->getExtensionName();
                $dirPath = Yii::app()->params['fileRoot'] . "/" . $path;
                $publicPath = Yii::app()->params['publicFilePath'];
            	$filename = $file->getName(). ".".$file->getExtensionName( );
                if (!file_exists( $dirPath )){
					mkdir( $dirPath, 0775, true);
		        }
                if ($file->saveAs($dirPath . "/" . $file->name)) {                	
                    // add it to the main model now
                    $file_add = new File();
                    $file_add->name = $file->getName(); 
                    $file_add->type = $fileType; 
                    if(isset($_REQUEST['parent_id'])) {
                    	$file_add->parent_id = $_REQUEST['parent_id']; 
                    }
                    $file_add->path = $path; 
                    $file_add->save(); // DONE
                    $this->file = $file_add;  //Copy to Object variable for use in other methods.
	                //Now we need to tell our widget that the upload was succesfull
	                //We do so, using the json structure defined in
	                // https://github.com/blueimp/jQuery-File-Upload/wiki/Setup
	                echo json_encode( array( array(
	                        "name" => $file_add->name,
	                        "type" => $file->getType( ),
	                        "size" => $file->getSize( ),
	                        "url" => $publicPath.$file->getName(),
	                        "thumbnail_url" => $publicPath."thumbs/$filename",
	                        "delete_url" => $this->createUrl( "XUpload", array(
	                            "_method" => "delete",
	                            "file" => $filename
	                        ) ),
	                        "delete_type" => "POST"
	                    ) ) );
                }
                else {
	                //If the upload failed for some reason we log some data and let the widget know
	                echo json_encode( array( 
	                    array( "error" => $model->getErrors( 'file' ),
	                ) ) );
	                Yii::log( "XUploadAction: ".CVarDumper::dumpAsString( $model->getErrors( ) ),
	                    CLogger::LEVEL_ERROR, "FileController.actionXUpload" 
	                );
                }
	        } else {
	            throw new CHttpException( 500, "Could not upload file" );
	        }
		}       
	}

	/**
	 * Uploads files and Creates new models.
	 * This version works with the yii xupload extension widget
	 */
	public function actionXUploadOld($assignment_id=null)
	{
		// in case of Post data
		if (!$assignment_id) $assignment_id = $_REQUEST['assignment_id'];
		$assignment = Assignment::model()->findByPk($assignment_id);
		//This is for IE which doens't handle 'Content-type: application/json' correctly
	    header( 'Vary: Accept' );
	    if( isset( $_SERVER['HTTP_ACCEPT'] ) 
	        && (strpos( $_SERVER['HTTP_ACCEPT'], 'application/json' ) !== false) ) {
	        header( 'Content-type: application/json' );
	    } else {
	        header( 'Content-type: text/plain' );
	    }
	 
	    //Here we check if we are deleting and uploaded file
	    if( isset( $_GET["_method"] ) ) {
	        if( $_GET["_method"] == "delete" ) {
	            if( $_GET["file"][0] !== '.' ) {
	                $file = $path.$_GET["file"];
	                if( is_file( $file ) ) {
	                    unlink( $file );
	                }
	            }
	            echo json_encode( true );
	        }
	    }
		else {
	        $file = CUploadedFile::getInstanceByName('Assignment[file]' );
	        //We check that the file was successfully uploaded
	        if( $file !== null ) {
                $fileTypeId = FileType::model()->findByAttributes(array('name'=>$file->getExtensionName()))->id;
                //$dirPath = Yii::app()->params['filePath'];
                $path = "t$assignment->term_code/c$assignment->class_num/a$assignment_id";
                $dirPath = Yii::app()->params['fileRoot'] . "/" . $path;
                $publicPath = Yii::app()->params['publicFilePath'];
            	$filename = $file->getName(). ".".$file->getExtensionName( );
                if (!file_exists( $dirPath )){
					mkdir( $dirPath, 0775, true);
		        }
                if ($file->saveAs($dirPath . "/" . $file->name)) {                	
                    // add it to the main model now
                    $file_add = new File();
                    $file_add->name = $file->getName(); 
                    $file_add->type_id = $fileTypeId; 
                    if(isset($_REQUEST['assignment_id'])) {
                    	$file_add->parent_id = $_REQUEST['assignment_id']; 
                    }
                    $file_add->path = $path; 
                    $file_add->save(); // DONE
                    if(isset($_REQUEST['assignment_id'])) { // save to assignemnt to file relation table
                    	$assignmentFile = new AssignmentFile();
                    	$assignmentFile->file_id = $file_add->id;
                    	$assignmentFile->assignment_id = $_REQUEST['assignment_id'];
                    	$assignmentFile->save();
                    }
                    
	                //Now we need to tell our widget that the upload was succesfull
	                //We do so, using the json structure defined in
	                // https://github.com/blueimp/jQuery-File-Upload/wiki/Setup
	                echo json_encode( array( array(
	                        "name" => $file_add->name,
	                        "type" => $file->getType( ),
	                        "size" => $file->getSize( ),
	                        "url" => $publicPath.$file->getName(),
	                        "thumbnail_url" => $publicPath."thumbs/$filename",
	                        "delete_url" => $this->createUrl( "XUpload", array(
	                            "_method" => "delete",
	                            "file" => $filename
	                        ) ),
	                        "delete_type" => "POST"
	                    ) ) );
                }
                else {
	                //If the upload failed for some reason we log some data and let the widget know
	                echo json_encode( array( 
	                    array( "error" => $model->getErrors( 'file' ),
	                ) ) );
	                Yii::log( "XUploadAction: ".CVarDumper::dumpAsString( $model->getErrors( ) ),
	                    CLogger::LEVEL_ERROR, "FileController.actionXUpload" 
	                );
                }
	        } else {
	            throw new CHttpException( 500, "Could not upload file" );
	        }
		}       
	}

	/**
	 */
	public function download($filePath)
	{
		$fileRoot = rtrim(Yii::app()->params->fileRoot, '/\\').'/';
        $fullPath = $fileRoot . $filePath;
        $filecontent=file_get_contents($fullPath);
		header("Content-Type: text/plain");
		header("Content-disposition: attachment; filename=\"$filePath\"");
		header("Pragma: no-cache");
		echo $filecontent;
		exit;
	}
	
	
	/**
	 */
	public function createZip($parent_id)
	{
		$zip=new ZipArchive();
		$fileRoot = rtrim(Yii::app()->params->fileRoot, '/\\').'/';
		$destination=$fileRoot . "zips/req$parent_id.zip";
		if($zip->open($destination,ZIPARCHIVE::CREATE) !== true) {
		   return false;
		}
		
		$files = File::model()->findAllByAttributes(array('parent_id'=>$_GET['parent_id']));
		foreach($files as $model)
		{
		   $zip->addFile($model->fullPath);
		}
		$zip->close(); 
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

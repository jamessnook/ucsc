<?php
/**
 * UploadAction class file.
 *
 */

Yii::import( "xupload.models.XUploadForm" );
Yii::import("xupload.actions.XUploadAction");
/**
 * UploadAction
 * =============
 * Basic upload functionality for an action used by the xupload extension.
 * This class extends the XUploadAction class provided with the xupload extension.
 * It provides additional functionality to determine where to save files 
 * It also saves metadata about the fiel to instances of the File and FIleAssocaiion models.
 *
 * Using UploadAction involves the following steps:
 *
 * 1. Override CController::actions() and register an action of class XUploadAction with ID 'upload', and configure its
 * properties:
 * ~~~
 * [php]
 * class MyController extends CController
 * {
 *     public function actions()
 *     {
 *         return array(
 *             'upload'=>array(
 *                 'class'=>'UploadAction',
 *                 'path' =>Yii::app() -> getBasePath() . "/../uploads",
 *                 'publicPath' => Yii::app() -> getBaseUrl() . "/uploads",
 *                 'subfolderVar' => "parent_id",
 *             ),
 *         );
 *     }
 * }
 *
 * 2. In the controller view, insert a XUpload widget.
 *
 * ###Resources
 * - [xupload](http://www.yiiframework.com/extension/xupload)
 *
 * @version 0.3
 * @author JSnook based on example by Asgaroth (http://www.yiiframework.com/user/1883/)
 * @package drc-etext.protected.components
 */
class UploadAction extends XUploadAction {

    /**
     * The name of the model to associate the file with an instance of using 'id'.
     *
     * @var string
     */
    public $modelName;

    /**
     * The resolved subfolder to upload the file to
     * @var string
     */
    private $_subfolder = "";
    
	/**
	 * Uploads files and Creates new models.
	 * This version works with the yii xupload extension widget
     * @author JSnook
     */
    public function run( ) 
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
            $this->init( );
			$file = CUploadedFile::getInstanceByName('file' );
	        //We check that the file was successfully uploaded
	        if( $file !== null ) {
				$modelName = $this->modelName;
	        	$model = $modelName::loadModel();
	        	$fileType = $file->getExtensionName();
		        //if( $this->subfolderVar !== null ) {
		        //    $this->_subfolder = Yii::app( )->request->getQuery( $this->subfolderVar, date( "mdY" ) );
		        if( $this->subfolderVar !== null && isset($model->attributes[$this->subfolderVar]) ) {
		            $this->_subfolder = $model->attributes[$this->subfolderVar];
		        }
		        $path = ($this->_subfolder != "") ? "{$this->path}/{$this->_subfolder}/" : "{$this->path}/";
                $dirPath = Yii::app() -> getBasePath() . $path;
                //$dirPath = Yii::app()->params['fileRoot'] . "/" . $path;
                //$publicPath = Yii::app()->params['publicFilePath'];
                //$publicPath = ($this->_subfolder != "") ? "{$this->publicPath}/{$this->_subfolder}/" : "{$this->publicPath}/";
                $publicPath = Yii::app() -> getBaseUrl() . $path;
                $filename = $file->getName(). ".".$file->getExtensionName( );
                if (!file_exists( $dirPath )){
					mkdir( $dirPath, 0775, true);
		        }
                if ($file->saveAs($dirPath . "/" . $file->name)) {                	
                    // add it to the main model now
                    $file_add = new File();
                    $file_add->name = $file->getName(); 
                    $file_add->type = $fileType; 
                    $file_add->path = $path; // this might be a little long to save in DB....
                    $file_add->save(); // DONE
					//if(isset($model->id)) { // save to assignemnt to file relation table
			            $fileAssociation = new FileAssociation();
			            $fileAssociation->file_id = $file_add->id;
			            $fileAssociation->model_id = $model->id;
			            $fileAssociation->model_name = $modelName;
			            $fileAssociation->save();
			        //}
                    
	                //Now we need to tell our widget that the upload was succesfull
	                //We do so, using the json structure defined in
	                // https://github.com/blueimp/jQuery-File-Upload/wiki/Setup
	                echo json_encode( array( array(
	                        "name" => $file_add->name,
	                        "type" => $file->getType( ),
	                        "size" => $file->getSize( ),
	                        "url" => $publicPath.$file->getName(),
	                        "thumbnail_url" => $publicPath."thumbs/$filename",
	                        "delete_url" => $this->controller->createUrl( "XUpload", array(
	                            "_method" => "delete",
	                            "file" => $filename
	                        ) ),
	                        "delete_type" => "POST"
	                    ) ) );
                }
                else {
	                //If the upload failed for some reason we log some data and let the widget know
	                echo json_encode( array( 
	                    array( "error" => "Could Not Save File",
	                ) ) );
	                Yii::log( "XUploadAction: Could Not Save File",
	                    CLogger::LEVEL_ERROR, "FileController.actionXUpload" 
	                );
                }
	        } else {
	            throw new CHttpException( 500, "Could not upload file" );
	        }
		}       
	}
    
 
}

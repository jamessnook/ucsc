<?php
/**
 * DownloadAction class file.
 *
 */

/**
 * UploadAction
 * =============
 * Basic file download functionality 
 * @author JSnook 
 * @package base.components.actions
 */
class DownloadAction extends CAction {

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
     * The resolved subfolder to upload the file to
     * @var string
     */
    public $redirectUrl = null;
    
    /**
	 * Uploads files and Creates new models.
	 * This version works with the yii xupload extension widget
     * @author JSnook
     */
    public function run( ) 
	{
		
		if(isset($_GET['id']))
		{
			$model=File::loadModel();
	        $fullPath = Yii::app() -> getBasePath() . $model->path . "/" . $model->name;
            if (file_exists( $fullPath )){
	            $filecontent=file_get_contents($fullPath);
				header("Content-Type: text/plain");
				header("Content-disposition: attachment; filename=\"$model->name\"");
				header("Pragma: no-cache");
				echo $filecontent;
				exit;
            }
	    	throw new CHttpException( 500, "Could not upload file, missing file." );
		} 
	    throw new CHttpException( 500, "Could not upload file, missing id parameter." );
	}
 
}

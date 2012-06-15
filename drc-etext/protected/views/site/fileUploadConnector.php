<div id="file-uploader"></div>
 
<?php
 
$filesPath = realpath(Yii::app()->basePath . "/../files");
$filesUrl = Yii::app()->baseUrl . "/files";
 
$this->widget("ext.ezzeelfinder.ElFinderWidget", array(
    'selector' => "div#file-uploader",
    'clientOptions' => array(
        //'wysiwyg' => "ckeditor"
    ),
    'connectorRoute' => "site/fileUploaderConnector",
    'connectorOptions' => array(
        'roots' => array(
            array(
                'driver'  => "LocalFileSystem",
                'path' => $filesPath,
                'URL' => $filesUrl,
                'tmbPath' => $filesPath . DIRECTORY_SEPARATOR . ".thumbs",
                'mimeDetect' => 'internal',
                'accessControl' => "access"
            )
        )
    )
));
 
?>
<?php
$this->breadcrumbs=array(
	'File'=>array('/file'),
	'Upload',
);?>

<h1>Upload Files</h1>

<?php echo $this->renderPartial('_upload', array('model'=>$model)); ?>
<?php
$this->breadcrumbs=array(
	'File'=>array('/file'),
	'Download',
);?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<h1>Download Files</h1>

<?php echo $this->renderPartial('_download', array('model'=>$model)); ?>


?>
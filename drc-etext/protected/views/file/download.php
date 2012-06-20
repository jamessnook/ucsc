<?php
$this->breadcrumbs=array(
	'File'=>array('/file'),
	'Download',
);?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<h1>Download Files</h1>


<?php 
	$files = File::model()->findAll();
    foreach ($files as $model) {
    	echo CHtml::link("$model->name, ", array('file/download', 'name'=>$model->name, 'path'=>$model->path),
	      array('class'=>'donwload_link')
	   );
	   echo '<br/>';
    }

?>
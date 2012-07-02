<?php
$this->breadcrumbs=array(
	'File Types'=>array('index'),
	$model->name=>array('view','id'=>$model->name),
	'Update',
);

$this->menu=array(
	array('label'=>'List FileType', 'url'=>array('index')),
	array('label'=>'Create FileType', 'url'=>array('create')),
	array('label'=>'View FileType', 'url'=>array('view', 'id'=>$model->name)),
	array('label'=>'Manage FileType', 'url'=>array('admin')),
);
?>

<h1>Update FileType <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
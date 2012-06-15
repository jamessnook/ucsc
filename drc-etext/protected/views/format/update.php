<?php
$this->breadcrumbs=array(
	'Formats'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Format', 'url'=>array('index')),
	array('label'=>'Create Format', 'url'=>array('create')),
	array('label'=>'View Format', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Format', 'url'=>array('admin')),
);
?>

<h1>Update Format <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
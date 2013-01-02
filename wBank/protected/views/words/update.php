<?php
$this->breadcrumbs=array(
	'Words'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Words', 'url'=>array('index')),
	array('label'=>'Create Words', 'url'=>array('create')),
	array('label'=>'View Words', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Words', 'url'=>array('admin')),
);
?>

<h1>Update Words <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
$this->breadcrumbs=array(
	'Service Requests'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ServiceRequest', 'url'=>array('index')),
	array('label'=>'Create ServiceRequest', 'url'=>array('create')),
	array('label'=>'View ServiceRequest', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ServiceRequest', 'url'=>array('admin')),
);
?>

<h1>Update ServiceRequest <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
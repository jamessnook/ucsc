<?php
$this->breadcrumbs=array(
	'Terms'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Term', 'url'=>array('index')),
	array('label'=>'Create Term', 'url'=>array('create')),
	array('label'=>'View Term', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Term', 'url'=>array('admin')),
);
?>

<h1>Update Term <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
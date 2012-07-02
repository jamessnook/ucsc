<?php
$this->breadcrumbs=array(
	'Id Types'=>array('index'),
	$model->name=>array('view','id'=>$model->name),
	'Update',
);

$this->menu=array(
	array('label'=>'List IdType', 'url'=>array('index')),
	array('label'=>'Create IdType', 'url'=>array('create')),
	array('label'=>'View IdType', 'url'=>array('view', 'id'=>$model->name)),
	array('label'=>'Manage IdType', 'url'=>array('admin')),
);
?>

<h1>Update IdType <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
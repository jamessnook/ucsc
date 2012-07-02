<?php
$this->breadcrumbs=array(
	'Id Types'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List IdType', 'url'=>array('index')),
	array('label'=>'Create IdType', 'url'=>array('create')),
	array('label'=>'Update IdType', 'url'=>array('update', 'id'=>$model->name)),
	array('label'=>'Delete IdType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->name),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage IdType', 'url'=>array('admin')),
);
?>

<h1>View IdType #<?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
	),
)); ?>

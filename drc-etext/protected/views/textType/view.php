<?php
$this->breadcrumbs=array(
	'Text Types'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List TextType', 'url'=>array('index')),
	array('label'=>'Create TextType', 'url'=>array('create')),
	array('label'=>'Update TextType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TextType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TextType', 'url'=>array('admin')),
);
?>

<h1>View TextType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'shortName',
	),
)); ?>

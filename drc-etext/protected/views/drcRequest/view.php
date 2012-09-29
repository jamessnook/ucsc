<?php
$this->breadcrumbs=array(
	'Drc Requests'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List DrcRequest', 'url'=>array('index')),
	array('label'=>'Create DrcRequest', 'url'=>array('create')),
	array('label'=>'Update DrcRequest', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete DrcRequest', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DrcRequest', 'url'=>array('admin')),
);
?>

<h1>View DrcRequest #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'term_code',
		'class_number',
		'emplId',
		'username',
		'accommodation_type',
		'effective_date',
		'created',
	),
)); ?>

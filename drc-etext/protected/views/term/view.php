<?php
$this->breadcrumbs=array(
	'Terms'=>array('index'),
	$model->term_code,
);

$this->menu=array(
	array('label'=>'List Term', 'url'=>array('index')),
	array('label'=>'Create Term', 'url'=>array('create')),
	array('label'=>'Update Term', 'url'=>array('update', 'id'=>$model->term_code)),
	array('label'=>'Delete Term', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->term_code),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Term', 'url'=>array('admin')),
);
?>

<h1>View Term #<?php echo $model->term_code; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'term_code',
		'description',
		'start_date',
		'end_date',
	),
)); ?>

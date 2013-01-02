<?php
$this->breadcrumbs=array(
	'Assignments'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Assignment', 'url'=>array('index')),
	array('label'=>'Create Assignment', 'url'=>array('create')),
	array('label'=>'Update Assignment', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Assignment', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Assignment', 'url'=>array('admin')),
);
?>

<h1>View Assignment #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'term_code',
		'class_number',
		'book_id',
		'created',
		'modified',
		'modified_by',
		'notes',
		'is_complete',
		'has_zip_file',
	),
)); ?>

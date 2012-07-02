<?php
$this->breadcrumbs=array(
	'Book Requests'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List BookRequest', 'url'=>array('index')),
	array('label'=>'Create BookRequest', 'url'=>array('create')),
	array('label'=>'Update BookRequest', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete BookRequest', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BookRequest', 'url'=>array('admin')),
);
?>

<h1>View BookRequest #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'request_id',
		'username',
		'book_id',
		'global_id',
		'id_type',
		'title',
		'author',
		'edition',
		'request_date',
		'class_name',
		'notes',
	),
)); ?>

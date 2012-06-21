<?php
$this->breadcrumbs=array(
	'Books'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Book', 'url'=>array('index')),
	array('label'=>'Create Book', 'url'=>array('create')),
	array('label'=>'Update Book', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Book', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Book', 'url'=>array('admin')),
	array('label'=>'Upload Files','url'=>array('file/upload', 'book_id'=>$model->id)),
	array('label'=>'Download Files','url'=>array('file/download', 'book_id'=>$model->id)),
	);
?>

<h1>View Book: <?php echo $model->title; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'global_id',
		'id_type',
		'title',
		'author',
		'edition',
		'is_complete',
		'is_viewable',
	),
)); ?>

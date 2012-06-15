<?php
$this->breadcrumbs=array(
	'Texts'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Text', 'url'=>array('index')),
	array('label'=>'Create Text', 'url'=>array('create')),
	array('label'=>'Update Text', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Text', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Text', 'url'=>array('admin')),
	array('label'=>'Manage Files','url'=>array('file/admin', 'text_id'=>$model->id, 'File'=>'true')),
	array('label'=>'Upload Files','url'=>array('file/upload', 'text_id'=>$model->id, 'File'=>'true')),
	array('label'=>'Download Files','url'=>array('file/download', 'text_id'=>$model->id, 'File'=>'true')),
	);
?>

<h1>View Text #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'author',
		'publisher',
		'year_published',
		'edition',
		'isbn',
		'poster_id',
		'post_date',
		'format_id',
		'is_complete',
		'is_viewable',
		'description',
	),
)); ?>

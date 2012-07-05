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
		'global_id',
		'id_type',
		'title',
		'author',
		'edition',
		'created',
		'last_changed',
		'last_changed_by',
		'notes',
		'is_complete',
		'has_zip_file',
	),
)); ?>

<h2>Download Files</h2>

<?php 
	$files = File::model()->findAllByAttributes(array('parent_id'=>$model->id), array('order'=>'type,name'));
    foreach ($files as $file) {
    	echo CHtml::link("$file->name, ", array('file/download', 'name'=>$file->name, 'path'=>$file->path),
	      array('class'=>'donwload_link')
	   );
	   echo '<br/>';
    }
 ?>

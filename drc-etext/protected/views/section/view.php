<?php
$this->breadcrumbs=array(
	'Sections'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Section', 'url'=>array('index')),
	array('label'=>'Create Section', 'url'=>array('create')),
	array('label'=>'Update Section', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Section', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Section', 'url'=>array('admin')),
);
?>

<h1>View Section #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'course_id',
		'term_id',
		'instructor_id',
		'name',
	),
)); ?>

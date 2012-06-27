<?php
$this->breadcrumbs=array(
	'Service Requests'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ServiceRequest', 'url'=>array('index')),
	array('label'=>'Create ServiceRequest', 'url'=>array('create')),
	array('label'=>'Update ServiceRequest', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ServiceRequest', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ServiceRequest', 'url'=>array('admin')),
);
?>

<h1>View ServiceRequest #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'term_id',
		'class_id',
		'course',
		'section',
		'course_id',
		'session_code',
		'course_name',
		'subject',
		'catalog_nbr',
		'instructor_id',
		'student_id',
		'username',
		'type',
		'type_name',
	),
)); ?>

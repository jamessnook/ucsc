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
		'class_number',
		'class_section',
		'session_code',
		'course_offer_number',
		'course_id',
		'course_name',
		'subject',
		'catalog_nbr',
		'instructor_id',
		'instructor_cruzid',
		'student_id',
		'username',
		'accommodation_type',
		'type_name',
		'effective_date',
		'created',
		'last_changed',
		'last_changed_by',
	),
)); ?>

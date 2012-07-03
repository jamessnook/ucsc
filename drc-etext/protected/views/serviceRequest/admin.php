<?php
$this->breadcrumbs=array(
	'Service Requests'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ServiceRequest', 'url'=>array('index')),
	array('label'=>'Create ServiceRequest', 'url'=>array('create')),
	array('label'=>'Import AIS Requests', 'url'=>array('import')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('service-request-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Service Requests</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'service-request-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'term_id',
		'class_number',
		'class_section',
		'session_code',
		'course_offer_number',
		/*
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
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

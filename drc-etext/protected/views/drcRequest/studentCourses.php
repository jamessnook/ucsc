<?php
$this->breadcrumbs=array(
	'DRC Requests'=>array('index'),
	'My Courses',
);

$this->menu=array(
	//array('label'=>'List BookRequest', 'url'=>array('index')),
	//array('label'=>'Create BookRequest', 'url'=>array('create')),
	//array('label'=>'Upload Files','url'=>array('file/upload', 'bookRequest_id'=>$model->id)),
	//array('label'=>'Download Files','url'=>array('file/download', 'bookRequest_id'=>$model->id)),
	//array('label'=>'My Books', 'url'=>array('myBooks')),
	//array('label'=>'Request a Book', 'url'=>array('create')),
	);

// make term list menu could make widget
$now = date('Y-m-d');
$terms =  Term::model()->findAll( "start_date < $now" );
foreach($terms AS $term){
	$this->menu['label'] = $term->description;
	$this->menu['url'] = array('drcRequest/studentCourses', 'termCode'=>$term->term_code);
}
	
	
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('book-request-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>My Courses</h1>

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

<?php 
$model->username = Yii::app()->user->name;  // set up for current user
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'drc-request-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'course.title',
		//array( 
		//	'name'=>'Course Name', 
		//	'value'=>'$data->course->title', 
		 //),
		array( 
			'name'=>'course.idString()', 
			'value'=>'$data->course->idString()', 
			// 'value'=>'$data->a.\' \'.$data->b.\' \'.$data->c',
			//'filter' => CHtml::listData(Term::model()->findAll(), 'id', 'name'), 
			//'htmlOptions'=>array('width'=>'110px', 'class'=>'term'),
		 ),
		array( 
			'name'=>'course.faculty()', 
			'value'=>'$data->course->faculty()', 
		 ),
		array( 
			'name'=>'course.assignmentCount()', 
			'value'=>'$data->course->assignmentCount()', 
		 ),
		 array( 
			'name'=>'course.completed()', 
			'value'=>'$data->course->completed()', 
		 ),
	),
)); ?>


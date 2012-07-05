<?php
$this->breadcrumbs=array(
	'Book Requests'=>array('index'),
	'MyBooks',
);

$this->menu=array(
	array('label'=>'List BookRequest', 'url'=>array('index')),
	array('label'=>'Create BookRequest', 'url'=>array('create')),
	array('label'=>'Upload Files','url'=>array('file/upload', 'bookRequest_id'=>$model->id)),
	array('label'=>'Download Files','url'=>array('file/download', 'bookRequest_id'=>$model->id)),
	array('label'=>'My Books', 'url'=>array('myBooks')),
	array('label'=>'Request a Book', 'url'=>array('create')),
	);

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

<h1>My Book Requests</h1>

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
	'id'=>'book-request-grid',
	'dataProvider'=>$model->findForUserAndTerm(Yii::app()->user->name, Term::model()->getCurrentTermId()),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'request_id',
		'global_id',
		'id_type',
		'title',
		'author',
		/*
		'edition',
		'created',
		'last_changed',
		'last_changed_by',
		'notes',
		'is_complete',
		*/
		array(
			'class'=>'CButtonColumn',
			'buttons'=>array(
				'download'=>array(
					'label'=>'Download',     // text label of the button
	    			//'url'=>Yii::app()->createAbsoluteUrl("file/download"),       // a PHP expression for generating the URL of the button
	    			'url'=>'Yii::app()->createUrl("file/download", array("parent_id"=>$data->id))',       // a PHP expression for generating the URL of the button
					//'imageUrl'=>'...',  // image URL of the button. If not set or false, a text link is used
	    			//'options'=>array(), // HTML options for the button tag
	    			//'click'=>'...',     // a JS function to be invoked when the button is clicked
	    			//'visible'=>'...',   // a PHP expression for determining whether the button is visible
				),
			),
			'template'=>'{view}{update}{delete}{download}',
		),
	),
)); ?>

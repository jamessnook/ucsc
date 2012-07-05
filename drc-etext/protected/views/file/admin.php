<?php
$this->breadcrumbs=array(
	'Files'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List File', 'url'=>array('index')),
	array('label'=>'Create File', 'url'=>array('create')),
	array('label'=>'Upload Files','url'=>array('upload')),
	array('label'=>'Download Files','url'=>array('download')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('file-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Files</h1>

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
	'id'=>'file-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'path',
		'caption',
		'parent_id',
		'type',
		/*
		'order_num',
		'post_date',
		'poster_id',
		*/
		array(
			'class'=>'CButtonColumn',
			'buttons'=>array(
				'download'=>array(
					'label'=>'Download',     // text label of the button
	    			//'url'=>Yii::app()->createAbsoluteUrl("file/download"),       // a PHP expression for generating the URL of the button
	    			'url'=>'Yii::app()->createUrl("file/download", array("name"=>$data->name, "path"=>$data->path))',       // a PHP expression for generating the URL of the button
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

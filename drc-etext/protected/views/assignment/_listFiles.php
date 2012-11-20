							
<h3>Curent Files for <?php echo $model->title ?></h3>

<?php 

//$model->username = Yii::app()->user->name;  // set up for current user

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'assignmentFilesGrid2',
	'dataProvider'=>$model->assignmentFiles(),
	//'filter'=>$model,
	//'hideHeader'=>true,
	'summaryText'=>'',
	'enablePagination'=>false,
	'loadingCssClass'=>'',
	//'itemsCssClass'=>"table table-striped table-bordered data-table", 
	'itemsCssClass'=>"table table-striped table-bordered", 
	'pager'=>array('class'=>'CLinkPager', 'header'=>''), 
	'pagerCssClass'=>"pagination", 
	'columns'=>array(
		array( 
			'header'=>'Type', 
			'name'=>'file.type', 
			'type'=>'raw',
			'value'=>'\'<span class="badge">\' . $data->file->type->name . \'</span>\'', 
		),
		array( 
			'header'=>'File', 
			'class'=>'CLinksColumn',
			'labelExpression'=>'$data->file->name', 
			'urlExpression'=>'array(\'file/download\', \'id\'=>$data->file_id, )', 
		),
		array( 
			'header'=>'Description', 
			'name'=>'file.description', 
			'value'=> '$data->file->description', 
		 ),
	),
));

?>

							

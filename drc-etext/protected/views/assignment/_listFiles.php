							
<h3>Curent Files for this Assignment</h3>

<?php 

//$model->username = Yii::app()->user->name;  // set up for current user
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'assignmentFilesGrid',
	'dataProvider'=>$model->assignmentFiles(),
	//'filter'=>$model,
	//'hideHeader'=>true,
	'summaryText'=>'',
	'enablePagination'=>false,
	'loadingCssClass'=>'',
	'itemsCssClass'=>"table table-striped table-bordered data-table", 
	'pager'=>array('class'=>'CLinkPager', 'header'=>''), 
	'pagerCssClass'=>"pagination", 
	'columns'=>array(
		array( 
			'header'=>'Type', 
			'name'=>'file.type.type', 
			'type'=>'raw',
			'value'=>'\'<span class="badge">\' . $data->file->type->name . \'</span>\'', 
		),
		array( 
			'header'=>'File', 
			'class'=>'CLinksColumn',
			'labelExpression'=>'$data->file->name', 
			'urlExpression'=>'array(\'assignment/files\', \'id\'=>$data->id)', 
		),
		array( 
			'header'=>'Description', 
			'name'=>'file.description', 
			'value'=> '$data->file->description', 
		 ),
	),
)); 
?>

							

<?php
/**
 * The base view component file for displaying a list of files.
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.file
 */
?>

							
<h3>Curent Files:</h3>

<?php 

//$model->username = Yii::app()->user->name;  // set up for current user

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'assignmentFilesGrid2',
	'dataProvider'=>$model->files(),
	//'filter'=>$model,
	//'hideHeader'=>true,
	'summaryText'=>'',
	'enablePagination'=>false,
	'loadingCssClass'=>'',
	'showTableOnEmpty'=>false,
	//'itemsCssClass'=>"table table-striped table-bordered data-table", 
	'itemsCssClass'=>"table table-striped table-bordered", 
	'pager'=>array('class'=>'CLinkPager', 'header'=>''), 
	'pagerCssClass'=>"pagination", 
	'columns'=>array(
		array( 
			'header'=>'Type', 
			'name'=>'file.type', 
			'type'=>'raw',
			'value'=>'\'<span class="badge">\' . $data->file->getType() . \'</span>\'', 
		),
		array( 
			'header'=>'File', 
			'class'=>'LinksColumn',
			'labelExpression'=>'$data->file->name', 
			'urlExpression'=>'array(\'downloadFile\', \'id\'=>$data->file_id, )', 
		),
		array( 
			'header'=>'Description', 
			'name'=>'file.description', 
		 	'htmlOptions'=>array('class'=>"input-col",),
		 	'type'=>'raw',
			'value'=>'CHtml::textField("d" . $data->file->id, $data->file->description, array("class"=>"input-item input-xxlarge",));',
		),
	),
));

?>

							

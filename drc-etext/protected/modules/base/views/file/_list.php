<?php
/**
 * The base view component file for displaying a list of files.
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.file
 */


// echo "<h3>Curent Files for {$model->title} </h3>";

//$model->username = Yii::app()->user->name;  // set up for current user

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'assignmentFilesGrid2',
	'dataProvider'=>$model->files(),
	//'filter'=>$model,
	//'hideHeader'=>true,
	'summaryText'=>'',
	'emptyText'=>'No files found for the selected course.',
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
			'value'=>'\'<span class="badge">\' . $data->file->type . \'</span>\'', 
		),
		array( 
			'header'=>'File Name', 
			'class'=>'LinksColumn',
			'labelExpression'=>'$data->file->name', 
			'urlExpression'=>'array(\'base/file/download\', \'id\'=>$data->file_id, )', 
		),
		array( 
			'header'=>'Label', 
			'name'=>'file.label', 
			'value'=> '$data->file->label', 
		 ),
		array( 
			'header'=>'Description', 
			'name'=>'file.description', 
			'value'=> '$data->file->description', 
		 ),
		 array( 
			'header'=>'', 
			'class'=>'LinksColumn',
		 	'htmlOptions'=>array('class'=>"input-col"),
		 	'linkHtmlOptions'=>array('class'=>"btn input-item"),
		 	'labelExpression'=>'\'Edit\'', 
			'urlExpression'=>'array(\'course/updateFile\', \'id\'=>$data->file_id, \'term_code\'=>\'' . $model->term_code . '\', \'class_num\'=>\'' . $model->class_num . '\')', 
		 ),
		 array( 
			'header'=>'', 
			'class'=>'LinksColumn',
		 	'htmlOptions'=>array('class'=>"input-col"),
		 	'linkHtmlOptions'=>array('class'=>"btn input-item"),
			'labelExpression'=>'\'Remove\'', 
			'urlExpression'=>'array(\'course/deleteFile\', \'id\'=>$data->file_id, \'model_id\'=>\'' . $model->id . '\', \'term_code\'=>\'' . $model->term_code . '\', \'class_num\'=>\'' . $model->class_num . '\')', 
		 ),
	 ),
));

?>

							

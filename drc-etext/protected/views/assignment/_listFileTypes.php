<?php
/**
 * The base view component file for displaying a list of file types and students using an assignment.
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.book
 */
?>

							
<h3>Required file types: </h3>

<?php 

//$model->username = Yii::app()->user->name;  // set up for current user

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'assignmentFilesGrid2',
	'dataProvider'=>$model->fileTypes(),
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
			'header'=>'File Type', 
			'name'=>'fileType', 
			'value'=> '$data->name',
		),
		array( 
			'header'=>'Students', 
			'name'=>'students', 
			'value'=> '$data->students()',
			'type'=>'raw',
			'value'=>'eval(\'
				$tString = ""; 
				foreach($data->students() as $student){
					$tString .= $student->nameLastFirst() ."; &nbsp; ";
				}
				return $tString;
			\')',
		), 
	),
));

?>

							

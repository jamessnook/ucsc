<?php
/**
 * The base view component file for displaying a list of users.
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.user
 */
?>


<div class="row-fluid">
    <div class="span12">
		<h3><?php echo $contentTitle; 	?> </h3>

	<?php 
	
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'drc-request-grid',
		'dataProvider'=>$dataProvider,
		'summaryText'=>'',
		'showTableOnEmpty'=>false,
		'enablePagination'=>false,
		'itemsCssClass'=>"table table-striped table-bordered data-table", 
		'loadingCssClass'=>'',
		'pager'=>array('class'=>'CLinkPager', 'header'=>''), 
		'pagerCssClass'=>"pagination", 
		'columns'=>array(
			array( 
				'header'=>'Cruz Id', 
				'class'=>'LinksColumn',
				'labelExpression'=>'$data->username',
				'urlExpression'=>'array(\'drcUser/update\', \'username\'=>$data->username, \'term_code\'=>\''. $model->term_code . '\')', 
			),
			array( 
				'header'=>'EmplId', 
				'name'=>'emplid', 
				'value'=>'$data->emplid', 
			 ),
			 array( 
				'header'=>'Name', 
				'class'=>'LinksColumn',
				'labelExpression'=>'$data->last_name . \', \' . $data->first_name', 
				//'urlExpression'=>'array(\'user/courses\', \'username\'=>$data->username,' . $paramStr  .')', 
				'urlExpression'=>'array(\'drcUser/courses\', \'username\'=>$data->username, \'term_code\'=>\''. $model->term_code . '\')',  
			 ),
			 array( 
				'header'=>'Courses', 
				'class'=>'LinksColumn',
				//'labelExpression'=>'\'test\'', 
				//'urlExpression'=>'\'test\'', 
			 	'labelExpression'=>'$data->courseNames()', 
				'urlExpression'=>array('model'=>'$data->courseList()', 'route'=>'course/students', 'modelParams'=>array('term_code'=>'term_code', 'class_num'=>'class_num')), 
			),
			
			array( 
				'header'=>'Type', 
				'name'=>'drcRequests.type', 
				'type'=>'raw',
				'value'=>'\'<span class="badge">\' . $data->typesString() . \'</span>\'', 
			 ),
			 
			 array( 
				'header'=>'Status', 
				'class'=>'LinksColumn',
			 	//'type'=>'raw',
			 	'urlExpression'=>'array(\'user/courses\', \'username\'=>$data->username, \'term_code\'=>\''. $model->term_code . '\')',  
			 	'labelExpression'=>'$data->drcRequestsCompleted()? \'<span class="badge badge-success">Completed</span>\' : \'<span class="badge badge-warning">Pending</span>\'', 
			),
		),
	)); 
	?>

    </div><!--/span-->
</div><!--/row-->

<?php
/**
 * The base view component file for an assignment list for administrators.
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.assignment
 */
?>

<div class="row-fluid">
    <div class="span12">
		<h3>Assignment Management</h3>

	<?php 
	
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'adminAssignmentGrid',
		'dataProvider'=>$model->search(),
		'summaryText'=>'',
		'enablePagination'=>false,
		'loadingCssClass'=>'',
		'showTableOnEmpty'=>false,
		'itemsCssClass'=>"table table-striped table-bordered data-table", 
		'pager'=>array('class'=>'CLinkPager', 'header'=>''), 
		'pagerCssClass'=>"pagination", 
		'columns'=>array(
			array( 
				'header'=>'Class ID', 
				'name'=>'idString', 
				//'value'=>'$data->course->idString()', 
				'value'=>'$data->course? $data->course->idString() : \'No Course Data\'', 
			),
			array( 
				'header'=>'Title', 
				'class'=>'LinksColumn',
				'labelExpression'=>'$data->title', 
				'urlExpression'=>'array(\'course/updateAssignment\', \'id\'=>$data->id)', 
			),
			array( 
				'header'=>'Description', 
				'name'=>'description', 
				'value'=>'$data->description', 
			 ),
			array( 
				'header'=>'Type', 
				'name'=>'type', 
				'value'=>'$data->typesString()', 
			 ),
			 array( 
				'header'=>'Due Date', 
				'name'=>'due_date', 
				'value'=>'$data->due_date', 
			 ),
			 array( 
				'header'=>'Status', 
			 	'name'=>'completed()', 
				'type'=>'raw',
			 	'value'=>'$data->is_complete? \'<span class="badge badge-success">Completed</span>\' : \'<span class="badge badge-warning">Pending</span>\'', 
			 ),
			 array( 
				'header'=>'', 
				'class'=>'LinksColumn',
				'label'=>'Edit', 
			 	'linkHtmlOptions'=>array('class'=>"btn",),
				'urlExpression'=>'array(\'course/updateAssignment\', \'id\'=>$data->id)', 
			 ),
			 array( 
				'header'=>'', 
				'name'=>'delete', 
				'type'=>'raw',
				'value'=>'\'<a href="#" class="btn">Remove</a>\'', 
			 ),
		),
	)); 
	?>

    </div><!--/span-->
</div><!--/row-->

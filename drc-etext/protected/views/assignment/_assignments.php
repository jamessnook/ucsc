
<div class="row-fluid">
    <div class="span12">
		<h3>Assignments</h3>

	<?php 
	
	//$model->username = Yii::app()->user->name;  // set up for current user
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'assignmentGrid',
		'dataProvider'=>$model->courseAssignments(),
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
				'header'=>'Assignment Title', 
				'class'=>'CLinksColumn',
				'labelExpression'=>'$data->title', 
				'urlExpression'=>'array(\'assignmentFiles/studentAssignmentFiles\', \'assignmentId\'=>$data->id)', 
			),
			array( 
				'header'=>'Book Title', 
				'name'=>'book.title', 
				'value'=>'$data->book->title', 
			 ),
			array( 
				'header'=>'Files', 
				'name'=>'fileCount()', 
				'type'=>'raw',
				'value'=>'\'<span class="badge">\' . $data->fileCount() . \'</span>\'', 
			 ),
			 array( 
				'header'=>'Status', 
			 	'name'=>'completed()', 
				'type'=>'raw',
			 	'value'=>'$data->is_complete? \'<span class="badge badge-success">Completed</span>\' : \'<span class="badge badge-warning">Pending</span>\'', 
			 ),
		),
	)); 
	?>

    </div><!--/span-->
</div><!--/row-->

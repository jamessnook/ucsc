
<div class="row-fluid">
    <div class="span12">
		<h3>Assignment Management</h3>

	<?php 
	
	//$model->username = Yii::app()->user->name;  // set up for current user
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'assignmentGrid',
		'dataProvider'=>$model->search(),
		//'filter'=>$model,
		//'hideHeader'=>true,
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
				'name'=>'idString()', 
				'value'=>'$data->course->idString()', 
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
				'value'=>'$data->types()', 
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
				//'labelExpression'=>'\'<span class="btn">Edit</span>\'', 
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

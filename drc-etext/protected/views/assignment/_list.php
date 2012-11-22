
<div class="row-fluid">
    <div class="span12">
		<h3>Assignments: <?php if (isset($model->username) && strlen($model->username) > 0) echo 'For ' . $model->username; ?></h3>

	<?php 
	
	//$model->username = Yii::app()->user->name;  // set up for current user
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'assignmentGrid',
		'dataProvider'=>$model->assignments(),
		//'filter'=>$model,
		//'hideHeader'=>true,
		'summaryText'=>'',
		'enablePagination'=>false,
		'showTableOnEmpty'=>false,
		'loadingCssClass'=>'',
		'itemsCssClass'=>"table table-striped table-bordered data-table", 
		'pager'=>array('class'=>'CLinkPager', 'header'=>''), 
		'pagerCssClass'=>"pagination", 
		'columns'=>array(
			array( 
				'header'=>'Assignment Title', 
				'class'=>'CLinksColumn',
				//'name'=>'title', 
				//'value'=>'$data->title', 
				'labelExpression'=>'$data->title', 
				'urlExpression'=>'array(\'course/updateAssignment\', \'id\'=>$data->id, \'username\'=>\''. $model->username . '\')',  
			),
			array( 
				'header'=>'Book Title', 
				'name'=>'book.title', 
				'value'=>'$data->book? $data->book->title : \' \'', 
				//'type'=>'raw',
				//'value'=>'$data->book->title', 
			),
			array( 
				'header'=>'Files', 
				'class'=>'CLinksColumn',
				//'name'=>'fileCount()', 
				//'type'=>'raw',
				//'value'=>'\'<span class="badge">\' . $data->fileCount() . \'</span>\'', 
				//'labelExpression'=>'\'<span class="badge">\' . $data->fileCount() . \'</span>\'', 
				'labelExpression'=>'$data->fileCount()', 
				'linkHtmlOptions'=>array('class'=>"badge"),
				'urlExpression'=>'array(\'course/assignmentFiles\', \'id\'=>$data->id, \'username\'=>\''. $model->username . '\')', 
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

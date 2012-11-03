<div class="row-fluid">
    <div class="span12">

	<?php 
	
	//$model->username = Yii::app()->user->name;  // set up for current user
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'assignmentFilesGrid',
		'dataProvider'=>$model->studentAssignmentFiles(),
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
				'header'=>'File', 
				'class'=>'CLinksColumn',
				'labelExpression'=>'$data->title', 
				'urlExpression'=>'array(\'assignment/files\', \'id\'=>$data->id)', 
			),
			array( 
				'header'=>'Type', 
				'name'=>'book.title', 
				'value'=>'$data->book->title', 
			 ),
			array( 
				'header'=>'Description', 
				'name'=>'fileCount()', 
				'type'=>'raw',
				'value'=>'\'<span class="badge">\' . $data->fileCount() . \'</span>\'', 
			 ),
		),
	)); 
	?>

		
    </div><!--/span-->
</div><!--/row-->

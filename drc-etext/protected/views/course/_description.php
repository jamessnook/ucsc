		<div class="row-fluid">
            <div class="span12">
				<h3>Course Description</h3>
				<p><?php echo $model->description; ?></p>
						
	<?php 
	
	//$model->username = Yii::app()->user->name;  // set up for current user
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'assignmentFilesGrid',
		'dataProvider'=>$model->search(),
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
				'header'=>'Days and Times', 
				'name'=>'schedule', 
				'value'=>'$data->schedule', 
			 ),
			array( 
				'header'=>'Room', 
				'name'=>'room', 
				'value'=>'$data->room', 
			 ),
			 array( 
				'header'=>'Instructors', 
				'class'=>'LinksColumn',
				'labelExpression'=>'$data->facultyNames()', 
				'urlExpression'=>'$data->facultyUrls()', 
			 ),
			 array( 
				'header'=>'Meeting Dates', 
				'name'=>'dates', 
				'value'=>'$data->dates', 
			 ),
		),
	)); 
	?>

		
    </div><!--/span-->
</div><!--/row-->

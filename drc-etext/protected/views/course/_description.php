<?php
/**
 * The base view component file for displaying data for a single course.
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.course
 */
?>

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

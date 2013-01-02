<?php
/**
 * The base view component file for displaying a list of courses.
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.course
 */
?>


<div class="row-fluid">
    <div class="span12">
		<h3>Courses: <?php if (isset($model->term_code) && $model->term_code > 0) echo Term::model()->findByPk($model->term_code)->description; ?></h3>

	<?php 
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'coursesGrid',
		'dataProvider'=>$model->courses(),
		//'filter'=>$model,
		//'hideHeader'=>true,
		'summaryText'=>'',
		'enablePagination'=>false,
		'showTableOnEmpty'=>false,
		'itemsCssClass'=>"table table-striped table-bordered data-table", 
		'loadingCssClass'=>'',
		'pager'=>array('class'=>'CLinkPager', 'header'=>''), 
		'pagerCssClass'=>"pagination", 
		'columns'=>array(
			array( 
				'header'=>'Course Name', 
				'class'=>'LinksColumn',
				'labelExpression'=>'$data->title', 
				'urlExpression'=>'array(\'course/assignments\', \'term_code\'=>$data->term_code, \'class_num\'=>$data->class_num,)', 
			),
			array( 
				'header'=>'Class Id', 
				'name'=>'idString()', 
				'value'=>'$data->idString()', 
			 ),
			array( 
				'header'=>'Faculty', 
				'class'=>'LinksColumn',
				'labelExpression'=>'$data->facultyNames()', 
				'urlExpression'=>'$data->facultyUrls()', 
			),
			array( 
				'header'=>'Assignments', 
				'class'=>'LinksColumn',
				'labelExpression'=>'\'<span class="badge">\' . $data->assignmentCount() . \'</span>\'', 
				'urlExpression'=>'array(\'course/assignments\', \'term_code\'=>$data->term_code, \'class_num\'=>$data->class_num, \'username\'=>\''. $model->username . '\')', 
			),
			 array( 
				'header'=>'Status', 
				'class'=>'LinksColumn',
			 	'labelExpression'=>'$data->completed()? \'<span class="badge badge-success">Completed</span>\' : \'<span class="badge badge-warning">Pending</span>\'', 
				'urlExpression'=>'array(\'course/assignments\', \'term_code\'=>$data->term_code, \'class_num\'=>$data->class_num, \'username\'=>\''. $model->username . '\')', 
			 ),
		),
	)); 
	
	?>

    </div><!--/span-->
</div><!--/row-->

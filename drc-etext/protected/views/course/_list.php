<?php
/**
 * The base view component file for displaying a list of courses.
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.course
 */

if (!isset($contentTitle) || $contentTitle == ''){
	$contentTitle = "Courses";
	if (isset($model->term_code) && $model->term_code > 0){
		$contentTitle .= ": " . Term::model()->findByPk($model->term_code)->description; 
	}
}

?>


<div class="row-fluid">
    <div class="span12">
		<h3><?php echo $contentTitle; ?> </h3>

	<?php 
	$courseUrlExpression = '';
	if (Yii::app()->user->checkAccess('staff') || Yii::app()->user->checkAccess('admin')){
		$courseUrlExpression = 'array(\'course/assignments\', \'term_code\'=>$data->term_code, \'class_num\'=>$data->class_num,)';
	} else if (Yii::app()->user->checkAccess('faculty') ){
		$courseUrlExpression = 'array(\'course/files\', \'term_code\'=>$data->term_code, \'class_num\'=>$data->class_num, \'username\'=>$data->username,)';
	} else {
		$courseUrlExpression = 'array(\'course/assignments\', \'term_code\'=>$data->term_code, \'class_num\'=>$data->class_num, \'username\'=>$data->username,)';
	}
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'coursesGrid',
		'dataProvider'=>$model->courses(),
		//'filter'=>$model,
		//'hideHeader'=>true,
		'summaryText'=>'',
		'enablePagination'=>false,
		'showTableOnEmpty'=>false,
		'emptyText'=>'No courses found for the selected quarter.',
		'itemsCssClass'=>"table table-striped table-bordered data-table", 
		'loadingCssClass'=>'',
		'pager'=>array('class'=>'CLinkPager', 'header'=>''), 
		'pagerCssClass'=>"pagination", 
		'columns'=>array(
			array( 
				'header'=>'Course Name', 
				'class'=>'LinksColumn',
				'labelExpression'=>'$data->title', 
				'urlExpression'=>$courseUrlExpression, 
				// for instructors load the course files page
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
			 	'labelExpression'=>'$data->completed(\''. $model->username . '\')? \'<span class="badge badge-success">Completed</span>\' : \'<span class="badge badge-warning">Pending</span>\'', 
				'urlExpression'=>'array(\'course/assignments\', \'term_code\'=>$data->term_code, \'class_num\'=>$data->class_num, \'username\'=>\''. $model->username . '\')', 
			 ),
		),
	)); 
	
	?>

    </div><!--/span-->
</div><!--/row-->

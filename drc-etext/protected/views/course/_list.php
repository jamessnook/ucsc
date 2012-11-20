
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
				'urlExpression'=>'array(\'course/assignments\', \'termCode\'=>$data->term_code, \'classNum\'=>$data->class_num, \'username\'=>\''. $model->username . '\')', 
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
				//'name'=>'assignmentCount()', 
				//'type'=>'raw',
				//'value'=>'\'<span class="badge">\' . $data->assignmentCount() . \'</span>\'', 
				'labelExpression'=>'\'<span class="badge">\' . $data->assignmentCount() . \'</span>\'', 
				'urlExpression'=>'array(\'course/assignments\', \'termCode\'=>$data->term_code, \'classNum\'=>$data->class_num, \'username\'=>\''. $model->username . '\')', 
						 ),
			 array( 
				'header'=>'Status', 
				'class'=>'LinksColumn',
			 	//'name'=>'course.completed()', 
				//'type'=>'raw',
			 	//'value'=>'$data->completed()? \'<span class="badge badge-success">Completed</span>\' : \'<span class="badge badge-warning">Pending</span>\'', 
			 	'labelExpression'=>'$data->completed()? \'<span class="badge badge-success">Completed</span>\' : \'<span class="badge badge-warning">Pending</span>\'', 
				'urlExpression'=>'array(\'course/assignments\', \'termCode\'=>$data->term_code, \'classNum\'=>$data->class_num)', 
			 ),
		),
	)); 
	
	?>

    </div><!--/span-->
</div><!--/row-->

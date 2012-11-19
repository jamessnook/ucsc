
<div class="row-fluid">
    <div class="span12">
		<h3>Students</h3>

	<?php 
	
	$model->username = Yii::app()->user->name;  // set up for current user
	//$params = array();
	$paramStr = '';
	if ($model->term_code) {
		//$params['termCode'] = $model->term_code;
		$paramStr .=  '\'termCode\' =>' . $model->term_code; 
	}
	//if ($model->class_num) $params['classNum'] = $model->class_num;
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'drc-request-grid',
		'dataProvider'=>$model->students(),
		//'filter'=>$model,
		//'hideHeader'=>true,
		'summaryText'=>'',
		//'emptyText'=>'Sorry, no data',
		'showTableOnEmpty'=>false,
		'enablePagination'=>false,
		'itemsCssClass'=>"table table-striped table-bordered data-table", 
		'loadingCssClass'=>'',
		'pager'=>array('class'=>'CLinkPager', 'header'=>''), 
		'pagerCssClass'=>"pagination", 
		'columns'=>array(
			array( 
				'header'=>'Cruz Id', 
				'class'=>'LinksColumn',
				'labelExpression'=>'$data->username',
				'urlExpression'=>'array(\'user/update\', \'username\'=>$data->username)', 
			),
			array( 
				'header'=>'EmplId', 
				'name'=>'emplid', 
				'value'=>'$data->emplid', 
			 ),
			 array( 
				'header'=>'Name', 
				'class'=>'LinksColumn',
				'labelExpression'=>'$data->last_name . \', \' . $data->first_name', 
				//'urlExpression'=>'array(\'user/courses\', \'username\'=>$data->username,' . $paramStr  .')', 
				'urlExpression'=>'array(\'user/courses\', \'username\'=>$data->username)', 
			 ),
			 array( 
				'header'=>'Courses', 
				'class'=>'LinksColumn',
				//'labelExpression'=>'\'test\'', 
				//'urlExpression'=>'\'test\'', 
			 	'labelExpression'=>'$data->drcRequestCourseNames()', 
				'urlExpression'=>array('model'=>'$data->drcRequests', 'route'=>'course/description', 'params'=>array('termCode'=>'term_code', 'classNum'=>'class_num')), 
			),
			//array( 
			//	'header'=>'Type', 
			//	'name'=>'drcRequests.type', 
			//	'type'=>'raw',
			//	'value'=>'\'<span class="badge">\' . $data->drcRequests[0]->type . \'</span>\'', 
			// ),
			 array( 
				'header'=>'Status', 
				'class'=>'LinksColumn',
			 	//'type'=>'raw',
			 	'urlExpression'=>'array(\'drcRequest/studentCourses\', \'username\'=>$data->username)',
			 	'labelExpression'=>'$data->drcRequestsCompleted()? \'<span class="badge badge-success">Completed</span>\' : \'<span class="badge badge-warning">Pending</span>\'', 
			),
		),
	)); 
	?>

    </div><!--/span-->
</div><!--/row-->

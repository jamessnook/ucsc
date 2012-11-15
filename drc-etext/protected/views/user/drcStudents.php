<?php
	//$this->breadcrumbs=array(
	//	'DRC Requests'=>array('index'),
	//	'My Courses',
	//);

	// make term list menu for use in CMenu
	$now = date('Y-m-d');
	$terms =  Term::model()->findAll( "start_date < '$now' order by term_code desc  limit 10 " );
	//$terms =  Term::model()->findAll("term_code < 2136 order by term_code desc  limit 10 " );
	foreach($terms AS $term){
		$this->menu[] = array('label'=>$term->description,'url'=> $this->createUrl('user/drcSstudents', array('termCode'=>$term->term_code)));
	}
	
?>

<div class="page-head">
	<div class="row-fluid">
		<h1 class="pull-left"><?php echo 'DRC Users: ' . Term::model()->findByPk($model->term_code)->description; ?></h1>
	</div><!--/row-->
</div><!--/head-->
<div class="row-fluid">
    <div class="span12">

	<?php 
	
	$model->username = Yii::app()->user->name;  // set up for current user
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'drc-request-grid',
		'dataProvider'=>$model->drcStudents(),
		//'filter'=>$model,
		//'hideHeader'=>true,
		'summaryText'=>'',
		'enablePagination'=>false,
		'itemsCssClass'=>"table table-striped table-bordered data-table", 
		'loadingCssClass'=>'',
		'pager'=>array('class'=>'CLinkPager', 'header'=>''), 
		'pagerCssClass'=>"pagination", 
		'columns'=>array(
			array( 
				'header'=>'Cruz Id', 
				'name'=>'username', 
				'value'=>'$data->username', 
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
				'urlExpression'=>'array(\'user/user\', \'username\'=>$data->username)', 
			),
			 array( 
				'header'=>'Courses', 
				'class'=>'LinksColumn',
				//'labelExpression'=>'$data->course->facultyNames()', 
				//'urlExpression'=>'$data->course->facultyUrls()', 
			 	'labelExpression'=>'$data->drcRequestCourseNames()', 
				'urlExpression'=>array('model'=>'$data->drcRequests', 'route'=>'course/description', 'params'=>array('termCode'=>'term_code', 'classNum'=>'class_num')), 
			),
			array( 
				'header'=>'Type', 
				'name'=>'drcRequests.type', 
				'type'=>'raw',
				'value'=>'\'<span class="badge">\' . $data->drcRequests[0]->type . \'</span>\'', 
			 ),
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

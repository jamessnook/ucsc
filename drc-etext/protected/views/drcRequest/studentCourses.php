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
		$this->menu[] = array('label'=>$term->description,'url'=> $this->createUrl('drcRequest/studentCourses', array('termCode'=>$term->term_code)));
	}
	
?>

<div class="page-head">
	<div class="row-fluid">
		<h1 class="pull-left"><?php echo $model->term->description; ?></h1>
	</div><!--/row-->
</div><!--/head-->
<div class="row-fluid">
    <div class="span12">

	<?php 
	$model->username = Yii::app()->user->name;  // set up for current user
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'drc-request-grid',
		'dataProvider'=>$model->search(),
		//'filter'=>$model,
		//'hideHeader'=>true,
		'itemsCssClass'=>"table table-striped",
		'columns'=>array(
			'course.title',
			//array( 
			//	'name'=>'Course Name', 
			//	'value'=>'$data->course->title', 
			 //),
			array( 
				'name'=>'course.idString()', 
				'value'=>'$data->course->idString()', 
				// 'value'=>'$data->a.\' \'.$data->b.\' \'.$data->c',
				//'filter' => CHtml::listData(Term::model()->findAll(), 'id', 'name'), 
				//'htmlOptions'=>array('width'=>'110px', 'class'=>'term'),
			 ),
			array( 
				'name'=>'course.faculty()', 
				'value'=>'$data->course->faculty()', 
			 ),
			array( 
				'name'=>'course.assignmentCount()', 
				'type'=>'raw',
				'value'=>'\'<span class="badge">\' . $data->course->assignmentCount() . \'</span>\'', 
			 ),
			 array( 
				'name'=>'course.completed()', 
				'type'=>'raw',
			 	'value'=>'$data->course->completed()? \'<span class="badge badge-success">Completed</span>\' : \'<span class="badge badge-warning">Pending</span>\'', 
			 ),
		),
	)); 
	?>

		
    </div><!--/span-->
</div><!--/row-->

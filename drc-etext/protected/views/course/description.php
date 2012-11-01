<?php
	//$this->breadcrumbs=array(
	//	'DRC Requests'=>array('index'),
	//	'My Courses',
	//);

	// make term list menu for use in CMenu
	$now = date('Y-m-d');
	$terms =  Term::model()->findAll( "start_date < '$now' order by term_code desc  limit 10 " );
	//$terms =  Term::model()->findAll("term_code < 2136 order by term_code desc  limit 10 " );
	//foreach($terms AS $term){
	//	$this->menu[] = array('label'=>$term->description,'url'=> $this->createUrl('drcRequest/studentCourses', array('termCode'=>$term->term_code)));
	//}
	$this->menu=array(
		array('label'=>'Assignemnts', 'url'=>array('assignment/studentAssignments', 'termCode'=>$model->term_code, 'class_num'=>$model->class_num)),
		array('label'=>'Description', 'url'=>array('course/description', 'termCode'=>$model->term_code, 'class_num'=>$model->class_num)),
		array('label'=>'Bookstore','url'=>'http://slugstore.ucsc.edu/ePOS'),
		//array('label'=>'Bookstore','url'=>'http://slugstore.ucsc.edu/ePOS?form=shared3/textbooks/json/json_books.html&term=FL12&dept=ANTH&crs=101&sec=01&store=721&dti=&desc=&bSug=YES&cSug=&H=N'),
	);
	
?>

<div class="page-head">
	<div class="row-fluid">
		<h1 class="pull-left"><?php echo $model->title .' (' .$model->idString().')'; ?></h1>
		<ul class="nav nav-pills pull-right">
		
		</ul>
	</div><!--/row-->
</div><!--/head-->
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
				'class'=>'CLinksColumn',
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

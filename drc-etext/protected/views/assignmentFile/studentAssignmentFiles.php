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
		array('label'=>'Assignemnts', 'url'=>array('assignment/studentAssignments', 'termCode'=>$model->assignment->term_code, 'class_num'=>$model->assignment->class_num)),
		array('label'=>'Description', 'url'=>array('course/description', 'termCode'=>$model->assignment->term_code, 'class_num'=>$model->assignment->class_num)),
		array('label'=>'Bookstore','url'=>'http://slugstore.ucsc.edu/ePOS'),
		//array('label'=>'Bookstore','url'=>'http://slugstore.ucsc.edu/ePOS?form=shared3/textbooks/json/json_books.html&term=FL12&dept=ANTH&crs=101&sec=01&store=721&dti=&desc=&bSug=YES&cSug=&H=N'),
	);
	
?>

<div class="page-head">
	<div class="row-fluid">
		<h1 class="pull-left"><?php echo $model->assignment->course->title .' (' .$model->assignment->course->idString().')'; ?></h1>
		<ul class="nav nav-pills pull-right">
		
		</ul>
	</div><!--/row-->
</div><!--/head-->
		<div class="row-fluid">
            <div class="span12">
				<h3><?php echo $model->assignment->title; ?></h3>
				<p><?php echo $model->assignment->description; ?></p>
						
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
				'labelExpression'=>'$data->file->name', 
				'urlExpression'=>'array(\'file/download\', \'id\'=>$data->file->id)', 
			),
			array( 
				'header'=>'Type', 
				'name'=>'file.type.name', 
				'type'=>'raw',
				'value'=>'\'<span class="label">\' . $data->file->type->name . \'</span>\'', 
			 ),
			array( 
				'header'=>'Description', 
				'name'=>'file.description', 
				'value'=>'$data->file->description', 
			 ),
		),
	)); 
	?>

		
    </div><!--/span-->
</div><!--/row-->

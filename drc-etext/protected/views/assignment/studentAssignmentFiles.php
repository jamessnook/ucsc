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
	$this->menu=array(
		array('label'=>'Assignemnts', 'url'=>array('assignment/studentAssignments', 'termCode'=>$model->term_code, 'class_num'=>$model->class_num)),
		array('label'=>'Description', 'url'=>array('assignment/descriptions', 'termCode'=>$model->term_code, 'class_num'=>$model->class_num)),
		array('label'=>'Bookstore','url'=>'http://slugstore.ucsc.edu/ePOS'),
		//array('label'=>'Bookstore','url'=>'http://slugstore.ucsc.edu/ePOS?form=shared3/textbooks/json/json_books.html&term=FL12&dept=ANTH&crs=101&sec=01&store=721&dti=&desc=&bSug=YES&cSug=&H=N'),
	);
	
?>

<div class="page-head">
	<div class="row-fluid">
		<h1 class="pull-left"><?php echo $model->course->description; ?></h1>
	</div><!--/row-->
</div><!--/head-->
<div class="row-fluid">
    <div class="span12">

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
				'labelExpression'=>'$data->title', 
				'urlExpression'=>'array(\'assignment/files\', \'id\'=>$data->id)', 
			),
			array( 
				'header'=>'Type', 
				'name'=>'book.title', 
				'value'=>'$data->book->title', 
			 ),
			array( 
				'header'=>'Description', 
				'name'=>'fileCount()', 
				'type'=>'raw',
				'value'=>'\'<span class="badge">\' . $data->fileCount() . \'</span>\'', 
			 ),
		),
	)); 
	?>

		
    </div><!--/span-->
</div><!--/row-->

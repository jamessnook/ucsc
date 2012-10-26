<?php
$this->breadcrumbs=array(
	'DRC Requests'=>array('index'),
	'My Courses',
);

$this->menu=array(
	//array('label'=>'List BookRequest', 'url'=>array('index')),
	//array('label'=>'Create BookRequest', 'url'=>array('create')),
	//array('label'=>'Upload Files','url'=>array('file/upload', 'bookRequest_id'=>$model->id)),
	//array('label'=>'Download Files','url'=>array('file/download', 'bookRequest_id'=>$model->id)),
	//array('label'=>'My Books', 'url'=>array('myBooks')),
	//array('label'=>'Request a Book', 'url'=>array('create')),
	);
	
?>

<h1>My Courses</h1>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span9">
		  	<div class="page-unit">
				<div class="page-head">
					<div class="row-fluid">
						<h1 class="pull-left"><?php echo $this->term; ?></h1>
					</div><!--/row-->
				</div><!--/head-->
				<div class="row-fluid">
		            <div class="span12">

<?php 
$model->username = Yii::app()->user->name;  // set up for current user
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'drc-request-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
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
			'value'=>'\'<span class="badge">\' . $data->course->assignmentCount() . \'</span>\'', 
		 ),
		 array( 
			'name'=>'course.completed()', 
			'value'=>'$data->course->completed()? \'<span class="badge badge-success">Completed</span>\' : \'<span class="badge badge-warning">Pending</span>\'', 
		 ),
	),
)); ?>

				
		            </div><!--/span-->
		          </div><!--/row-->
			</div><!--/page-unit-->
		  

        </div><!--/span-->
		<div class="span3">
          <div class="well">
            
        <?php

			// make term list menu could make widget
			$now = date('Y-m-d');
			$terms =  Term::model()->findAll( "start_date < $now" );
			foreach($terms AS $term){
				$this->menu['label'] = $term->description;
				$this->menu['url'] = $this->createUrl('drcRequest/studentCourses', array('termCode'=>$term->term_code));
			}
			
        	$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Quarters Menu',
				'contentCssClass'=>'nav-header',
			));
			$this->widget('zii.widgets.CMenu', array(
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'nav nav-list'),
			));
			$this->endWidget();
		?>
            
            
          </div><!--/.well -->
        </div><!--/span-->
      </div><!--/row-->
	  
    </div><!--/.fluid-container-->

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

// make term list menu could make widget
$now = date('Y-m-d');
$terms =  Term::model()->findAll( "start_date < $now" );
foreach($terms AS $term){
	$this->menu['label'] = $term->description;
	$this->menu['url'] = array('drcRequest/studentCourses', 'termCode'=>$term->term_code);
}
	
	
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('book-request-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>My Courses</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

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
			'value'=>'$data->course->assignmentCount()', 
		 ),
		 array( 
			'name'=>'course.completed()', 
			'value'=>'$data->course->completed()', 
		 ),
	),
)); ?>




	
	
	
	<div class="subnavbar">
      <div class="subnavbar-inner">
        <div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<ul class="nav nav-tabs">
						<li>
							<a href="index.html"><i class="icon-dashboard"></i> Dashboard</a>
						</li>
						<li class="active"><a href="courses.html">Courses</a></li>
						<li><a href="requests.html">Assignments</a></li>
						<li class="pull-right"><a href="reports.html"><i class="icon-wrench"></i> Reports</a></li>
						<li class="pull-right"><a href="roles.html"><i class="icon-group"></i> Roles</a></li>
						<li class="pull-right"><a href="users.html"><i class="icon-user"></i> Users</a></li>
					</ul>
				</div>
				
				
			</div>
		</div>
	  </div>
	</div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span9">
		  	<div class="page-unit">
				<div class="page-head">
					<div class="row-fluid">
						<h1 class="pull-left">Courses</h1>
						<ul class="nav nav-pills pull-right">
						      <li><a href="#"><i class="icon-plus"></i> Add Course</a></li>
						</ul>
					</div><!--/row-->
				</div><!--/head-->
				<div class="row-fluid">
		            <div class="span12">
		            	<table class="table table-striped" id="example">
							<thead>
								<tr>
									<th>Class Title</th>
									<th>Class ID</th>
									<th>Faculty</th>
									<th>Requests</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><a href="assignment.html">Photography and Anthropology</a></td>
									<td>ANTH 132 - 01</td>
									<td><a href="http://campusdirectory.ucsc.edu/detail.php?type=people&uid=sherring">Errington,S.E.</a></td>
									<td><span class="badge">7</span></td>
									<td><span class="badge badge-success">Completed</span></td>
								</tr>
								<tr>
									<td><a href="assignment.html">Photography and Anthropology</a></td>
									<td>ANTH 132 - 01</td>
									<td><a href="http://campusdirectory.ucsc.edu/detail.php?type=people&uid=sherring">Errington,S.E.</a></td>
									<td><span class="badge">7</span></td>
									<td><span class="badge badge-warning">Pending</span></td>
								</tr>
								<tr>
									<td><a href="assignment.html">Photography and Anthropology</a></td>
									<td>ANTH 132 - 01</td>
									<td><a href="http://campusdirectory.ucsc.edu/detail.php?type=people&uid=sherring">Errington,S.E.</a></td>
									<td><span class="badge">7</span></td>
									<td><span class="badge badge-warning">Pending</span></td>
								</tr>
								<tr>
									<td><a href="assignment.html">Photography and Anthropology</a></td>
									<td>ANTH 132 - 01</td>
									<td><a href="http://campusdirectory.ucsc.edu/detail.php?type=people&uid=sherring">Errington,S.E.</a></td>
									<td><span class="badge">7</span></td>
									<td><span class="badge badge-warning">Pending</span></td>
								</tr>
								<tr>
									<td><a href="assignment.html">Photography and Anthropology</a></td>
									<td>ANTH 132 - 01</td>
									<td><a href="http://campusdirectory.ucsc.edu/detail.php?type=people&uid=sherring">Errington,S.E.</a></td>
									<td><span class="badge">7</span></td>
									<td><span class="badge badge-warning">Pending</span></td>
								</tr>
								<tr>
									<td><a href="assignment.html">Photography and Anthropology</a></td>
									<td>ANTH 132 - 01</td>
									<td><a href="http://campusdirectory.ucsc.edu/detail.php?type=people&uid=sherring">Errington,S.E.</a></td>
									<td><span class="badge">7</span></td>
									<td><span class="badge badge-warning">Pending</span></td>
								</tr>
								<tr>
									<td><a href="assignment.html">Photography and Anthropology</a></td>
									<td>ANTH 132 - 01</td>
									<td><a href="http://campusdirectory.ucsc.edu/detail.php?type=people&uid=sherring">Errington,S.E.</a></td>
									<td><span class="badge">7</span></td>
									<td><span class="badge badge-warning">Pending</span></td>
								</tr>
								<tr>
									<td><a href="assignment.html">Photography and Anthropology</a></td>
									<td>ANTH 132 - 01</td>
									<td><a href="http://campusdirectory.ucsc.edu/detail.php?type=people&uid=sherring">Errington,S.E.</a></td>
									<td><span class="badge">7</span></td>
									<td><span class="badge badge-warning">Pending</span></td>
								</tr>
								<tr>
									<td><a href="assignment.html">Photography and Anthropology</a></td>
									<td>ANTH 132 - 01</td>
									<td><a href="http://campusdirectory.ucsc.edu/detail.php?type=people&uid=sherring">Errington,S.E.</a></td>
									<td><span class="badge">7</span></td>
									<td><span class="badge badge-warning">Pending</span></td>
								</tr>
								<tr>
									<td><a href="assignment.html">Photography and Anthropology</a></td>
									<td>ANTH 132 - 01</td>
									<td><a href="http://campusdirectory.ucsc.edu/detail.php?type=people&uid=sherring">Errington,S.E.</a></td>
									<td><span class="badge">7</span></td>
									<td><span class="badge badge-warning">Pending</span></td>
								</tr>
								<tr>
									<td><a href="assignment.html">Photography and Anthropology</a></td>
									<td>ANTH 132 - 01</td>
									<td><a href="http://campusdirectory.ucsc.edu/detail.php?type=people&uid=sherring">Errington,S.E.</a></td>
									<td><span class="badge">7</span></td>
									<td><span class="badge badge-warning">Pending</span></td>
								</tr>
								<tr>
									<td><a href="assignment.html">Photography and Anthropology</a></td>
									<td>ANTH 132 - 01</td>
									<td><a href="http://campusdirectory.ucsc.edu/detail.php?type=people&uid=sherring">Errington,S.E.</a></td>
									<td><span class="badge">7</span></td>
									<td><span class="badge badge-warning">Pending</span></td>
								</tr>
							</tbody>
						</table>
						
				
		            </div><!--/span-->
		        </div><!--/row-->
			</div><!--/page-unit-->
		  

        </div><!--/span-->
		<div class="span3">
          <div class="well">
            <ul class="nav nav-list">
              <li class="nav-header">Quarters Menu</li>
              <li class="active"><a href="#">Summer I 2012</a></li>
			  <li><a href="#">Spring 2012</a></li>
              <li><a href="#">Winter 2012</a></li>
              <li><a href="#">Fall 2011</a></li>
              <li><a href="#">Spring 2011</a></li>

            </ul>
          </div><!--/.well -->
        </div><!--/span-->
      </div><!--/row-->
    </div><!--/.fluid-container-->

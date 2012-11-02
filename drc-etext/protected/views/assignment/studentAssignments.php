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
		array('label'=>'Description', 'url'=>array('course/description', 'termCode'=>$model->term_code, 'class_num'=>$model->class_num)),
		array('label'=>'Bookstore','url'=>'http://slugstore.ucsc.edu/ePOS'),
		//array('label'=>'Bookstore','url'=>'http://slugstore.ucsc.edu/ePOS?form=shared3/textbooks/json/json_books.html&term=FL12&dept=ANTH&crs=101&sec=01&store=721&dti=&desc=&bSug=YES&cSug=&H=N'),
	);
	
?>

<div class="page-head">
	<div class="row-fluid">
		<h1 class="pull-left"><?php echo $model->title .' (' .$model->idString().')'; ?></h1>
	</div><!--/row-->
</div><!--/head-->

<?php echo $this->renderPartial('_assignments', array('model'=>$model)); // grid showong assignment list ?>




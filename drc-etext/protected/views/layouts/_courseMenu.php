<?php 

	$menuItems=array(
		array('label'=>'Assignments', 'url'=>array('course/assignments', 'term_code'=>$model->term_code, 'class_num'=>$model->class_num, 'username'=>$model->username, )),
		array('label'=>'Description', 'url'=>array('course/description', 'term_code'=>$model->term_code, 'class_num'=>$model->class_num, 'username'=>$model->username, )),
		array('label'=>'Books','url'=>array('course/books', 'term_code'=>$model->term_code, 'class_num'=>$model->class_num, 'username'=>$model->username, ), 'visible'=>Yii::app()->user->checkAccess('admin')),
		array('label'=>'Students', 'url'=>array('course/students', 'term_code'=>$model->term_code, 'class_num'=>$model->class_num, 'username'=>$model->username, ), 'visible'=>Yii::app()->user->checkAccess('admin')),
		array('label'=>'Bookstore','url'=>'http://slugstore.ucsc.edu/ePOS'),
		//array('label'=>'Bookstore','url'=>'http://slugstore.ucsc.edu/ePOS?form=shared3/textbooks/json/json_books.html&term=FL12&dept=ANTH&crs=101&sec=01&store=721&dti=&desc=&bSug=YES&cSug=&H=N'),
	);

	// build up the side bar menu
    $this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>'Course Menu',
		'contentCssClass'=>'nav-header',
	));
	$this->widget('zii.widgets.CMenu', array(
		'items'=>$menuItems,
		'htmlOptions'=>array('class'=>'nav nav-list'),
	));
	$this->endWidget();
			
?>
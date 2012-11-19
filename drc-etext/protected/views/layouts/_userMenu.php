<?php 

	$menuItems=array(
		array('label'=>'Courses', 'url'=>array('user/courses', 'username'=>$model->username)),
		array('label'=>'Profile', 'url'=>'#'),
		);

	// build up the side bar menu
    $this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>'User Menu',
		'contentCssClass'=>'nav-header',
	));
	$this->widget('zii.widgets.CMenu', array(
		'items'=>$menuItems,
		'htmlOptions'=>array('class'=>'nav nav-list'),
	));
	$this->endWidget();
			
?>
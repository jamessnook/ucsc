<?php

	$options = array(
		'contentView' => 'base.layouts.course._list',
		'menuView' => '../layouts/_termMenu',
		'menuRoute' => 'drcUser/courses',
		'titleNavRight' => '<a href="' . $this->createUrl('drcUser/update', array('term_code'=> $model->term_code, 'username'=>$model->username)) . '"><i class="icon-plus"></i> User Profile</a>',
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	 
?>



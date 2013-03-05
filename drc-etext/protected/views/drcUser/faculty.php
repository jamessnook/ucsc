<?php
	$options = array(
		'contentView' => '../drcUser/_list',
		'dataProvider' => $model->faculty(),
		'contentTitle' => 'Faculty',
		'titleNavRight' => '<a href="' . $this->createUrl('drcUser/create') . '"><i class="icon-plus"></i> Add User </a>',
		'menuView' => '../layouts/_termMenu',
		'menuRoute' => 'drcUser/faculty',
		'activeTab' => 'faculty',
	);	

	echo $this->renderPartial('_frame', array('options'=>$options, 'model' => $model,)); 
	
?>
	
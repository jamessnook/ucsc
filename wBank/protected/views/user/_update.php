<?php
	$layoutOptions = array(
		'model' => $model,
		'title' => 'Update User Data',
		'createNew'=>false,
		//'action'=>Yii::app()->createUrl("book/update", array("id" => $model->id)),
		'action'=>$action,
	);	

	echo $this->renderPartial('../user/_edit', $layoutOptions); 
	 
?>


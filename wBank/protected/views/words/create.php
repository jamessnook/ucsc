<?php
$this->breadcrumbs=array(
	'Words'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Words', 'url'=>array('index')),
	array('label'=>'Manage Words', 'url'=>array('admin')),
);
?>

<h1>Create Words</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
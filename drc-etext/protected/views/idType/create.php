<?php
$this->breadcrumbs=array(
	'Id Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List IdType', 'url'=>array('index')),
	array('label'=>'Manage IdType', 'url'=>array('admin')),
);
?>

<h1>Create IdType</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
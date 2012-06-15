<?php
$this->breadcrumbs=array(
	'Text Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TextType', 'url'=>array('index')),
	array('label'=>'Manage TextType', 'url'=>array('admin')),
);
?>

<h1>Create TextType</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
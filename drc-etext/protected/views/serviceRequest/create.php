<?php
$this->breadcrumbs=array(
	'Service Requests'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ServiceRequest', 'url'=>array('index')),
	array('label'=>'Manage ServiceRequest', 'url'=>array('admin')),
);
?>

<h1>Create ServiceRequest</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
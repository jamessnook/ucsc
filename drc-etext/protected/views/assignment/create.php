<?php
$this->breadcrumbs=array(
	'Assignments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Assignment', 'url'=>array('index')),
	array('label'=>'Manage Assignment', 'url'=>array('admin')),
);
?>

<h1>Create Assignment</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
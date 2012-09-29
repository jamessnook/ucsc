<?php
$this->breadcrumbs=array(
	'Drc Requests'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DrcRequest', 'url'=>array('index')),
	array('label'=>'Manage DrcRequest', 'url'=>array('admin')),
);
?>

<h1>Create DrcRequest</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
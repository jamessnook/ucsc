<?php
$this->breadcrumbs=array(
	'Drc Requests'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DrcRequest', 'url'=>array('index')),
	array('label'=>'Create DrcRequest', 'url'=>array('create')),
	array('label'=>'View DrcRequest', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage DrcRequest', 'url'=>array('admin')),
);
?>

<h1>Update DrcRequest <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
$this->breadcrumbs=array(
	'Book Requests'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BookRequest', 'url'=>array('index')),
	array('label'=>'Create BookRequest', 'url'=>array('create')),
	array('label'=>'View BookRequest', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BookRequest', 'url'=>array('admin')),
);
?>

<h1>Update BookRequest <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
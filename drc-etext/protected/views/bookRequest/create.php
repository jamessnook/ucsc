<?php
$this->breadcrumbs=array(
	'Book Requests'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BookRequest', 'url'=>array('index')),
	array('label'=>'Manage BookRequest', 'url'=>array('admin')),
);
?>

<h1>Create BookRequest</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
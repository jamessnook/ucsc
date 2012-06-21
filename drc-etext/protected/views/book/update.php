<?php
$this->breadcrumbs=array(
	'Books'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Book', 'url'=>array('index')),
	array('label'=>'Create Book', 'url'=>array('create')),
	array('label'=>'View Book', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Book', 'url'=>array('admin')),
	array('label'=>'Upload Files','url'=>array('file/upload', 'book_id'=>$model->id)),
	array('label'=>'Download Files','url'=>array('file/download', 'book_id'=>$model->id)),
);
?>

<h1>Update Book <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
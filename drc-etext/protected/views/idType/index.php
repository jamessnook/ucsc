<?php
$this->breadcrumbs=array(
	'Id Types',
);

$this->menu=array(
	array('label'=>'Create IdType', 'url'=>array('create')),
	array('label'=>'Manage IdType', 'url'=>array('admin')),
);
?>

<h1>Id Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

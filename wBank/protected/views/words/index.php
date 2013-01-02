<?php
$this->breadcrumbs=array(
	'Words',
);

$this->menu=array(
	array('label'=>'Create Words', 'url'=>array('create')),
	array('label'=>'Manage Words', 'url'=>array('admin')),
);
?>

<h1>Words</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

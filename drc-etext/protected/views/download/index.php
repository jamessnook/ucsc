<?php
$this->breadcrumbs=array(
	'Downloads',
);

$this->menu=array(
	array('label'=>'Create Download', 'url'=>array('create')),
	array('label'=>'Manage Download', 'url'=>array('admin')),
);
?>

<h1>Downloads</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

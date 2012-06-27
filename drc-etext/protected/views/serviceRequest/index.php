<?php
$this->breadcrumbs=array(
	'Service Requests',
);

$this->menu=array(
	array('label'=>'Create ServiceRequest', 'url'=>array('create')),
	array('label'=>'Manage ServiceRequest', 'url'=>array('admin')),
);
?>

<h1>Service Requests</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

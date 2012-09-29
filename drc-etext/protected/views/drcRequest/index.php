<?php
$this->breadcrumbs=array(
	'Drc Requests',
);

$this->menu=array(
	array('label'=>'Create DrcRequest', 'url'=>array('create')),
	array('label'=>'Manage DrcRequest', 'url'=>array('admin')),
);
?>

<h1>Drc Requests</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

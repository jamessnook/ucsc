<?php
$this->breadcrumbs=array(
	'Text Types',
);

$this->menu=array(
	array('label'=>'Create TextType', 'url'=>array('create')),
	array('label'=>'Manage TextType', 'url'=>array('admin')),
);
?>

<h1>Text Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

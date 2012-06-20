<?php
$this->breadcrumbs=array(
	'Book Requests',
);

$this->menu=array(
	array('label'=>'Create BookRequest', 'url'=>array('create')),
	array('label'=>'Manage BookRequest', 'url'=>array('admin')),
);
?>

<h1>Book Requests</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

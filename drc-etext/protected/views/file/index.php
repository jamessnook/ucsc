<?php
$this->breadcrumbs=array(
	'Files',
);

$this->menu=array(
	array('label'=>'Create File', 'url'=>array('create')),
	array('label'=>'Manage File', 'url'=>array('admin')),
	array('label'=>'Upload Files','url'=>array('upload')),
	array('label'=>'Download Files','url'=>array('download')),
);
?>

<h1>Files</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

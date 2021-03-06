<?php
/**
 * The base view component file for displaying a list of students using a book.
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.book
 */
?>

							
<h3>Students using <?php echo $model->title ?></h3>

<?php 

//$model->username = Yii::app()->user->name;  // set up for current user

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'assignmentFilesGrid2',
	'dataProvider'=>$model->students(),
	//'filter'=>$model,
	//'hideHeader'=>true,
	'summaryText'=>'',
	'enablePagination'=>false,
	'loadingCssClass'=>'',
	'showTableOnEmpty'=>false,
	//'itemsCssClass'=>"table table-striped table-bordered data-table", 
	'itemsCssClass'=>"table table-striped table-bordered", 
	'pager'=>array('class'=>'CLinkPager', 'header'=>''), 
	'pagerCssClass'=>"pagination", 
	'columns'=>array(
		array( 
			'header'=>'Cruz Id', 
			'class'=>'LinksColumn',
			'labelExpression'=>'$data[\'username\']',
			'urlExpression'=>'array(\'drcUser/update\', \'username\'=>$data[\'username\'])', 
		),
		array( 
			'header'=>'Name', 
			'name'=>'name', 
			'value'=> '$data[\'last_name\'] . \', \' . $data[\'first_name\']',
		), 
		/*array( 
			'header'=>'Status, click to change', 
			'class'=>'LinksColumn',
		 	//'type'=>'raw',
		 	//'urlExpression'=>'array(\'book/togglePurchased\', \'username\'=>$data->username, \'id\'=>$data->id, \'purchased\'=>$data->purchased)',  
		 	'urlExpression'=>'array(\'book/togglePurchased\', \'username\'=>$data[\'username\'], \'book_id\'=>' .$model->id. ')',  
		 	'labelExpression'=>'$data[\'purchased\']? \'<span class="badge badge-success">Purchased</span>\' : \'<span class="badge badge-warning">Not Purchased</span>\'', 
		),*/
		array( 
			'header'=>'Status', 
		 	'name'=>'purchased', 
			'type'=>'raw',
		 	'value'=>'$data[\'purchased\']? \'<span class="badge badge-success">Purchased</span>\' : \'<span class="badge badge-warning">Not Purchased</span>\'', 
		 ),
		 array( 
			'header'=>'', 
			'class'=>'LinksColumn',
		 	'linkHtmlOptions'=>array('class'=>"btn"),
		 	'labelExpression'=>'$data[\'purchased\']? \'Set Not Purchased\' : \'Set Purchased\'', 
		 	'urlExpression'=>'array(\'book/togglePurchased\', \'username\'=>$data[\'username\'], \'book_id\'=>' .$model->id. ')',   
		 ),
	),
));

?>

							

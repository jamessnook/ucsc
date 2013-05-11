<?php
/**
 * The base view component file for displaying a list of books.
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.book
 */
?>


<div class="row-fluid">
    <div class="span12">
		<h3>Books used by <?php echo $model->first_name .' ' . $model->last_name; ?></h3>

	<?php 
	
	//$model->username = Yii::app()->user->name;  // set up for current user
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'userBookGrid',
		'dataProvider'=>$model->books(),
		//'filter'=>$model,
		//'hideHeader'=>true,
		'summaryText'=>'',
		'enablePagination'=>false,
		'showTableOnEmpty'=>false,
		'loadingCssClass'=>'',
		'itemsCssClass'=>"table table-striped table-bordered data-table", 
		'pager'=>array('class'=>'CLinkPager', 'header'=>''), 
		'pagerCssClass'=>"pagination", 
		'columns'=>array(
			array( 
				'header'=>'Book Title', 
				'name'=>'bookTitle', 
				'value'=>'$data[\'title\']', 
			),
			array( 
				'header'=>'Author', 
				'name'=>'author', 
				'value'=>'$data[\'author\']', 
			 ),
			array( 
				'header'=>'Course', 
				'name'=>'course', 
				'value'=>'$data[\'courseTitle\']', 
			 ),
			 array( 
				'header'=>'Term', 
				'name'=>'term', 
				'value'=>'$data[\'term\']', 
			 ),
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
			 	'urlExpression'=>'array(\'book/togglePurchased\', \'username\'=>$data[\'username\'], \'book_id\'=>$data[\'id\'],)',  
			 ),
		),
	)); 
	?>

    </div><!--/span-->
</div><!--/row-->

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
		<h3>Books</h3>

	<?php 
	
	//$model->username = Yii::app()->user->name;  // set up for current user
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'bookGrid',
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
				'class'=>'LinksColumn',
				'labelExpression'=>'$data->title', 
				'urlExpression'=>'array(\'course/updateBook\', \'id\'=>$data->id, \'term_code\'=>\'' . $model->term_code . '\', \'class_num\'=>\'' . $model->class_num . '\')', 
			),
			array( 
				'header'=>'Author', 
				'name'=>'author', 
				'value'=>'$data->author', 
			 ),
			array( 
				'header'=>'Publisher', 
				'name'=>'publisher', 
				'value'=>'$data->publisher', 
			 ),
			 array( 
				'header'=>'Year', 
				'name'=>'year', 
				'value'=>'$data->year', 
			 ),
			 array( 
				'header'=>'Edition', 
				'name'=>'edition', 
				'value'=>'$data->edition', 
			 ),
			 array( 
				'header'=>'Global Id', 
				'name'=>'edition', 
				'value'=>'$data->global_id', 
			 ),
			 array( 
				'header'=>'Id Type', 
				'name'=>'edition', 
				'value'=>'$data->id_type', 
			 ),
			 array( 
				'header'=>'', 
				'class'=>'LinksColumn',
			 	'linkHtmlOptions'=>array('class'=>"btn"),
				'labelExpression'=>'\'Edit\'', 
				'urlExpression'=>'array(\'course/updateBook\', \'id\'=>$data->id, \'term_code\'=>\'' . $model->term_code . '\', \'class_num\'=>\'' . $model->class_num . '\')', 
			 ),
			 /*array( 
				'header'=>'', 
				'class'=>'LinksColumn',
			 	'linkHtmlOptions'=>array('class'=>"btn"),
				'labelExpression'=>'\'Manage\'', 
				'urlExpression'=>'array(\'course/manageBook\', \'id\'=>$data->id, \'term_code\'=>\'' . $model->term_code . '\', \'class_num\'=>\'' . $model->class_num . '\')', 
			 ),
			 array( 
				'header'=>'', 
				'name'=>'delete', 
				'type'=>'raw',
				'value'=>'\'<a href="#" class="btn">Remove</a>\'', 
			 ),*/
		),
	)); 
	?>

    </div><!--/span-->
</div><!--/row-->

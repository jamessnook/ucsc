<?php
/**
 * The base view component file for displaying a list of users.
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.user
 */
?>


<div class="row-fluid">
    <div class="span12">
		<h3><?php echo $contentTitle; 	?> </h3>

	<?php 
	
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'drc-request-grid',
		'dataProvider'=>$dataProvider,
		'summaryText'=>'',
		'showTableOnEmpty'=>false,
		'enablePagination'=>false,
		'itemsCssClass'=>"table table-striped table-bordered data-table", 
		'loadingCssClass'=>'',
		'pager'=>array('class'=>'CLinkPager', 'header'=>''), 
		'pagerCssClass'=>"pagination", 
		'columns'=>array(
			array( 
				'header'=>'Username', 
				'class'=>'LinksColumn',
				'labelExpression'=>'$data->username',
				'urlExpression'=>'array(\'user/update\', \'username\'=>$data->username)', 
			),
			 array( 
				'header'=>'Name', 
				'name'=>'Name', 
				'value'=>'$data->last_name . \', \' . $data->first_name', 
			 ),
			array( 
				'header'=>'Role', 
				'name'=>'role', 
				'value'=>'$data->getRolesStr()', 
			 ),
		),
	)); 
	?>

    </div><!--/span-->
</div><!--/row-->

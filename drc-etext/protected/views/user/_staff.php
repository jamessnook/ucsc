<?php
/**
 * The base view component file for displaying a list of users who are staff.
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.user
 */
?>


<div class="row-fluid">
    <div class="span12">
		<h3>Staff and Admin</h3>

	<?php 
	
	//$model->username = Yii::app()->user->name;  // set up for current user
	//$params = array();
	//$paramStr = '';
	//if ($model->term_code) {
		//$params['term_code'] = $model->term_code;
	//	$paramStr .=  '\'term_code\' =>' . $model->term_code; 
	//}
	//if ($model->class_num) $params['class_num'] = $model->class_num;
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'drc-request-grid',
		'dataProvider'=>$model->staff(),
		//'filter'=>$model,
		//'hideHeader'=>true,
		'summaryText'=>'',
		//'emptyText'=>'Sorry, no data',
		'showTableOnEmpty'=>false,
		'enablePagination'=>false,
		'itemsCssClass'=>"table table-striped table-bordered data-table", 
		'loadingCssClass'=>'',
		'pager'=>array('class'=>'CLinkPager', 'header'=>''), 
		'pagerCssClass'=>"pagination", 
		'columns'=>array(
			array( 
				'header'=>'Cruz Id', 
				'class'=>'LinksColumn',
				'labelExpression'=>'$data->username',
				'urlExpression'=>'array(\'user/update\', \'username\'=>$data->username)', 
			),
			 array( 
				'header'=>'Name', 
				'class'=>'LinksColumn',
				'labelExpression'=>'$data->last_name . \', \' . $data->first_name', 
				//'urlExpression'=>'array(\'user/courses\', \'username\'=>$data->username,' . $paramStr  .')', 
				'urlExpression'=>'array(\'user/courses\', \'username\'=>$data->username, \'term_code\'=>\''. $model->term_code . '\')',  
			 ),
			 array( 
				'header'=>'Roles', 
				'class'=>'LinksColumn',
				//'labelExpression'=>'\'test\'', 
				//'urlExpression'=>'\'test\'', 
			 	'labelExpression'=>'$data->getRoles()', 
				'urlExpression'=>'$data->getUrl()',
			),
			 //array( 
			//	'header'=>'Authorization Level', 
			//	'name'=>'drcRequests.type', 
			//	'type'=>'raw',
			//	'value'=>'\'<span class="badge">\' . $data->drcRequests[0]->type . \'</span>\'', 
			//  Yii::app()->authManager->getRoles($username);
			// ),
		),
	)); 
	?>

    </div><!--/span-->
</div><!--/row-->

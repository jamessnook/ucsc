
<div class="row-fluid">
    <div class="span12">
		<h3>E-Mails</h3>

	<?php 
	
	//$model->username = Yii::app()->user->name;  // set up for current user
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'assignmentGrid',
		'dataProvider'=>$model->emails(),
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
				'header'=>'Subject', 
				'name'=>'subject', 
				'value'=>'$data->subject', 
			 ),
			array( 
				'header'=>'Message', 
				'name'=>'message', 
				'value'=>'$data->message', 
			 ),
			 array( 
				'header'=>'Type', 
				'name'=>'type', 
				'value'=>'$data->type->name', 
			 ),
			 array( 
				'header'=>'Order', 
				'name'=>'order', 
				'value'=>'$data->type->sequence', 
			 ),
			 array( 
				'header'=>'Tone', 
				'name'=>'tone', 
				'value'=>'$data->type->tone', 
			 ),
			array( 
				'header'=>'Status, click to send', 
				'class'=>'LinksColumn',
			 	'urlExpression'=>'array(\'course/sendEmail\', \'email_id\'=>$data[\'id\'], \'term_code\'=>' . $model->term_code . ', \'class_num\'=>' . $model->class_num . ')',  
			 	'labelExpression'=>'$data[\'sent\']? \'<span class="badge badge-success">Sent</span>\' : \'<span class="badge badge-warning">Not Sent</span>\'', 
			),
			 array( 
				'header'=>'', 
				'class'=>'LinksColumn',
			 	'linkHtmlOptions'=>array('class'=>"btn"),
				'labelExpression'=>'\'Edit\'', 
				'urlExpression'=>'array(\'course/updateEmail\', \'id\'=>$data->id, \'term_code\'=>\'' . $model->term_code . '\', \'class_num\'=>\'' . $model->class_num . '\')', 
			 ),
			 array( 
				'header'=>'', 
				'class'=>'LinksColumn',
			 	'linkHtmlOptions'=>array('class'=>"btn"),
				'labelExpression'=>'\'Remove\'', 
				'urlExpression'=>'array(\'course/removeEmail\', \'id\'=>$data->id, \'term_code\'=>\'' . $model->term_code . '\', \'class_num\'=>\'' . $model->class_num . '\')', 
			 ),
		),
	)); 
	?>

    </div><!--/span-->
</div><!--/row-->

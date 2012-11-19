
<div class="row-fluid">
    <div class="span12">
		<h3>Books</h3>

	<?php 
	
	//$model->username = Yii::app()->user->name;  // set up for current user
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'assignmentGrid',
		'dataProvider'=>$model->books(),
		//'filter'=>$model,
		//'hideHeader'=>true,
		'summaryText'=>'',
		'enablePagination'=>false,
		'loadingCssClass'=>'',
		'itemsCssClass'=>"table table-striped table-bordered data-table", 
		'pager'=>array('class'=>'CLinkPager', 'header'=>''), 
		'pagerCssClass'=>"pagination", 
		'columns'=>array(
			array( 
				'header'=>'Book Title', 
				'class'=>'CLinksColumn',
				'labelExpression'=>'$data->title', 
				'urlExpression'=>'array(\'course/updateBook\', \'id\'=>$data->id, \'termCode\'=>\'' . $model->term_code . '\', \'classNum\'=>\'' . $model->class_num . '\')', 
				//'urlExpression'=>"array('course/updateBook', 'id'=>\$data->id, 'termCode'=>$model->term_code, 'classNum'=>$model->class_num)", 
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
				'header'=>'', 
				'name'=>'edit', 
				'type'=>'raw',
				'value'=>'\'<a href="#" class="btn">Edit</a>\'', 
			 ),
			 array( 
				'header'=>'', 
				'name'=>'delete', 
				'type'=>'raw',
				'value'=>'\'<a href="#" class="btn">Remove</a>\'', 
			 ),
		),
	)); 
	?>

    </div><!--/span-->
</div><!--/row-->
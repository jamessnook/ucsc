<?php
/**
 * The base view component file for displaying a list of words.
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.course
 */
?>


<div class="row-fluid">
    <div class="span12">
		<h3>Words: </h3>

	<?php 
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'coursesGrid',
		'dataProvider'=>$model->search(),
		//'filter'=>$model,
		//'hideHeader'=>true,
		'summaryText'=>'',
		'enablePagination'=>false,
		'showTableOnEmpty'=>false,
		'itemsCssClass'=>"table table-striped table-bordered data-table", 
		'loadingCssClass'=>'',
		'pager'=>array('class'=>'CLinkPager', 'header'=>''), 
		'pagerCssClass'=>"pagination", 
		'columns'=>array(
			array( 
				'header'=>'Word Id', 
				'name'=>'idString', 
				'value'=>'$data->id', 
			 ),
			array( 
				'header'=>'Word', 
				'name'=>'word', 
				'value'=>'$data->word', 
			 ),
			 array( 
				'header'=>'POS', 
				'name'=>'pos', 
				'value'=>'$data->pos', 
			 ),
			 array( 
				'header'=>'Sense Num', 
				'name'=>'senseNum', 
				'value'=>'$data->senseNum', 
			 ),
			 array( 
				'header'=>'Concrete', 
				'name'=>'concrete', 
				'value'=>'$data->concrete', 
			),
			 array( 
				'header'=>'Lemma', 
				'name'=>'head', 
				'value'=>'$data->head', 
			),
			array( 
				'header'=>'Polysemy', 
				'name'=>'polysemyCnt', 
				'value'=>'$data->polysemyCnt', 
			),
			array( 
				'header'=>'Frequency', 
				'name'=>'zenoFreq', 
				'value'=>'$data->zenoFreq', 
			),
			array( 
				'header'=>'Definition', 
				'name'=>'definition', 
				'value'=>'$data->definition', 
			),
		),
	)); 
	
	?>

    </div><!--/span-->
</div><!--/row-->

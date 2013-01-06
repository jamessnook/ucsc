<?php
/**
 * The base view component file for displaying a list of words.
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.words
 */
?>


<div class="row-fluid">
    <div class="span12">
		<h3>Word List: </h3>

	<?php 
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'wordListGrid',
		'dataProvider'=>$model->search(),
		//'filter'=>$model,
		//'hideHeader'=>true,
		'summaryText'=>'',
		'enablePagination'=>false,
		'enableSorting'=>false,
		'showTableOnEmpty'=>false,
		'itemsCssClass'=>"table table-striped table-bordered data-table", 
		'rowCssClassExpression'=>'"dtr$row"',
		'loadingCssClass'=>'',
		'pager'=>array('class'=>'CLinkPager', 'header'=>''), 
		'pagerCssClass'=>"pagination", 
		'columns'=>array(
			array( 
				'header'=>'Word Id', 
				'name'=>'idString', 
				//'value'=>'$data->id . CHtml::hiddenField("Words[wid][$row]", $data->id)', 
				'value'=>'$data->id', 
				'type'=> 'raw',
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
			 array( 
				'header'=>'', 
				'class'=>'LinksColumn',
			 	'linkHtmlOptions'=>array('class'=>"btn"),
				'labelExpression'=>'\'Remove\'', 
				//'urlExpression'=>'array(\'course/manageBook\', \'id\'=>$data->id, \'term_code\'=>\'' . $model->term_code . '\', \'class_num\'=>\'' . $model->class_num . '\')', 
				'urlExpression'=>'"javascript:$(\'.dtr$row\').remove()"', 
				//'name'=>'delete', 
				//'type'=>'raw',
				//'value'=>"'Remove'", 
			 	//'htmlOptions'=>array('class'=>"btn", 'onclick'=>'$(".dtr$row").delete()'),
			 ),
		),
	)); 
	?>
    <div class="list-actions">
	    <div>
	
		<?php 
		// add hidden elemts with word ids for further requests:
		foreach ($model->search()->getData() as $i=>$row){
			echo CHtml::hiddenField("Words[wid][$i]", $row['id'], array('class'=>"dtr$i"));
		} 
		
		echo $form->labelEx($model,'listName'); 
		echo $form->textField($model,'listName',array('class'=>"input-large",'maxlength'=>63)); // also? id="input01", type="text" 
		echo $form->error($model,'listName'); 
		echo CHtml::submitButton('Save New List', array( 'class'=>"btn btn-success", 'name' => 'Words[saveNewList]', )); 
		
		echo CHtml::submitButton('View Inflections', array( 'class'=>"btn btn-success pull-right", 'name' => 'Words[viewInflections]', )); 
		?>
	    </div>
	    <div >
	
		<?php 
		echo $form->labelEx($model, 'listId', array('class'=>"control-label")); 
		$options = CHtml::listData(Lists::model()->findAll(), 'id', 'name');
		echo $form->dropDownList($model,'listId', $options, array('class'=>"input-large"));
		echo $form->error($model,'listId'); 
		echo CHtml::submitButton('Save List', array( 'class'=>"btn btn-success", 'name' => 'Words[saveOldList]', )); 
		echo CHtml::submitButton('Load List', array( 'class'=>"btn btn-success", 'name' => 'Words[loadList]', )); 
		
		echo CHtml::submitButton('Download tsv List', array( 'class'=>"btn btn-success pull-right", 'name' => 'Words[downloadTsv]', )); 
	 	
		?>
	    </div>
    </div>

    </div><!--/span-->
</div><!--/row-->

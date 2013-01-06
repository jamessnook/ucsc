<?php
/**
 * The base view component file for displaying a list of inflected forms of words.
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.words
 */
?>


<div class="row-fluid">
    <div class="span12">
		<h3>Inflected Words: </h3>

	<?php 
	// 	select = 'words.word, inflectedWord.word AS iWord, head, flectType, transInfl, inflection, lemmaId, zenoFreq';
	
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'wordListGrid',
		'dataProvider'=>$model->inflections(),
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
			/*array( 
				'header'=>'Word', 
				'name'=>'word', 
				'value'=>'$data[\'word\']', 
				//'value'=>'$data[\'word\'] . CHtml::hiddenField("Words[iid][$row]", $data->celexWordId)', 
			'type'=> 'raw',
			),*/
			array( 
				'header'=>'Lemma', 
				'name'=>'head', 
				//'value'=>'$data->words[0]->head', 
				'value'=>'$data[\'head\']', 
			),
			array( 
				'header'=>'Inflected Word', 
				'name'=>'word', 
				//'value'=>'$data->word', 
				'value'=>'$data[\'word\']', 
			),
			/* array( 
				'header'=>'Type', 
				'name'=>'type', 
				//'value'=>'$data->flectType', 
				'value'=>'$data[\'flectType\']', 
			 ),*/
			 array( 
				'header'=>'Structure', 
				'name'=>'transInfl', 
				//'value'=>'$data->transInfl', 
				'value'=>'$data[\'transInfl\']', 
			 ),
			 array( 
				'header'=>'inflection', 
				'name'=>'inflection', 
				//'value'=>'$data->inflection', 
				'value'=>'$data[\'inflection\']', 
			 ),
			 array( 
				'header'=>'Frequency', 
				'name'=>'zenoFreq', 
				//'value'=>'$data->zenoFreq', 
				'value'=>'$data[\'zenoFreq\']', 
			 ),
			/* array( 
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
			 ),*/
		),
	)); 
	?>
    <div class="list-actions">
	    <div>
	
		<?php 
		// add hidden elemts with word ids for further requests:
		foreach ($model->wid as $row=>$id){
			echo CHtml::hiddenField("Words[wid][$row]", $id);
		} 
		
		echo $form->labelEx($model, 'listId', array('class'=>"control-label")); 
		$options = CHtml::listData(Lists::model()->findAll(), 'id', 'name');
		echo $form->dropDownList($model,'listId', $options, array('class'=>"input-large"));
		echo $form->error($model,'listId'); 
		echo CHtml::submitButton('Load List', array( 'class'=>"btn btn-success", 'name' => 'Words[loadList]', )); 
		
		echo CHtml::submitButton('Download inflections as tsv', array( 'class'=>"btn btn-success pull-right", 'name' => 'Words[downloadInflections]', )); 
	 	
		?>
	    </div>
    </div>

    </div><!--/span-->
</div><!--/row-->

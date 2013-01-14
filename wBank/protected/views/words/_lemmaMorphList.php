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
		'dataProvider'=>$model->lemmaMorph(),
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
				'header'=>'Subcat', 
				'name'=>'subcat', 
				//'value'=>'$data->inflection', 
				'value'=>'$data[\'immSubCat\']', 
			 ),
			 array( 
				'header'=>'Structure', 
				'name'=>'structure', 
				//'value'=>'$data->inflection', 
				'value'=>'$data[\'transDer\']', 
			 ),
			 array( 
				'header'=>'Derivation', 
				'name'=>'derivation', 
				//'value'=>'$data->inflection', 
				'value'=>'$data[\'strucLab\']', 
			 ),
		),
	)); 
	?>
    <div class="list-actions">
	    <div>
	
		<?php 
		// add hidden elemts with word ids for further requests:
		foreach ($model->chk as $id=>$checked){
			echo CHtml::hiddenField("chk[$id]", 0);
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

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
			/*array( 
				'header'=>'Word Id', 
				'name'=>'idString', 
				//'value'=>'$data->id . CHtml::hiddenField("Words[wid][$row]", $data->id)', 
				'value'=>'$data->id', 
				'type'=> 'raw',
			),*/
			array( 
				//'header'=>'<a href="#" class="btn">Remove Unchecked</a>',  
				'name'=>'check', 
				//'headerHtmlOptions'=>array('onclick'=>'if ($("#wordListGrid_c0_all").attr("checked")) $(".chk").val($(".chk5").attr("checked") ? 1 : 0 )', ),
				'headerHtmlOptions'=>array('onclick'=>'$(".cbs").each(function ( i, el) {var vl=$(el).val();  $(".chk"+vl).val($(el).attr("checked") ? 1 : 0 );});', ),
				'checkBoxHtmlOptions'=>array('class'=>"cbs", 'onclick'=>'$(".chk"+$(this).val()).val($(this).attr("checked") ? 1 : 0 )', ),
				'cssClassExpression'=>'"cbc cbc$row"',
				'value'=>'$row',
				//'value'=>'"dtr$row"',
				//'value'=>'$data->id . CHtml::hiddenField("Words[wid][$row]", $data->id)', 
				//'value'=>'$data->id', 
				//'value'=>'CHtml::checkBox("stopPublish",$data->stopPublish,array("id"=>"chkPublish_".$data->id))'),
				'class'=>'CCheckBoxColumn',
				'selectableRows'=>2,
				//'type'=> 'raw',
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
				//'urlExpression'=>'"javascript:var dt = $(\'#DataTables_Table_0\').dataTable(); var row = $(this).closest(\'tr\').get(0); dt.fnDeleteRow(dt.fnGetPosition( row, 0, 1 ));"', 
				//'urlExpression'=>'"javascript:var dt = $(\'#DataTables_Table_0\').dataTable(); var row = $(\'.dtr$row\'); dt.fnDeleteRow(dt.fnGetPosition( row ));"', 
			 //'urlExpression'=>'"javascript:var dt = $(\'#DataTables_Table_0\').dataTable(); var aPos = dt.fnGetPosition($(\'tr.dtr$row\').get()); dt.fnDeleteRow(apos);"', 
			 'urlExpression'=>'"javascript:var dt = $(\'#DataTables_Table_0\').dataTable(); dt.fnDeleteRow($(\'.dtr$row\').get());"', 
			 //'urlExpression'=>'"javascript:$(\'.dtr$row\').remove(); void(0);"', 
			 //'name'=>'delete', 
				//'type'=>'raw',
				//'value'=>"'Remove'", 
			 	//'htmlOptions'=>array('class'=>"btn", 'onclick'=>'$(".dtr$row").delete()'),
			 ),
			 /*array( 
				'header'=>'', 
				'name'=>'remove', 
				'htmlOptions'=>array('class'=>"btn", 'onclick'=>'"$(\'.dtr$row\').remove(); $(\'#DataTables_Table_0\').dataTable().fnDeleteRow($(\'.dtr$row\')));"'),
				'value'=>'"dtr$row"',
			 	//'class'=>'LinksColumn',
			 	//'linkHtmlOptions'=>array('class'=>"btn"),
				//'labelExpression'=>'\'Remove\'', 
				//'urlExpression'=>'array(\'course/manageBook\', \'id\'=>$data->id, \'term_code\'=>\'' . $model->term_code . '\', \'class_num\'=>\'' . $model->class_num . '\')', 
				//'urlExpression'=>'"javascript:$(\'.dtr$row\').remove(); $(\'#DataTables_Table_0\').dataTable().fnDeleteRow($(\'.dtr$row\')));"', 
				//'name'=>'delete', 
				//'type'=>'raw',
				'value'=>"'Remove'", 
			 	//'htmlOptions'=>array('class'=>"btn", 'onclick'=>'$(".dtr$row").delete()'),
			 ),*/
		),
	)); 
	/*
	echo CHtml::button('Remove Checked', array( 'class'=>"btn", 
		'onclick' => '$(".cbs input:checked").each(function ( index, domEle) { $("#DataTables_Table_0").dataTable().fnDeleteRow($("."+$(this).val())); $("."+$(this).val()).remove();});', )); 
	echo CHtml::button('Remove Unchecked', array( 'class'=>"btn", 
		'onclick' => '$(".cbs input:not(:checked)").each(function ( index, domEle) {oTable.$("."+$(this).val()).remove();});', )); 
	*/
	echo CHtml::submitButton('Remove Checked', array( 'class'=>"btn btn-success", 'name' => 'removeChecked', )); 
	echo CHtml::submitButton('Remove Unchecked', array( 'class'=>"btn btn-success", 'name' => 'removeUnchecked', )); 
	?>
	 <script type="text/javascript">
	 	// link click action to top checkbox
		//$("#wordListGrid_c0").click(function(event) {
		//	$(".cbs").each(function ( i, el) {
		//		var vl=$(el).val();  
		//		$(".chk"+vl).val($(el).attr("checked") ? 1 : 0 );
		//	});		
		//});
   	</script>
    <div class="list-actions">
	    <div>
	
		<?php 
		// add hidden elemts with word ids for further requests:
		foreach ($model->search()->getData() as $i=>$row){
			//echo CHtml::hiddenField("Words[wid][$i]", $row['id'], array('class'=>"dtr$i"));
			echo CHtml::hiddenField("chk[{$row['id']}]", 0, array('class'=>"chk chk$i"));
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
	 	
		// possible js to add from http://www.datatables.net/forums/discussion/185/submitting-forms-with-fields-on-hidden-pages/p1
		// $('form').submit(function(){
        //$(oTable.fnGetHiddenNodes()).find('input:checked').appendTo(this);
   		//});
 
		?>
	    </div>
    </div>

    </div><!--/span-->
</div><!--/row-->

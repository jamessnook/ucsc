<?php
/**
 * The base view component file for displaying a list of courses.
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.course
 */

if (!isset($contentTitle) || $contentTitle == ''){
	$contentTitle = "Courses";
	if (isset($model->term_code) && $model->term_code > 0){
		$contentTitle .= ": " . Term::model()->findByPk($model->term_code)->description; 
	}
}

?>


<div class="row-fluid">
    <div class="span12">
		<h3><?php echo $contentTitle; ?> </h3>

	<?php 
	$courseUrlExpression = '';
	$typeValue =  '';
	$typeHtmlOptions = array();
	$typeLabel = 'File Type';
	if ((Yii::app()->user->checkAccess('staff') || Yii::app()->user->checkAccess('admin'))&& isset($model->username)){
		$courseUrlExpression = 'array(\'course/assignments\', \'term_code\'=>$data->term_code, \'class_num\'=>$data->class_num,)';
		$typeHtmlOptions = array('class'=>"input-col",);
		$typeLabel = 'File Type: Select to change';
		$typeValue = '"<form id=\"ftForm" . $data->term_code . "-" . $data->class_num . "\" action=\"" . Yii::app()->createUrl("/drcUser/SetFileType" ) . "\" method= \"post\">" . 
					$this->grid->controller->widget(\'base.extensions.select2.ESelect2\',array(
						"name"=>"type" . $data->term_code . "-" . $data->class_num,
						"value"=>$data->typeForUser(),
				  		"data"=>FileType::optionsWithNameAsValue(),
						"htmlOptions"=>array("class"=>"input-large fileTypeList input-item", ),
						"events"=>array("change"=>"js:function(){ $(\"#ftForm" . $data->term_code . "-" . $data->class_num . "\").submit(); }",),
					), true) . 
					CHtml::hiddenField("username", "'. $model->username .  '") .
					CHtml::hiddenField("term_code", $data->term_code ) .
					CHtml::hiddenField("class_num", $data->class_num ) .
					"</form>"'; 
		
	} else if (Yii::app()->user->checkAccess('faculty') || Yii::app()->user->checkAccess('staff') || Yii::app()->user->checkAccess('admin') ){
		$courseUrlExpression = 'array(\'course/files\', \'term_code\'=>$data->term_code, \'class_num\'=>$data->class_num,)';
		if (!Yii::app()->user->checkAccess('faculty')){
			$courseUrlExpression = 'array(\'course/assignments\', \'term_code\'=>$data->term_code, \'class_num\'=>$data->class_num,)';
		}
		$typeValue =  'eval(\'
					$tString = ""; 
					foreach($data->types() as $type){
						$tString .= "<span class=\"badge\">" . $type . "</span> ";
					}
					return $tString;
				\')';
	} else {
		$courseUrlExpression = 'array(\'course/assignments\', \'term_code\'=>$data->term_code, \'class_num\'=>$data->class_num, \'username\'=>$data->username,)';
		if (isset($model->username)){
			$courseUrlExpression = 'array(\'course/assignments\', \'term_code\'=>$data->term_code, \'class_num\'=>$data->class_num, \'username\'=>\'' . $model->username. '\',)';
		}
		$typeValue =  '"<span class=\"badge\">" . $data->typeForUser() . "</span> "';
	}
	
	
	
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'coursesGrid',
		'dataProvider'=>$model->courses(),
		//'filter'=>$model,
		//'hideHeader'=>true,
		'summaryText'=>'',
		'enablePagination'=>false,
		'showTableOnEmpty'=>false,
		'emptyText'=>'No courses found for the selected quarter.',
		'itemsCssClass'=>"table table-striped table-bordered data-table", 
		'loadingCssClass'=>'',
		'pager'=>array('class'=>'CLinkPager', 'header'=>''), 
		'pagerCssClass'=>"pagination", 
		'columns'=>array(
			array( 
				'header'=>'Course Name', 
				'class'=>'LinksColumn',
				'labelExpression'=>'$data->title', 
				'urlExpression'=>$courseUrlExpression, 
				// for instructors load the course files page
			),
			array( 
				'header'=>'Class Id', 
				'name'=>'idString()', 
				'value'=>'$data->idString()', 
			 ),
			array( 
				'header'=>'Faculty', 
				'class'=>'LinksColumn',
				'labelExpression'=>'$data->facultyNames()', 
				'urlExpression'=>'$data->facultyUrls()', 
			),
			array( 
				'header'=>'Assignments', 
				'class'=>'LinksColumn',
				'labelExpression'=>'\'<span class="badge">\' . $data->assignmentCount() . \'</span>\'', 
				'urlExpression'=>'array(\'course/assignments\', \'term_code\'=>$data->term_code, \'class_num\'=>$data->class_num, \'username\'=>\''. $model->username . '\')', 
			),
			/*array( 
				'header'=>'File Type: Select to change', 
				'type'=>'raw',
				'name'=>'fileType', 
				//'value'=>'$data->fileType()', 
				//'value'=>'CHtml::dropDownList(\'fileTypeList\', \'html\', array(1=>\'html\', 2=>\'pdf\'), array())', 
				'value'=>'$this->grid->controller->beginWidget("CForm", array(
					"action"=>Yii::app()->createUrl("/drcUser/SetFileType" ),
					"htmlOptions"=>array("class"=>"nav pull-right", ),
				));
					$this->grid->controller->widget(\'base.extensions.select2.ESelect2\',array(
					"name"=>"ftList",
				  	"data"=>FileType::options(),
					"htmlOptions"=>array("class"=>"input-large fileTypeList", ),
				), true); 
				echo CHtml::hiddenField("username", "'. $model->username .  '");
				$this->grid->controller->endWidget();', 
			),
			array( 
				'header'=>'File Type: Select to change', 
				'type'=>'raw',
				'name'=>'fileType', 
				//'value'=>'$data->fileType()', 
				//'value'=>'CHtml::dropDownList(\'fileTypeList\', \'html\', array(1=>\'html\', 2=>\'pdf\'), array())', 
				'value'=>'echo "<form action=" . Yii::app()->createUrl("/drcUser/SetFileType" ) . ">";
					$this->grid->controller->widget(\'base.extensions.select2.ESelect2\',array(
						"name"=>"ftList",
				  		"data"=>FileType::options(),
						"htmlOptions"=>array("class"=>"input-large fileTypeList", ),
					), true); 
					echo CHtml::hiddenField("username", "'. $model->username .  '");
					echo "</form>";', 
			),*/
			array( 
				'header'=>$typeLabel, 
				'type'=>'raw',
				'name'=>'fileType', 
			 	'htmlOptions'=>$typeHtmlOptions,
				'value'=>$typeValue, 
			),
			array( 
				'header'=>'Status', 
				'class'=>'LinksColumn',
			 	'labelExpression'=>'$data->completed(\''. $model->username . '\')? \'<span class="badge badge-success">Completed</span>\' : \'<span class="badge badge-warning">Pending</span>\'', 
				'urlExpression'=>'array(\'course/assignments\', \'term_code\'=>$data->term_code, \'class_num\'=>$data->class_num, \'username\'=>\''. $model->username . '\')', 
			 ),
		),
	)); 
	//echo '<script type="text/javascript"> jQuery(".fileTypeList").select2({"formatNoMatches":function(){return "No matches found";},"formatInputTooShort":function(input,min){return "Please enter "+(min-input.length)+" more characters";},"formatInputTooLong":function(input,max){return "Please enter "+(input.length-max)+" less characters";},"formatSelectionTooBig":function(limit){return "You can only select "+limit+" items";},"formatLoadMore":function(pageNumber){return "Loading more results...";},"formatSearching":function(){return "Searching...";}}); </script>';
	//echo '<script type="text/javascript"> jQuery(".fileTypeList").on("change", function(e) {  $("#target").submit(); }); </script>';
	?>

    </div><!--/span-->
</div><!--/row-->

<?php
/**
 * A view component for displaying and managing a list of filels for a course and uploadin more.
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.user
 */

	$this->beginWidget('BasePage', array(
		'title'=>$contentTitle,
		'htmlOptions' => array('class' => 'form'),
	)); 
    echo $this->renderPartial('base.views.file._list', array('model'=>$model)); 

	echo '<div class="page-header">';
	echo '<h2>Upload Files for this Course </h2>';
	echo '</div>';

	$form=$this->beginWidget('CActiveForm', array(
		'id'=>'course-list',
		'enableAjaxValidation'=>false,
		//'action'=> $action,
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
	)); 
	$this->widget('base.extensions.xupload.XUpload', array(
	                    'url' => Yii::app()->createUrl("course/uploadFile", array("term_ code"=>$model->term_code, "class_num"=>$model->class_num, "id"=>$model->id)),
	                    'model' => $model,
	                    'attribute' => 'file',
	                    'multiple' => true, 
						//'formView' => 'application.views.somemodel._form',
						'formView' => 'base.views.file._xupload',
						'htmlOptions' => array('id'=>'course-list'),
	));
    
    $this->endWidget(); 
    $this->endWidget(); 
    
?>
        

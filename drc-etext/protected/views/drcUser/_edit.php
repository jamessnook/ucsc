<?php
/**
 * The base view component for displaying and editing a user model.
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.user
 */

	$this->beginWidget('BasePage', array(
		'title'=>$contentTitle,
		'htmlOptions' => array('class' => 'form'),
	)); 
	$form=$this->beginWidget('UserEditForm', array(
		'model'=> $model,
		'action'=> $action,
	)); 
			 
	// book purchase section
    if (!$createNew){
        echo $this->renderPartial('../drcUser/_listBooks', array('model'=>$model)); 
    }
		  
    $this->endWidget(); 
    $this->endWidget(); 
	          	  
?>
        

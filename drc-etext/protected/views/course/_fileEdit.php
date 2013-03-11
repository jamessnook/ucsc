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
	$form=$this->beginWidget('FileEditForm', array(
		'model'=> $model,
		'action'=> $action,
	)); 
			 
	// added content in file edit form could go here 
	  
    $this->endWidget(); 
    $this->endWidget(); 
	          	  
?>
        

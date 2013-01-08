<?php
/**
 * The base view component file for displaying the user menu in the right side nav column.
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.layout
 */
?>

<?php 
	$url = array('user/create');
	// add parameters only if they exist
	//if ($model->username && strlen($model->username)>1) $url['username'] = $model->username;
	//if ($model->term_code && strlen($model->term_code)>1) $url['term_code'] = $model->term_code;  // make general code to do this....
	$url['username'] = $model->username;
	$url['term_code'] = $model->term_code;  // make general code to do this....
	$menuItems=array(
		array('label'=>'Add User', 'url'=>$url),
		);

	// build up the side bar menu
    $this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>'User Menu',
		'contentCssClass'=>'nav-header',
	));
	$this->widget('zii.widgets.CMenu', array(
		'items'=>$menuItems,
		'htmlOptions'=>array('class'=>'nav nav-list'),
	));
	$this->endWidget();
			
?>
<?php
/**
 * The base view component file for displaying the term (quarter) menu in the right side nav column.
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.layout
 */
?>


<?php 

	$menuItems=array();

	// make term list menu for use in CMenu
	$now = date('Y-m-d');
	//$terms =  Term::model()->findAll( "start_date < '$now' order by term_code desc  limit 10 " );
	// create param list for menu link
	//$params = array_flip(array_flip($_GET));
	$params = array();
	if ($model->username && strlen($model->username)>0)
		$params['username'] = $model->username;
	if ($model->emplid && strlen($model->emplid)>0)
		$params['emplid'] = $model->emplid;

	// create menu item for each term
	$terms = Term::terms($model);
	//foreach($terms as $term_code => $description) { 
	foreach($terms as $term) { 
		$params['term_code'] = $term->term_code;
		$route = $this->route;
		if (isset($menuRoute)) 
			$route = $menuRoute;
		$menuItems[] = array(
			'label'=>$term->description,
			//'url'=> $this->createUrl(Yii::app()->request->getPathInfo(), $params), 
			'url'=> $this->createUrl($route, $params), 
			'active'=> $model->term_code == $term->term_code,
		);
	}

	// build up the side bar menu
    $this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>'Quarters Menu',
		'contentCssClass'=>'nav-header',
	));
	$this->widget('zii.widgets.CMenu', array(
		'items'=>$menuItems,
		'htmlOptions'=>array('class'=>'nav nav-list'),
	));
	$this->endWidget();
			
?>
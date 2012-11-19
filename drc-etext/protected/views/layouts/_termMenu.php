
<?php 

	$menuItems=array();

	// make term list menu for use in CMenu
	$now = date('Y-m-d');
	$terms =  Term::model()->findAll( "start_date < '$now' order by term_code desc  limit 10 " );
	//$terms =  Term::model()->findAll("term_code < 2136 order by term_code desc  limit 10 " );
	$params = array();
	if ($model->username && strlen($model->username)>0)
		$params['username'] = $model->username;
	if ($model->emplid && strlen($model->emplid)>0)
		$params['emplid'] = $model->emplid;
		
	foreach($terms AS $term){
		$params['termCode'] = $term->term_code;
		$menuItems[] = array(
			'label'=>$term->description,
			'url'=> $this->createUrl(Yii::app()->request->getPathInfo(), $params), 
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

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

	// create sql to retieve term data for the current user (default is for all users who have drc requests)
	$sql = "SELECT DISTINCT term.term_code, term.description FROM term JOIN drc_request using (term_code)";
	if ($model->username && strlen($model->username)>0){
		$sql .= " JOIN user using (emplid) WHERE user.username = '$model->username'";
	}
	$sql .= " ORDER BY term_code DESC";
	$command=Yii::app()->db->createCommand($sql);
	$dataReader=$command->query();   // execute a query SQL
	
	// create menu item for each term
	$terms = Term::currentTerms($model);
	foreach($terms as $term_code => $description) { 
		$params['term_code'] = $term_code;
		$route = $this->route;
		if (isset($menuRoute)) 
			$route = $menuRoute;
		$menuItems[] = array(
			'label'=>$description,
			//'url'=> $this->createUrl(Yii::app()->request->getPathInfo(), $params), 
			'url'=> $this->createUrl($route, $params), 
			'active'=> $model->term_code == $term_code,
		);
	}
	/*
	foreach($dataReader as $row) { 
		$params['term_code'] = $row['term_code'];
		$route = $this->route;
		if (isset($menuRoute)) 
			$route = $menuRoute;
		$menuItems[] = array(
			'label'=>$row['description'],
			//'url'=> $this->createUrl(Yii::app()->request->getPathInfo(), $params), 
			'url'=> $this->createUrl($route, $params), 
			'active'=> $model->term_code == $row['term_code'],
		);
	}
	*/

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
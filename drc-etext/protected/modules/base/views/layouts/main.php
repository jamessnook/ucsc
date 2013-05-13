<?php
/**
 * The top level view file container for all views.
 * It only contains project wide non configurable content including title and top leve nav.
 * Content that is configurable and varies across pages is in _main.php
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.layout
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <!-- Le styles -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/DT_bootstrap.css" />
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-responsive.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin-responsive.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/DT_bootstrap-responsive.css" />

     <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/ico/favicon.ico" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/ico/apple-touch-icon-144-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/ico/apple-touch-icon-114-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/ico/apple-touch-icon-72-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/ico/apple-touch-icon-57-precomposed.png" />
  </head>

  <body>
	<div class="wrapper">
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo CHtml::encode(Yii::app()->name); ?></a>
		
          <div class="nav-collapse">
			<?php 
			$this->widget('zii.widgets.CMenu',array(
				'htmlOptions'=>array('class'=>'nav'), 
				'encodeLabel'=>false,
				'items'=>array(
					array('label'=>'<i class="icon-info-sign"></i> About', 'url'=>array('/site/about')),
					//array('label'=>'<i class="icon-envelope-alt"></i> Contact', 'url'=>array('/site/contact')),
				), 
			));
			if (Yii::app()->user->getState('isAdmin')=== true){
	      		echo '<div class="nav pull-right">';
				$form=$this->beginWidget('CActiveForm',array(
					'action'=>Yii::app()->createUrl('/base/login/switchUser'),
					'htmlOptions'=>array('class'=>'nav pull-right', ),
				)); 
	      		echo '<div class="form-horizontal">';
				echo CHtml::submitButton('Switch To: ', array('class'=>'btn'));
				$this->widget('base.extensions.select2.ESelect2',array(
					'name'=>'username',
				  	'data'=>User::userOptions(),
					'htmlOptions'=>array('class'=>'input-large', ),
				));
	      		echo '</div >';
				$this->endWidget();
	 			// temporary hack sincre the registered code is at the end of the page but does not appear to execute 
	 			echo '<script type="text/javascript"> jQuery("#username").select2({"formatNoMatches":function(){return "No matches found";},"formatInputTooShort":function(input,min){return "Please enter "+(min-input.length)+" more characters";},"formatInputTooLong":function(input,max){return "Please enter "+(input.length-max)+" less characters";},"formatSelectionTooBig":function(limit){return "You can only select "+limit+" items";},"formatLoadMore":function(pageNumber){return "Loading more results...";},"formatSearching":function(){return "Searching...";}}); </script>';
	      		echo '</div >';
			}
			$this->widget('zii.widgets.CMenu',array(
				'htmlOptions'=>array('class'=>'nav pull-right'), 
				'submenuHtmlOptions'=>array('class'=>'dropdown-menu'), 
				'encodeLabel'=>false,
				//'itemCssClass'=>'dropdown', 
				'items'=>array(
					/*array(
						'itemOptions'=>array('class'=>'dropdown'), 
						'url'=>'#',
						'linkOptions'=>array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown'), 
						
						'label'=> '<i class="icon-cog"></i> Settings <b class="caret"></b>',
						//'label'=> 'Fred',
						'items'=>array(
							array('label'=>'Account Settings', 'url'=>array('/user/profile')),
							array('label'=>'Privacy Settings', 'url'=>array('/user/profile')),
							array('label'=>'', 'itemOptions'=>array('class'=>'divider')),
							array('label'=>'Help', 'url'=>array('/site/help')),
						),
						
					),*/
					array(
						'itemOptions'=>array('class'=>'dropdown'), 
						'url'=>'#',
						'linkOptions'=>array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown'), 
						'label'=> '<i class="icon-user"></i>' . 'Switch To:' . '<b class="caret"></b>',
						'visible'=>Yii::app()->user->checkAccess('admin'),
						'items'=>User::userItems(),
						
					),
					array(
						'encodeLabel'=>false,
						'url'=>'#',
						'linkOptions'=>array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown'), 
						'label'=> '<i class="icon-user"></i>' . Yii::app()->user->name . '<b class="caret"></b>',
						//'label'=> 'Joe',
						'items'=>array(
							array('label'=>'My Profile', 'url'=>array($this->getModuleId() . '/user/profile')),
							//array('label'=> CHtml::label('Switch:', 'switch') . CHtml::dropDownList('role', '', User::userOptions())),
							array(
								'label'=> CHtml::link('Switch To:', "javascript: window.location='" . $this->createUrl('/base/login/switchUser'). "?username=' +  $('#swUser').val();", array('class'=>'btn')) . CHtml::textField('swUser', 'enter username'),
								'visible'=>Yii::app()->user->checkAccess('admin'),
							),
							
							//array('label'=>'My Groups', 'url'=>array('/user/groups')),
							array('label'=>'', 'itemOptions'=>array('class'=>'divider')),
							array('label'=>'Logout', 'url'=>array( '/' . $this->getModuleId() . '/site/logout')),
						),
					),
				), 
			));
			?>
			<form class="navbar-search pull-right">
				<!--- <input type="text" class="search-query" placeholder="Search"/>  -->
			</form>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
	

	<?php echo $content; ?>


	<div class="push"><!--//--></div>
  </div><!--/.wrapper-->

	<div class="co-foot">
		<div class="container-fluid">
			<div class="row">
				<div class="span12">
	    			<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/ucsc_wordmark.png" />
				</div>
			</div>
			<div class="row">
				<div class="span12">
					<p>UC Santa Cruz, 1156 High Street, Santa Cruz, Ca 95064<br />
					<span>©2012 Regents of the University of California. All Rights Reserved.</span></p>
				</div>
			</div>
		</div><!--/.container-->
	</div>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
	<script type="text/javascript" charset="utf-8" language="javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.dataTables.js"></script>
	<script type="text/javascript" charset="utf-8" language="javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/DT_bootstrap.js"></script>

  </body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

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

     <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/ico/apple-touch-icon-57-precomposed.png">
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
          <a class="brand" href="index.html"><?php echo CHtml::encode(Yii::app()->name); ?></a>
		  
		  
		
          <div class="nav-collapse">
            <ul class="nav">
              <li><a href="#about"><i class="icon-info-sign"></i> About</a></li>
              <li><a href="#contact"><i class="icon-envelope-alt"></i> Contact</a></li>
            </ul>
			<ul class="nav pull-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-cog"></i>
						Settings
						<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="javascript:;">Account Settings</a></li>
						<li><a href="javascript:;">Privacy Settings</a></li>
						<li class="divider"></li>
						<li><a href="javascript:;">Help</a></li>
					</ul>
				</li>
	            <li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-user"></i> 
						jrosczyk
						<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo $this->createUrl('user/profile'); ?>">My Profile</a></li>
						<li><a href="<?php echo $this->createUrl('user/groups'); ?>">My Groups</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo $this->createUrl('site/logout'); ?>">Logout</a></li>
					</ul>
					<?php $this->widget('zii.widgets.CMenu',array(
						'items'=>array(
							array('label'=>'My Profile', 'url'=>array('/user/profile')),
							array('label'=>'My Groups', 'url'=>array('/user/groups')),
							array('itemOptions'=>array('class'=>'divider')),
							array('label'=>'Logout', 'url'=>array('/site/logout')),
						),
						'htmlOptions'=>array('class'=>'dropdown-menu'),
					)); ?>
				</li>
	        </ul>
			<form class="navbar-search pull-right">
				<input type="text" class="search-query" placeholder="Search">
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
	    			<img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/img/ucsc_wordmark.png" />
				</div>
			</div>
			<div class="row">
				<div class="span12">
					<p>UC Santa Cruz, 1156 High Street, Santa Cruz, Ca 95064<br />
					<span>©2012 Regents of the University of California. All Rights Reserved.</span></p>
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

<body>

<div class="container" id="page">


	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				//array('label'=>'Home', 'url'=>array('/site/index')),
				//array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
				//array('label'=>'Contact', 'url'=>array('/site/contact')),
				array('label'=>'Service Requests', 'url'=>array('/serviceRequest/admin'), 'visible'=>Yii::app()->user->checkAccess('admin')),
				array('label'=>'Book Requests', 'url'=>array('/bookRequest/admin'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'File Types', 'url'=>array('/fileType/admin'), 'visible'=>Yii::app()->user->checkAccess('admin')),
				array('label'=>'Users', 'url'=>array('/user/admin'), 'visible'=>Yii::app()->user->checkAccess('admin')),
				//array('label'=>'Import Files', 'url'=>array('/serviceRequest/import'), 'visible'=>Yii::app()->user->checkAccess('admin')),
				array('label'=>'Login', 'url'=>array('/login/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/login/logout'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Help', 'url'=>array('/site/page', 'view'=>'help'))
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by The Regents of the University of California.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>eText Library</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="../../../../../css/bootstrap.css" rel="stylesheet">
    <link href="../../../../../css/admin.css" rel="stylesheet">
	<link href="../../../../../css/DT_bootstrap.css" rel="stylesheet">

    <style type="text/css">
      
    </style>
    <link href="../../../../../css/bootstrap-responsive.css" rel="stylesheet">
	<link href="../../../../../css/admin-responsive.css" rel="stylesheet">
	
	<link href="../../../../../css/font-awesome.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
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
          <a class="brand" href="index.html">eText Library</a>
		  
		  
		
          <div class="nav-collapse">
            <ul class="nav">
              <li><a href="#about"><i class="icon-info-sign"></i> About</a></li>
              <li><a href="#contact"><i class="icon-envelope-alt"></i> Contact</a></li>
            </ul>
			<ul class="nav pull-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-cog"></i>
						Settings
						<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="javascript:;">Account Settings</a></li>
						<li><a href="javascript:;">Privacy Settings</a></li>
						<li class="divider"></li>
						<li><a href="javascript:;">Help</a></li>
					</ul>
				</li>
	            <li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-user"></i> 
						jrosczyk
						<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="javascript:;">My Profile</a></li>
						<li><a href="javascript:;">My Groups</a></li>
						<li class="divider"></li>
						<li><a href="javascript:;">Logout</a></li>
					</ul>
				</li>
	        </ul>
			<form class="navbar-search pull-right">
				<input type="text" class="search-query" placeholder="Search">
			</form>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
	
	<div class="subnavbar">
      <div class="subnavbar-inner">
        <div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<ul class="nav nav-tabs">
						<li>
							<a href="index.html"><i class="icon-dashboard"></i> Dashboard</a>
						</li>
						<li class="active"><a href="courses.html">Courses</a></li>
						<li><a href="requests.html">Assignments</a></li>
						<li class="pull-right"><a href="reports.html"><i class="icon-wrench"></i> Reports</a></li>
						<li class="pull-right"><a href="roles.html"><i class="icon-group"></i> Roles</a></li>
						<li class="pull-right"><a href="users.html"><i class="icon-user"></i> Users</a></li>
					</ul>
				</div>
				
				
			</div>
		</div>
	  </div>
	</div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span9">
		  	<div class="page-unit">
				<div class="page-head">
					<div class="row-fluid">
						<h1 class="pull-left">Courses</h1>
						<ul class="nav nav-pills pull-right">
						      <li><a href="#"><i class="icon-plus"></i> Add Course</a></li>
						</ul>
					</div><!--/row-->
				</div><!--/head-->
				<div class="row-fluid">
		            <div class="span12">
		            	<table class="table table-striped" id="example">
							<thead>
								<tr>
									<th>Class Title</th>
									<th>Class ID</th>
									<th>Faculty</th>
									<th>Requests</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><a href="assignment.html">Photography and Anthropology</a></td>
									<td>ANTH 132 - 01</td>
									<td><a href="http://campusdirectory.ucsc.edu/detail.php?type=people&uid=sherring">Errington,S.E.</a></td>
									<td><span class="badge">7</span></td>
									<td><span class="badge badge-success">Completed</span></td>
								</tr>
								<tr>
									<td><a href="assignment.html">Photography and Anthropology</a></td>
									<td>ANTH 132 - 01</td>
									<td><a href="http://campusdirectory.ucsc.edu/detail.php?type=people&uid=sherring">Errington,S.E.</a></td>
									<td><span class="badge">7</span></td>
									<td><span class="badge badge-warning">Pending</span></td>
								</tr>
								<tr>
									<td><a href="assignment.html">Photography and Anthropology</a></td>
									<td>ANTH 132 - 01</td>
									<td><a href="http://campusdirectory.ucsc.edu/detail.php?type=people&uid=sherring">Errington,S.E.</a></td>
									<td><span class="badge">7</span></td>
									<td><span class="badge badge-warning">Pending</span></td>
								</tr>
								<tr>
									<td><a href="assignment.html">Photography and Anthropology</a></td>
									<td>ANTH 132 - 01</td>
									<td><a href="http://campusdirectory.ucsc.edu/detail.php?type=people&uid=sherring">Errington,S.E.</a></td>
									<td><span class="badge">7</span></td>
									<td><span class="badge badge-warning">Pending</span></td>
								</tr>
								<tr>
									<td><a href="assignment.html">Photography and Anthropology</a></td>
									<td>ANTH 132 - 01</td>
									<td><a href="http://campusdirectory.ucsc.edu/detail.php?type=people&uid=sherring">Errington,S.E.</a></td>
									<td><span class="badge">7</span></td>
									<td><span class="badge badge-warning">Pending</span></td>
								</tr>
								<tr>
									<td><a href="assignment.html">Photography and Anthropology</a></td>
									<td>ANTH 132 - 01</td>
									<td><a href="http://campusdirectory.ucsc.edu/detail.php?type=people&uid=sherring">Errington,S.E.</a></td>
									<td><span class="badge">7</span></td>
									<td><span class="badge badge-warning">Pending</span></td>
								</tr>
								<tr>
									<td><a href="assignment.html">Photography and Anthropology</a></td>
									<td>ANTH 132 - 01</td>
									<td><a href="http://campusdirectory.ucsc.edu/detail.php?type=people&uid=sherring">Errington,S.E.</a></td>
									<td><span class="badge">7</span></td>
									<td><span class="badge badge-warning">Pending</span></td>
								</tr>
								<tr>
									<td><a href="assignment.html">Photography and Anthropology</a></td>
									<td>ANTH 132 - 01</td>
									<td><a href="http://campusdirectory.ucsc.edu/detail.php?type=people&uid=sherring">Errington,S.E.</a></td>
									<td><span class="badge">7</span></td>
									<td><span class="badge badge-warning">Pending</span></td>
								</tr>
								<tr>
									<td><a href="assignment.html">Photography and Anthropology</a></td>
									<td>ANTH 132 - 01</td>
									<td><a href="http://campusdirectory.ucsc.edu/detail.php?type=people&uid=sherring">Errington,S.E.</a></td>
									<td><span class="badge">7</span></td>
									<td><span class="badge badge-warning">Pending</span></td>
								</tr>
								<tr>
									<td><a href="assignment.html">Photography and Anthropology</a></td>
									<td>ANTH 132 - 01</td>
									<td><a href="http://campusdirectory.ucsc.edu/detail.php?type=people&uid=sherring">Errington,S.E.</a></td>
									<td><span class="badge">7</span></td>
									<td><span class="badge badge-warning">Pending</span></td>
								</tr>
								<tr>
									<td><a href="assignment.html">Photography and Anthropology</a></td>
									<td>ANTH 132 - 01</td>
									<td><a href="http://campusdirectory.ucsc.edu/detail.php?type=people&uid=sherring">Errington,S.E.</a></td>
									<td><span class="badge">7</span></td>
									<td><span class="badge badge-warning">Pending</span></td>
								</tr>
								<tr>
									<td><a href="assignment.html">Photography and Anthropology</a></td>
									<td>ANTH 132 - 01</td>
									<td><a href="http://campusdirectory.ucsc.edu/detail.php?type=people&uid=sherring">Errington,S.E.</a></td>
									<td><span class="badge">7</span></td>
									<td><span class="badge badge-warning">Pending</span></td>
								</tr>
							</tbody>
						</table>
						
				
		            </div><!--/span-->
		        </div><!--/row-->
			</div><!--/page-unit-->
		  

        </div><!--/span-->
		<div class="span3">
          <div class="well">
            <ul class="nav nav-list">
              <li class="nav-header">Quarters Menu</li>
              <li class="active"><a href="#">Summer I 2012</a></li>
			  <li><a href="#">Spring 2012</a></li>
              <li><a href="#">Winter 2012</a></li>
              <li><a href="#">Fall 2011</a></li>
              <li><a href="#">Spring 2011</a></li>

            </ul>
          </div><!--/.well -->
        </div><!--/span-->
      </div><!--/row-->
    </div><!--/.fluid-container-->
	<div class="push"><!--//--></div>
  </div><!--/.wrapper-->

	<div class="co-foot">
		<div class="container-fluid">
			<div class="row">
				<div class="span12">
	    			<img src="../../../../../img/ucsc_wordmark.png" />
				</div>
			</div>
			<div class="row">
				<div class="span12">
					<p>UC Santa Cruz, 1156 High Street, Santa Cruz, Ca 95064<br />
					<span>©2012 Regents of the University of California. All Rights Reserved.</span></p>
				</div>
		</div><!--/.container-->
	</div>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="../../../../../js/bootstrap.min.js"></script>
	<script type="text/javascript" charset="utf-8" language="javascript" src="../../../../../js/jquery.dataTables.js"></script>
	<script type="text/javascript" charset="utf-8" language="javascript" src="../../../../../js/DT_bootstrap.js"></script>

  </body>
</html>
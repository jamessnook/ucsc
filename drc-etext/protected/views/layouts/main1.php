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
						<li><a href="<?php echo $this->createUrl('/user/profile'); ?>">Account Settings</a></li>
						<li><a href="<?php echo $this->createUrl('/user/profile'); ?>">Privacy Settings</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo $this->createUrl('/site/help'); ?>">Help</a></li>
					</ul>
				</li>
	            <li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-user"></i> 
						<?php echo Yii::app()->user->name  ?>
						<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo $this->createUrl('/user/profile'); ?>">My Profile</a></li>
						<li><a href="<?php echo $this->createUrl('/user/groups'); ?>">My Groups</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo $this->createUrl('/site/logout'); ?>">Logout</a></li>
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
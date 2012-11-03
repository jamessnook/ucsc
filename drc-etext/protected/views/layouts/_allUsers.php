
	<div class="subnavbar">
      <div class="subnavbar-inner">
        <div class="container-fluid">
		  <div class="row-fluid">
			<div class="span12">
			  <?php 
				$this->widget('zii.widgets.CMenu',array(
					'htmlOptions'=>array('class'=>'nav nav-tabs'), 
					'encodeLabel'=>false,
					'items'=>array(
						array('label'=>'<i class="icon-dashboard"></i> Dashboard', 'url'=>array('/site/about'), 'visible'=>false),
						array('label'=>'Courses', 'url'=>array('/course/view')),
						array('label'=>'Assignments', 'url'=>array('/assignment/view'), 'visible'=>Yii::app()->user->checkAccess('admin')),
						array('label'=>'<i class="icon-wrench"></i> Reports', 'url'=>array('/course/view'), 'itemOptions'=>array('class'=>'pull-right'), 'visible'=>Yii::app()->user->checkAccess('admin')),
						array('label'=>'<i class="icon-group"></i> Roles', 'url'=>array('/user/view'), 'itemOptions'=>array('class'=>'pull-right'), 'visible'=>Yii::app()->user->checkAccess('admin')),
						array('label'=>'<i class="icon-user"></i> Users', 'url'=>array('/user/view'), 'itemOptions'=>array('class'=>'pull-right'), 'visible'=>Yii::app()->user->checkAccess('admin')),
					), 
				));
			  ?>
			</div>
		  </div>
		</div>
      </div><!--/.subnavbar-inner-->
    </div><!--/.subnavbar-->

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span9">
		  <div class="page-unit">

			<div class="page-head">
				<div class="row-fluid">
					<h1 class="pull-left"><?php echo $title; ?></h1>
					<ul class="nav nav-pills pull-right">
						<li><?php echo $titleNavRight; ?></li>
					</ul>
				</div><!--/row-->
			</div><!--/head-->
			
			<?php echo $this->renderPartial($contentView, array('model'=>$model)); // grid showong assignment list ?>
	
		  </div><!--/page-unit-->
        </div><!--/span-->
		<div class="span3">
          <div class="well">
            
			<?php echo $this->renderPartial($menuView, array('model'=>$model)); // grid showong assignment list ?>
            
          </div><!--/.well -->
        </div><!--/span-->
      </div><!--/row-->
    </div><!--/.fluid-container-->


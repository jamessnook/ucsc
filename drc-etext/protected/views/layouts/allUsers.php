<?php $this->beginContent('//layouts/main'); ?>

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

	    <div class="container-fluid">
	      <div class="row-fluid">
	        <div class="span9">
			  <div class="page-unit">
	
				<?php echo $content; ?>
		
			  </div><!--/page-unit-->
	        </div><!--/span-->
			<div class="span3">
	          <div class="well">
	            
		        <?php
		        	// build up the side bar menu
		        	$this->beginWidget('zii.widgets.CPortlet', array(
						'title'=>'Quarters Menu',
						'contentCssClass'=>'nav-header',
					));
					$this->widget('zii.widgets.CMenu', array(
						'items'=>$this->menu,
						'htmlOptions'=>array('class'=>'nav nav-list'),
					));
					$this->endWidget();
				?>
	            
	            
	          </div><!--/.well -->
	        </div><!--/span-->
	      </div><!--/row-->
	    </div><!--/.fluid-container-->
      </div><!--/.subnavbar-inner-->
    </div><!--/.subnavbar-->

<?php $this->endContent(); ?>
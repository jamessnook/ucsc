<?php $this->beginContent('//layouts/main'); ?>
<div class="container">

	<div class="subnavbar">
      <div class="subnavbar-inner">
        <div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<?php 
					$this->widget('zii.widgets.CMenu',array(
						'itemOptions'=>array('class'=>'nav nav-tabs'), 
						'items'=>array(
							array('label'=>'<i class="icon-dashboard"></i> Dashboard', 'url'=>array('/site/about')),
							array('label'=>'Courses', 'url'=>array('/course/view')),
							array('label'=>'Assignments', 'url'=>array('/assignment/view')),
							array('label'=>'<i class="icon-wrench"></i> Reports', 'url'=>array('/course/view'), 'itemOptions'=>array('class'=>'pull-right')),
							array('label'=>'<i class="icon-group"></i> Roles', 'url'=>array('/user/view'), 'itemOptions'=>array('class'=>'pull-right')),
							array('label'=>'<i class="icon-user"></i> Users', 'url'=>array('/user/view'), 'itemOptions'=>array('class'=>'pull-right')),
						), 
					));
					?>
				</div>
				
				
			</div>
		</div>
	  </div>
	</div>

	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<?php $this->endContent(); ?>

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
						array(
							'label'=>'<i class="icon-dashboard"></i> Dashboard', 
							'url'=>array('/site/about'), 
							'visible'=>false,
						),
						array(
							'label'=>'Courses', 
							'url'=>array('/course/courses', 
								'termCode'=>$model->term_code, ), 
							'active'=> get_class($model) == 'Course',
						),
						array(
							'label'=>'Assignments', 
							'url'=>array('/assignment/manage', 
								'termCode'=>$model->term_code,), 
							'visible'=>Yii::app()->user->checkAccess('admin'),
							'active'=> get_class($model) == 'Assignment',
						),
						array(
							'label'=>'<i class="icon-wrench"></i> Reports', 
							'url'=>array('/course/courses'), 
							'itemOptions'=>array('class'=>'pull-right'), 
							'visible'=>Yii::app()->user->checkAccess('admin'),
							'active'=> false,  // disable for now
						),
						array(
							'label'=>'<i class="icon-group"></i> Roles', 
							'url'=>array('/user/students', 'termCode'=>$model->term_code,), 
							'itemOptions'=>array('class'=>'pull-right'), 
							'visible'=>Yii::app()->user->checkAccess('admin'),
							'active'=> false,  // disable for now
						),
						array(
							'label'=>'<i class="icon-user"></i> Users', 
							'url'=>array('/user/students', 'termCode'=>$model->term_code,), 
							'itemOptions'=>array('class'=>'pull-right'), 
							'visible'=>Yii::app()->user->checkAccess('admin'), 
							'active'=> get_class($model) == 'User',
						),
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
					<h1 class="pull-left"><?php echo $options['title']; ?></h1>
					<ul class="nav nav-pills pull-right">
						<li><?php if (isset($options['titleNavRight'])) echo $options['titleNavRight']; ?></li>
					</ul>
				</div><!--/row-->
			</div><!--/head-->
			
			<?php 
				if (isset($options['contentModel'])){
				  	$contentModel = $options['contentModel'];
				} else {
				  	$contentModel = $model;
				}
				echo $this->renderPartial($options['contentView'], array('options'=>$options, 'model'=>$contentModel)); // grid  
			?>
	
		  </div><!--/page-unit-->
        </div><!--/span-->
		<div class="span3">
          <div class="well">
            
			<?php echo $this->renderPartial($options['menuView'], array('options'=>$options, 'model'=>$model)); // grid showong assignment list ?>
            
          </div><!--/.well -->
        </div><!--/span-->
      </div><!--/row-->
    </div><!--/.fluid-container-->


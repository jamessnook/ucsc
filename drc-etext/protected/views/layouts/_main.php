<!--Main layout Frame for UCSC web app -->

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
								'term_code'=>$model->term_code, ), 
							'active'=> get_class($model) == 'Course',
						),
						array(
							'label'=>'Assignments', 
							'url'=>array('/assignment/manage', 
								'term_code'=>$model->term_code,), 
							'visible'=>Yii::app()->user->checkAccess('admin'),
							'active'=> get_class($model) == 'Assignment',
						),
						array(
							'label'=>'<i class="icon-wrench"></i> Reports', 
							'url'=>array('/course/courses'), 
							'itemOptions'=>array('class'=>'pull-right'), 
							'visible'=>Yii::app()->user->checkAccess('admin'),
							'active'=> false,  // disable for now
							'visible'=>false,
						),
						array(
							'label'=>'<i class="icon-user"></i> Staff', 
							'url'=>array('/user/staff', 'term_code'=>$model->term_code,), 
							'itemOptions'=>array('class'=>'pull-right'), 
							'visible'=>Yii::app()->user->checkAccess('admin'),
							'active'=> get_class($model) == 'User' && (Yii::app()->authManager->checkAccess('staff', $model->username)||Yii::app()->authManager->checkAccess('admin', $model->username)),
						),
						array(
							'label'=>'<i class="icon-user"></i> Faculty', 
							'url'=>array('/user/faculty', 'term_code'=>$model->term_code,), 
							'itemOptions'=>array('class'=>'pull-right'), 
							'visible'=>Yii::app()->user->checkAccess('admin'),
							'active'=> get_class($model) == 'User' && Yii::app()->authManager->checkAccess('faculty', $model->username),
						),
						array(
							'label'=>'<i class="icon-user"></i> Students', 
							'url'=>array('/user/students', 'term_code'=>$model->term_code,), 
							'itemOptions'=>array('class'=>'pull-right'), 
							'visible'=>Yii::app()->user->checkAccess('admin'), 
							'active'=> get_class($model) == 'User' && Yii::app()->authManager->checkAccess('student', $model->username),
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
				$options['model'] = $contentModel;
				//echo $this->renderPartial($options['contentView'], array('options'=>$options, 'model'=>$contentModel)); // grid  
				echo $this->renderPartial($options['contentView'], $options); // grid  
				?>
	
		  </div><!--/page-unit-->
        </div><!--/span-->
		<div class="span3">
          <div class="well">
            
			<?php 
				if ($options['menuView'] != 'none' && strlen($options['menuView'])>2){
			 		echo $this->renderPartial($options['menuView'], array('options'=>$options, 'model'=>$model)); // grid showong assignment list
				} 
			?>
            
          </div><!--/.well -->
        </div><!--/span-->
      </div><!--/row-->
    </div><!--/.fluid-container-->


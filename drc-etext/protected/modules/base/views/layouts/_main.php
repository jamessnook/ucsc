<?php
/**
 * The base view component file for page layout.
 * This includes configurable content and is then contained in the main.php layout file whoch is just an outer non configurable frame
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.layout
 */
?>

<!--Main layout Frame for UCSC web app -->
<?php 
$options = $this->viewOptions;
?>
			  
	<div class="subnavbar">
      <div class="subnavbar-inner">
        <div class="container-fluid">
		  <div class="row-fluid">
			<div class="span12">
			  <?php 
				$this->widget('zii.widgets.CMenu',array(
					'htmlOptions'=>array('class'=>'nav nav-tabs'), 
					'submenuHtmlOptions'=>array('class'=>'dropdown-menu'), 
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
						/*
						array(
							'label'=>'<i class="icon-user"></i> Staff', 
							'url'=>array('/user/staff', 'term_code'=>$model->term_code,), 
							'itemOptions'=>array('class'=>'pull-right'), 
							'visible'=>Yii::app()->user->checkAccess('admin'),
							'active'=> $activeTab == 'staff',
							//'active'=> get_class($model) == 'User' && (Yii::app()->authManager->checkAccess('staff', $model->username)||Yii::app()->authManager->checkAccess('admin', $model->username)),
						),
						array(
							'label'=>'<i class="icon-user"></i> Faculty', 
							'url'=>array('/user/faculty', 'term_code'=>$model->term_code,), 
							'itemOptions'=>array('class'=>'pull-right'), 
							'visible'=>Yii::app()->user->checkAccess('admin'),
							'active'=>  $activeTab == 'faculty',
						),
						array(
							'label'=>'<i class="icon-user"></i> Students', 
							'url'=>array('/user/students', 'term_code'=>$model->term_code,), 
							'itemOptions'=>array('class'=>'pull-right'), 
							'visible'=>Yii::app()->user->checkAccess('admin'), 
							'active'=> $activeTab == 'students',
						),
						*/
						array(
							'itemOptions'=>array('class'=>'dropdown pull-right'), 
							'url'=>'#',
							'linkOptions'=>array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown'), 
							'label'=>'<i class="icon-user"></i> Users <b class="caret"></b>', 
							'visible'=>Yii::app()->user->checkAccess('admin'), 
							'active'=>get_class($model) == 'User',
							'items'=>array(
								array(
									'label'=>'Students', 
									'url'=>array('user/students', 'term_code'=>$model->term_code,),
								),
								array(
									'label'=>'Faculty', 
									'url'=>array('user/faculty', 'term_code'=>$model->term_code,), 
								),
								array(
									'label'=>'Staff', 
									'url'=>array('user/staff', 'term_code'=>$model->term_code,), 
								),
							),
							
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
					<h1 class="pull-left"><?php echo $title; ?></h1>
					<ul class="nav nav-pills pull-right">
						<li><?php 
							if (isset($titleNavRight)){ 
								echo $titleNavRight; 
							} else if (isset($navRight)){ 
								echo '<a href="' . $navRight['url'] . '"><i class="icon-plus"></i>' . $navRight['label'] . '</a>';
							}
						?></li>
					</ul>
				</div><!--/row-->
			</div><!--/head-->
			
			<?php 
				if (isset($contentModel)){
					$options['model'] = $contentModel; // use inner content model if it exists
				} 
				echo $this->renderPartial($contentView, $options); // grid  
			?>
	
		  </div><!--/page-unit-->
        </div><!--/span-->
		<div class="span3">
          <div class="well">
            
			<?php 
				if ($menuView != 'none' && strlen($menuView) > 1){
					$options['model'] = $model; // restore to use outer model not content model
					echo $this->renderPartial($menuView, $options); // grid showong assignment list
				} 
			?>
            
          </div><!--/.well -->
        </div><!--/span-->
      </div><!--/row-->
    </div><!--/.fluid-container-->


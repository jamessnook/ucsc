<?php
/**
 * The base view component file for page layout.
 * This includes configurable content and is then contained in the main.php layout file which is just an outer non configurable frame
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
			  	$tabMenu->run();
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


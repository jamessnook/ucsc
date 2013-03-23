<?php
/**
 * The base view component for displaying and editing a user model.
 * Can be included in a composite view 
 *
 * @author Jim Snook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.views.user
 */
?>

<div class="form">

	<div class="row-fluid">
        <div class="span12">
			<h2><?php echo $contentTitle; ?></h2>
			<br />
				
			<?php 
				$form=$this->widget('UserEditForm', array(
					'action'=> $action,
				)); 
		        // book purchase section
		        if (!$createNew){
		          	echo $this->renderPartial('../user/_listBooks', array('model'=>$model)); 
		        }
			?>
		
        </div><!--/span-->
    </div><!--/row-->

<?php $this->endWidget(); ?>

</div><!-- form -->
        

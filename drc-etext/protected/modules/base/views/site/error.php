<?php
$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span12">
		  <div class="page-unit">
			<div class="page-head">
				<div class="row-fluid">
					<h2>Error <?php echo $code; ?></h2>
    			</div><!--/span-->
			</div><!--/row-->

			<div class="error">
				<?php echo CHtml::encode($message); ?>
			</div>
    	  </div>
		</div>
  	  </div>
	</div>

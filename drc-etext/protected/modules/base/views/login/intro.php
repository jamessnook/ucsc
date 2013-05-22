<?php
$this->pageTitle=Yii::app()->name . ' - Introduction';
$this->breadcrumbs=array(
	'Intro',
);
?>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span12">
		  <div class="page-unit">
			<div class="page-head">
				<div class="row-fluid">
		<h1>Welcome</h1>
    </div><!--/span-->
</div><!--/row-->
		
		<p>Click the button below if you wish to login:</p>
		
		<div class="form">
			<?php echo CHtml::link('Login', array('/base/login/login'), array( 'class'=>"btn" )); ?>
		</div><!-- form -->
    </div><!--/span-->
</div><!--/row-->
    </div><!--/span-->
</div><!--/row-->

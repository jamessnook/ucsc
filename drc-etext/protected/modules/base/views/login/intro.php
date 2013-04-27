<?php
$this->pageTitle=Yii::app()->name . ' - Introduction';
$this->breadcrumbs=array(
	'Intro',
);
?>

<h1>Welcome</h1>

<p>Click the button below if you wish to login:</p>

<div class="form">
<?php echo CHtml::link('Login', array('/base/login/login'), array( 'class'=>"btn" )); ?>
</div><!-- form -->

<div class="view">
	<div class="row-fluid">
         <div class="span12">
			<h2>Assignment: <?php echo CHtml::encode($model->title); ?></h2>
				
			<p>
				<b><?php echo CHtml::encode($model->getAttributeLabel('book_id')); ?>:</b>
				<?php echo CHtml::encode($model->book->title); ?>
			</p>
			<p>
				<b><?php echo CHtml::encode($model->getAttributeLabel('description')); ?>:</b>
				<?php echo CHtml::encode($model->description); ?>
			</p>
			<p>
				<b><?php echo CHtml::encode($model->getAttributeLabel('due_date')); ?>:</b>
				<?php echo CHtml::encode($model->due_date); ?>
				<br />
			</p>
			<p>
				<?php echo $this->renderPartial('../assignment/_listFiles', array('model'=>$model)); ?>
			</p>
		
        </div><!--/span-->
    </div><!--/row-->
</div><!-- view -->
        

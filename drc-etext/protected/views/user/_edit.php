<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'assignment-form',
	'enableAjaxValidation'=>false,
	'action'=> $action,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

		<div class="row-fluid">
            <div class="span12">
				<h2><?php echo $title; ?></h2>
				<br />
				
            	<form class="" action="request-edit.html">
            	
					<fieldset>
			          <div class="control-group">
						<?php echo $form->labelEx($model,'username'); ?>
			            <div class="controls">
			            
							<?php echo $form->textField($model,'username',array('class'=>"input-xxlarge",'maxlength'=>63)); // also? id="input01", type="text" ?>
							<?php echo $form->error($model,'username'); ?>
			              
			            </div>
			          </div>
			          <div class="control-group">
						<?php echo $form->labelEx($model,'first_name'); ?>
			            <div class="controls">
			            
							<?php echo $form->textField($model,'first_name',array('class'=>"input-xxlarge",'maxlength'=>63)); // also? id="input01", type="text" ?>
							<?php echo $form->error($model,'first_name'); ?>
			              
			            </div>
			          </div>
			          <div class="control-group">
						<?php echo $form->labelEx($model,'last_name'); ?>
			            <div class="controls">
			            
							<?php echo $form->textField($model,'last_name',array('class'=>"input-xxlarge",'maxlength'=>127)); // also? id="input01", type="text" ?>
							<?php echo $form->error($model,'last_name'); ?>
			              
			            </div>
			          </div>
			          <div class="control-group">
						<?php echo $form->labelEx($model,'email'); ?>
			            <div class="controls">
			            
							<?php echo $form->textField($model,'email',array('class'=>"input-xxlarge",'maxlength'=>127)); // also? id="input01", type="text" ?>
							<?php echo $form->error($model,'email'); ?>
			              
			            </div>
			          </div>
			          <div class="control-group">
						<?php echo $form->labelEx($model,'phone'); ?>
			            <div class="controls">
			            
							<?php echo $form->textField($model,'phone',array('class'=>"input-xxlarge",'maxlength'=>31)); // also? id="input01", type="text" ?>
							<?php echo $form->error($model,'phone'); ?>
			              
			            </div>
			          </div>

			          <div class="control-group">
        				<?php 	echo CHtml::label('Role', 'roleName'); ?>
			            <div class="controls">
							
					        <?php 	$username = $model->username;
					        		$userRoles = Yii::app()->authManager->getRoles($username);
					        		$selected = key($userRoles);
					        		$options = array();
					        		$roles = array_keys (Yii::app()->authManager->getRoles());
					        		foreach ($roles as $role){
					        			$options[$role]=$role;
					        		}
					        		echo CHtml::dropDownList('roleName', $selected, $options);
					        ?>

			            </div>
			          </div>

			          <div class="form-actions">
			          
						<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array( 'class'=>"btn btn-primary" )); ?>
						<?php echo CHtml::button('Cancel', array( 'class'=>"btn", 'onclick'=> "history.back()" )); ?>
			            
			          </div>
			        </fieldset>
			      </form>
		
            </div><!--/span-->
        </div><!--/row-->

<?php $this->endWidget(); ?>

</div><!-- form -->
        

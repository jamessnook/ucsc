<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'assignment-form',
	'enableAjaxValidation'=>false,
)); ?>

		<div class="row-fluid">
            <div class="span12">
				<h2>Create Assignment</h2>
				<br />
				
            	<form class="" action="request-edit.html">
            	
					<fieldset>
			          <div class="control-group">
			            <label class="control-label" for="input01">Title</label>
			            <div class="controls">
			            
							<?php echo $form->textField($model,'title',array('class'=>"input-xxlarge",'maxlength'=>127)); // also? id="input01", type="text" ?>
							<?php echo $form->error($model,'title'); ?>
			              
			            </div>
			          </div>
			          <div class="control-group">
			            <label class="control-label" for="textarea">Book</label>
						<?php echo $form->labelEx($model,'book_id'); ?>
			            <div class="controls">
							
					        <?php 	$options = CHtml::listData(Book::model()->findAll(), 'id', 'title');
					        		echo $form->dropDownList($model,'book_id', $options, array('class'=>"input-xxlarge"));
					        ?>
							<?php echo $form->error($model,'book_id'); ?>

			            </div>
			          </div>
					  <div class="control-group">
						<?php echo $form->labelEx($model,'description'); ?>
			            <div class="controls">
			            
							<?php echo CHtml::activeTextArea($model,'description',array('rows'=>3, 'class'=>"input-xxlarge")); ?>
							<?php echo $form->error($model,'description'); ?>
			              
			            </div>
			          </div>
					  <div class="control-group">
			            <label class="control-label" for="input01">Due Date</label>
						<?php echo $form->labelEx($model,'description'); ?>
			            <div class="controls">
			            
							<?php echo $form->labelEx($model,'due_date'); ?>
							<?php 
							$this->widget('zii.widgets.jui.CJuiDatePicker', array(
								'model'=>$model,
								'attribute'=>'due_date',	    
							    'options'=>array( 'showAnim'=>'fold',  ),
							    'htmlOptions'=>array( 'style'=>'height:20px;', 'class'=>"input-xxlarge" ),
							));
							?>
							<?php echo $form->error($model,'due_date'); ?>

			            </div>
			          </div>
					  
				
					  <div class="alert alert-info">
					  
					        <button type="button" class="close" data-dismiss="alert">×</button>
							<strong>Looking to attach files?</strong> Please fill out and save the new request form first.
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
    
    
    
    				<div class="row-fluid">
		            <div class="span12">
						<h2>Chapters 2-5, Micro Cosmos</h2>
						<br />
		            	<form class="">
							<fieldset>
					          <div class="control-group">
					            <label class="control-label" for="input01">Request Title</label>
					            <div class="controls">
					              <input type="text" class="input-xxlarge" id="input01" value="Chapters 2-5, Micro Cosmos">
					            </div>
					          </div>
							  <div class="control-group">
					            <label class="control-label" for="textarea">Description</label>
					            <div class="controls">
					              <textarea class="input-xxlarge" id="textarea" rows="3">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</textarea>
					            </div>
					          </div>
							  <div class="control-group">
					            <label class="control-label" for="textarea">Book</label>
					            <div class="controls">
					              	<select class="input-xxlarge">
									  <option>Micro Cosmos by John Smith and Joan Doe; Edition 3.5</option>
									  <option>2</option>
									  <option>3</option>
									  <option>4</option>
									  <option>5</option>
									</select>
					            </div>
					          </div>
							  <div class="control-group">
					            <label class="control-label" for="input01">Type</label>
									<span class="label">PDF</span>
									<span class="label">MP3</span>
									<span class="label">TXT</span>
									<p class="help-block"><small>Based on the students enrolled in this class, that requested Alt media for this class, these file types need to be included with this assignment request.</small></p>
								</label>
							</div>
							  
							<div class="page-header">
							            <h2>File Upload</h2>
							          </div>
							  <!-- The fileinput-button span is used to style the file input field as button -->
			                <span class="btn btn-success fileinput-button">
			                    <i class="icon-plus icon-white"></i>
			                    <span>Add files...</span>
			                </span>
			                <button type="submit" class="btn btn-primary start">
			                    <i class="icon-upload icon-white"></i>
			                    <span>Start upload</span>
			                </button>
			                <button type="reset" class="btn btn-warning cancel">
			                    <i class="icon-ban-circle icon-white"></i>
			                    <span>Cancel upload</span>
			                </button>
			                <button type="button" class="btn btn-danger delete">
			                    <i class="icon-trash icon-white"></i>
			                    <span>Delete</span>
			                </button>
			                <input type="checkbox" class="toggle">
							<br /><br />

			            	<table class="table table-striped">
								<thead>
									<tr>
										<th style="width:5%"></th>
										<th style="width:8%">Type</th>
										<th style="width:80%">Filename</th>
										<th style="width:5%"></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><input type="checkbox" class="toggle"></td>
										<td><span class="label">PDF</span></td>
										<td><a href="#">photoAnthroSyl.pdf</a></td>
										<td><a href="#" class="btn">Delete</a></td>
									</tr>
									<tr>
										<td><input type="checkbox" class="toggle"></td>
										<td><span class="label">MP3</span></td>
										<td><a href="#">photoAnthroSyl.mp3</a></td>
										<td><a href="#" class="btn">Delete</a></td>
									</tr>
									


								</tbody>
							</table>
							  <br />
					          <div class="form-actions">
					            <button type="submit" class="btn btn-primary">Save request</button>
					            <button class="btn">Cancel</button>
								<button type="complete" class="btn btn-success pull-right disabled" disabled="disabled">Request Completed</button>
					          </div>
					        </fieldset>
					      </form>
						  
					
				
		            </div><!--/span-->
		        </div><!--/row-->
        

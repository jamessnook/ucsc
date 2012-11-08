    
					          
							<div class="control-group">
					            <label class="control-label" for="input01">Type</label>
					            
								<?php 
									foreach ($model->drcRequests->type as $req){
										echo '<span class="label">' . $req->type . '</span>';
									}
									if (count($model->drcRequests)>0){
										echo '<p class="help-block"><small>Based on the students enrolled in this class, that requested Alt media for this class, these file types need to be included with this assignment request.</small></p>';
									} else{
										echo '<p class="help-block"><small>No students have yet requested Alt media types for this class.</small></p>';
																			}
								?>
								
								<p class="help-block"><small>Based on the students enrolled in this class, that requested Alt media for this class, these file types need to be included with this assignment request.</small></p>
							</div>
							  
							<div class="page-header">
							            <h2>File Upload</h2>
							          </div>
							          
							   <?php
								$this->widget('xupload.XUpload', array(
								                    'url' => Yii::app()->createUrl("file/upload", array("assignment_id" => $model->id)),
								                    //'model' => $model,
								                    'attribute' => 'file',
								                    'multiple' => true, 
								));
								?>      
							          
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
							
							
								<?php 
	
	//$model->username = Yii::app()->user->name;  // set up for current user
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'assignmentFilesGrid',
		'dataProvider'=>$model->studentAssignmentFiles(),
		//'filter'=>$model,
		//'hideHeader'=>true,
		'summaryText'=>'',
		'enablePagination'=>false,
		'loadingCssClass'=>'',
		'itemsCssClass'=>"table table-striped table-bordered data-table", 
		'pager'=>array('class'=>'CLinkPager', 'header'=>''), 
		'pagerCssClass'=>"pagination", 
		'columns'=>array(
			array( 
				'header'=>'File', 
				'class'=>'CLinksColumn',
				'labelExpression'=>'$data->title', 
				'urlExpression'=>'array(\'assignment/files\', \'id\'=>$data->id)', 
			),
			array( 
				'header'=>'Type', 
				'name'=>'book.title', 
				'value'=>'$data->book->title', 
			 ),
			array( 
				'header'=>'Description', 
				'name'=>'fileCount()', 
				'type'=>'raw',
				'value'=>'\'<span class="badge">\' . $data->fileCount() . \'</span>\'', 
			 ),
		),
	)); 
	?>

							
							
							  <br />
					          <div class="form-actions">
					            <button type="submit" class="btn btn-primary">Save request</button>
					            <button class="btn">Cancel</button>
								<button type="complete" class="btn btn-success pull-right disabled" disabled="disabled">Request Completed</button>
					          </div>

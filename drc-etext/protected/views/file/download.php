<?php
$this->breadcrumbs=array(
	'File'=>array('/file'),
	'Download',
);?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<h1>Download Files</h1>


<?php 
	$files = File::model()->findAllByAttributes(array('text_id'=>$model->text_id), array('order'=>'text_id, format_id'));
	$text_id = 0;
	$format_id = 0; 
    foreach ($files as $model) {
    	if ($text_id != $model->text_id){
    		$text_id = $model->text_id;
    		$textName = Text::model()->findByPk($text_id)->title;
    		echo "Files for text: $textName <br/>";
    	}
    	if ($format_id != $model->format_id){
    		$format_id = $model->format_id;
    		$format = Format::model()->findByPk($format_id)->name;
    		echo "Files for format: $format <br/>";
    	}
    	echo CHtml::link("$model->name, ", array('file/download', 'name'=>$model->name, 'text_id'=>$model->text_id, 'download'=>'true'),
	      array('class'=>'donwload_link')
	   );
	   echo '<br/>';
    }

?>
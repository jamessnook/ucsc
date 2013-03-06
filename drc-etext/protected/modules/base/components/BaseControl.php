<?php
/**
 * Base Control for forms class file.
 * @author J Snook <jsnook@ucsc.edu>
 * @package xx.widgets
 */

Yii::import('zii.widgets.CWidget');

class BaseControl extends CWidget
{
	/**
	 * Control Content
	 * optional, the content of this attribute is echoed as the box content
	 * @var string
	 */
	public $content = '';
	/**
	 * control content HTML additional attributes
	 * @var array
	 */
	public $htmlContentDefaultOptions = array('class'=>"input-xxlarge",'maxlength'=>63);
	
	/**
	 * control content HTML additional attributes
	 * @var array
	 */
	public $htmlContentOptions = array();
	
	/**
	 * Form Content
	 * optional, the content of this attribute is echoed as the box content
	 * @var string
	 */
	public $model = '';
	
	/**
	 * Form object thois control goes in
	 * optional, the content of this attribute is echoed as the box content
	 * @var string
	 */
	public $model = '';
	
	/**
	 * Control HTML additional attributes
	 * @var array
	 */
	public $htmlOptions = array();
	
	/**
	 * Control name
	 * @var array
	 */
	public $name = '';
	
	/**
	 * Control type
	 * @var array
	 */
	public $type = null;
	
	public function init()
	{
		parent::init();
		$htmlContentOptions = array_merge($htmlContentDefaultOptions, $htmlContentOptions);
	}
	
	/**
	 * Runs the widget.
	 */
	public function run()
	{
		echo '<div class="control-group">';
		 	echo $form->labelEx($this->model, $this->name); 
			echo '<div class="controls"> ';
				if ($type){
					echo $form->$type($this->model, $this->name, $this->$htmlContentOptions); 
				}
				$this->displayContent();
				echo $form->error($this->model, $this->name); 
			echo '</div>';
		echo '</div>';
	}
	
	/**
	 * Puts contetn in the middle of the widget, override in subclass.
	 */
	public function displayContent()
	{
		echo '';
	}
	
	
}

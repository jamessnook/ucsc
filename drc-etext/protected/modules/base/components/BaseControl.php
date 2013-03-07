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
	 * Form Model
	 * The data model object for the form content
	 * @var string
	 */
	public $model = null;
	
	/**
	 * Form object this control goes in
	 * @var string
	 */
	public $form = '';
	
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
		 	echo $this->form->labelEx($this->model, $this->name); 
			echo '<div class="controls"> ';
				if ($type){
					echo $this->form->$type($this->model, $this->name, $this->$htmlContentOptions); 
				}
				$this->displayContent();
				echo $this->form->error($this->model, $this->name); 
			echo '</div>';
		echo '</div>';
	}
	
	/**
	 * Puts content in the middle of the widget, override in subclass.
	 */
	public function displayContent()
	{
		echo '';
	}
	
	
}

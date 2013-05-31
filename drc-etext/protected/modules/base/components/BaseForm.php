<?php
/**
 * TabMenu class file.
 * @author J Snook <jsnook@ucsc.edu>
 * @package xx.widgets
 */

//Yii::import('zii.widgets.CMenu');

class BaseForm extends CActiveForm
{
	/**
	 * Form Content
	 * optional, the content of this form
	 * @var string
	 */
	public $contentHTML = '';
	
	/**
	 * Form Content
	 * optional, the content of this form
	 * @var string
	 */
	public $widgetClass = null;
	
	/**
	 * Form Content
	 * optional, the content of this form
	 * @var string
	 */
	public $widgetProperties = array();
	
	/**
	 * Form Content
	 * optional, the content of this form
	 * @var string
	 */
	public $widgets = array();
	
	/**
	 * box content HTML additional attributes
	 * @var array
	 */
	public $htmlContentOptions = array();
	
	/**
	 * Form Model
	 * The data model object for the form content
	 * @var string
	 */
	public $model = null;
	
	public function init()
	{
		$this->htmlOptions = array('enctype' => 'multipart/form-data'); 
		$this->enableAjaxValidation = false; 
		parent::init();
		echo '<form class="" action="request-edit.html">';
		echo '<fieldset> ';
   		echo $this->errorSummary($this->model); 
		foreach ($this->widgets as $wConf ){
			$this->widget($wConf['className'], $wConf);
			//$this->controller->widget($wConf['className'], $wConf);
		}
	}
	
	/**
	 * Runs the widget.
	 */
	public function run()
	{
		$this->displayContent();
		echo '</fieldset>';
		echo '</form>';
		parent::run();
	}
	
	/**
	 * Puts contetn in the middle of the widget, override in subclass.
	 */
	public function displayContent()
	{
		echo $this->contentHTML;
	}
	
	/**
	 * Creates and outputs input row of a specific type.
	 * @param string $name (id) the input element, used to look up labels in model
	 * @param string $type the input type
	 * @param array $htmlOptions additional HTML attributes
	 */
	public function controlRow($name, $type, $htmlOptions = array())
	{
		$this->controller->widget('BaseControl', array( 'name' => $name, 'type' => $type, 'model'=>$this->model, 'form'=>$this, 'htmlContentOptions'=>$htmlOptions));
	}

	/*
	  * Renders the opening of the content element and the optional content
	  */
	/*
	public function renderContentBegin()
	{
		echo CHtml::openTag('div', $this->htmlContentOptions);
		if (!empty($this->content))
			echo $this->content;
	}
	*/
	/*
	 * Closes the content element
	 */
	/*
	public function renderContentEnd()
	{
		echo CHtml::closeTag('div');
	}
	*/
}

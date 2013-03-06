<?php
/**
 * TabMenu class file.
 * @author J Snook <jsnook@ucsc.edu>
 * @package xx.widgets
 */

Yii::import('zii.widgets.CMenu');

class BaseForm extends CActiveForm
{
	/**
	 * Form Content
	 * optional, the content of this attribute is echoed as the box content
	 * @var string
	 */
	public $content = '';
	/**
	 * box content HTML additional attributes
	 * @var array
	 */
	public $htmlContentOptions = array();
	
	public function init()
	{
		parent::init();
		$this->htmlOptions = array('enctype' => 'multipart/form-data'); 
		$this->enableAjaxValidation = false; 
		$this->id = 'assignment-form';
		$this->action = $action;
	}
	
	/**
	 * Runs the widget.
	 */
	public function run()
	{
		echo '<form class="" action="request-edit.html">';
			echo '<fieldset> ';
				$this->displayContent();
			echo '</fieldset>';
		echo '</form>';
	}
	
	/**
	 * Puts contetn in the middle of the widget, override in subclass.
	 */
	public function displayContent()
	{
		echo $this->content;
	}
	
	/*
	  * Renders the opening of the content element and the optional content
	  */
	public function renderContentBegin()
	{
		echo CHtml::openTag('div', $this->htmlContentOptions);
		if (!empty($this->content))
			echo $this->content;
	}

	/*
	 * Closes the content element
	 */
	public function renderContentEnd()
	{
		echo CHtml::closeTag('div');
	}
	
}

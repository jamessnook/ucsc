<?php
/**
 * TabMenu class file.
 * @author J Snook <jsnook@ucsc.edu>
 * @package xx.widgets
 */

Yii::import('zii.widgets.CMenu');

class BasePage extends CWidget
{
	/**
	 * Page title
	 * optional, the title of this page
	 * @var string
	 */
	public $title = null;
	
	/**
	 * Form Content
	 * optional, the content of this form
	 * @var string
	 */
	public $contentHTML = '';
	
	/**
	 * box content HTML additional attributes
	 * @var array
	 */
	public $htmlOptions = array();
	
	/**
	 * Form Model
	 * The data model object for the form content
	 * @var string
	 */
	public $model = null;
	
	public function init()
	{
		parent::init();
		echo CHtml::openTag('div', $this->htmlOptions);
		echo '<div class="row-fluid"> <div class="span12">';
        if ($this->title){ 
			echo '<h2><?php echo $title; ?></h2><br />';
		}
	}
	
	/**
	 * Runs the widget.
	 */
	public function run()
	{
		$this->displayContent();
		echo '</div></div></div>';
	}
	
	/**
	 * Puts contetn in the middle of the widget, override in subclass.
	 */
	public function displayContent()
	{
		echo $this->contentHTML;
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

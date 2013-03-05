<?php
/**
 * TabMenu class file.
 * @author J Snook <jsnook@ucsc.edu>
 * @package xx.widgets
 */

Yii::import('zii.widgets.CMenu');

class TabMenu extends CMenu
{
	public function init()
	{
		$this->htmlOptions = array('class'=>'nav nav-tabs'); 
		$this->submenuHtmlOptions = array('class'=>'dropdown-menu'); 
		$this->encodeLabel = false;
		parent::init();
	}
}

<?php

class BaseModule extends CWebModule
{
	/**
	 * @var object
	 * @desc holds methods and attributes for dynamic configuration
	 */
	public $dynamicConfig;
	
	/**
	 * @var cwidget
	 * @desc defines the top nav tab menu
	 */
	public $tabMenu;
	
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'base.models.*',
			'base.components.*',
		));
		
		if (!$tabMenu){
			$tabMenu = new TabMenu;
		}
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}

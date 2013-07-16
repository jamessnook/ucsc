<?php

class BaseModule extends CWebModule
{
	/**
	 * @var object
	 * @desc holds methods and attributes for dynamic configuration
	 */
	public $dynamicConfig;
	
    private $_assetsUrl;
 

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'base.models.*',
			'base.components.*',
		));
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

    // getAssetsUrl()
    //    return the URL for this module's assets, performing the publish operation
    //    the first time, and caching the result for subsequent use.
    public function getAssetsUrl()
    {
        if ($this->_assetsUrl === null)
            $this->_assetsUrl = Yii::app()->getAssetManager()->publish(
                Yii::getPathOfAlias('base.assets') );
        return $this->_assetsUrl;
    }
}

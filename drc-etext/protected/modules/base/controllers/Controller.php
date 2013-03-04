<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 * 
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.components
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the views.  Set to use file with no layout.
	 * Layout is instead provided by //layouts/_main which is container for all views in this app.
	 * This is done so parameters can be passed to the layout without modifying standard Yii classes.
	 */
	public $layout='//layouts/noLayout';
	
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	/**
	 * @var array view config items.
	 */
	public $viewOptions = array();
	
	/**
	 * @var UCSCModel default model object for this controller, used for most views.
	 */
	public $_model;
	
	/**
	 * @var UCSCModel contained data model object for this controller, used for content in an inner section of the view.
	 * If not set the data in $_model will be used for all content.
	 */
	public $_contentModel;
		
	/**
	 * A generic entry point for very similar actions.
	 * Not currently used this is an laternative approach 
	 * where the view to use (and other configuration) can be specified in the request parameters.
	 */
	public function actionIndex()
	{
		$view = 'index';
		$content = null;
		if(isset($_GET['view']))
			$view = $_GET['view'];
		//$className = ucfirst($this->id);
		//$model = $className::loadModel();
		// get optional content model for internal part of view
		if (isset($_GET['content'])){
			$className = ucfirst($_GET['content']);
			if (class_exists($className)){
				$content = $className::loadModel();
			}
		}
		// pass model data and render the view file
		$this->render($view,array(
			'model'=>$this->model,
			'contentModel' => $content,
		));
	}

	/**
	 * Renders a view defined by the configuration in the $options array.
	 * the layouts/main and layouts/_main views are containers for the view.
	 * The specific contained view file to use is defined by the contentView
	 * option.
	 */
	public function renderView($options=array())
	{
		$this->setDefaultViewOptions();
		$this->viewOptions = array_merge ( $this->viewOptions, $options ); // note $options overide defaults
		$this->viewOptions['model'] = $this->model;  // for convenience of access
		$this->viewOptions['contentModel'] = $this->contentModel;  // for convenience of access
		$this->viewOptions['tabMenu'] = Yii::app()->getModule("base")->tabMenu;
		$this->render($this->viewOptions['mainView'], $this->viewOptions);
	}
	
	/**
	 * does, override in subclass as needed.
	 */
	public function setDefaultViewOptions()
	{
		// default assumes use of base app module
		$this->viewOptions['tabMenu'] = Yii::app()->getModule("base")->tabMenu;
		$this->viewOptions['mainView'] = 'base.views.layouts._main';
	}
	
	/**
	 * Returns the model for this controller.
	 * Creates model if not yet set.
	 */
	public function getModel()
	{
		if (!$this->_model){
			$className = ucfirst($this->id);
			$this->_model = $className::loadModel();
		}
		return $this->_model;
	}
	
	/**
	 * Assigns model object.
	 */
	public function setModel($model)
	{
		$this->_model = $model;
	}

	/**
	 * Returns content model for this controller.
	 * This is the model for the inner or contained view.
	 * If not set the $this->model model will be used for all content
	 * Creates model if not yet sets.
	 */
	public function getContentModel()
	{
		if (!$this->_contentModel){
			// get optional content model for internal part of view
			if (isset($_GET['content'])){
				$className = ucfirst($_GET['content']);
				if (class_exists($className)){
					$content = $className::loadModel();
				}
			}
		}
		return $this->_contentModel;
	}
	
	/**
	 * Assigns content model object.
	 */
	public function setContentModel($model)
	{
		$this->_contentModel = $model;
	}
	

}
<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array layout config items.
	 */
	public $layoutOptions=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	public $viewOptions = array();
	public $model;
	public $contentModel;
		
	/**
	 * A generic entry point for very similar actions.
	 */
	public function actionIndex()
	{
		$view = 'index';
		$content = null;
		if(isset($_GET['view']))
			$view = $_GET['view'];
		$className = ucfirst($this->id);
		$model = $className::loadModel();
		// get optional content model for internal part of view
		if (isset($_GET['content'])){
			$className = ucfirst($_GET['content']);
			if (class_exists($className)){
				$content = $className::loadModel();
			}
		}
		// pass model data and render the view file
		$this->render($view,array(
			'model'=>$model,
			'contentModel' => $content,
		));
	}

	/**
	 * Add setting of default view options to render.
	 */
	public function renderView($options=array())
	{
		if (!$this->model){
			$className = ucfirst($this->id);
			$this->model = $className::loadModel();
		}
		$this->render('../layouts/_main',array(
			'options'=>$options,
			'model'=>$this->model,
		));
	}
	
	/**
	 * Add setting of default view options to render.
	 */
	public function render( $view, $params=array())
	{
		$this->setDefaultViewOptions($params['model']);
		parent::render($view,$params);
	}
	
	/**
	 * does nothing, override in subclass.
	 */
	public function setDefaultViewOptions($model)
	{
	}
	
}
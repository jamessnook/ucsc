<?php
/**
 * XMLUpdater handels calls to XML services to retreive data and updatelocal datastores.
 */
class XMLUpdater extends CController
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
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	/**
	 * Authenticates a user
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
    public function update()
    {
    	// call service to get data
    	
    	// parse XML and create objects
    	
    	// iterate on objects and update appropriate model
    		// fore each create new  look up call simple xml constructor -update...
    }
}
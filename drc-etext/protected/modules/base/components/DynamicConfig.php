<?php
/**
 * XMLUpdater handels calls to XML services to retreive data and update local datastores.
 * 
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.components
 */
class DynamicConfig extends CApplicationComponent
{
	
	/**
	 * Returns top nav CMenu items for this application.
	 */
	public function getTopNavItems()
	{
		return array(
			array(
				'label'=>'<i class="icon-dashboard"></i> Dashboard', 
				'url'=>array('/site/about'), 
				'visible'=>false,
			),
			array(
				'label'=>'<i class="icon-wrench"></i> Reports', 
				'url'=>array('/course/courses'), 
				'itemOptions'=>array('class'=>'pull-right'), 
				'visible'=>Yii::app()->user->checkAccess('admin'),
				'active'=> false,  // disable for now
				'visible'=>false,
			),
			array(
				'itemOptions'=>array('class'=>'dropdown pull-right'), 
				'url'=>'#',
				'linkOptions'=>array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown'), 
				'label'=>'<i class="icon-user"></i> Users <b class="caret"></b>', 
				'visible'=>Yii::app()->user->checkAccess('admin'), 
				'active'=>Yii::app()->controller->id == 'User',
				'items'=>array(
					array(
						'label'=>'Students', 
						'url'=>array('user/students', 'term_code'=>Yii::app()->controller->model->term_code,),
					),
					array(
						'label'=>'Faculty', 
						'url'=>array('user/faculty', 'term_code'=>Yii::app()->controller->model->term_code,), 
					),
					array(
						'label'=>'Staff', 
						'url'=>array('user/staff', 'term_code'=>Yii::app()->controller->model->term_code,), 
					),
				),
			),
		);
	}	
}
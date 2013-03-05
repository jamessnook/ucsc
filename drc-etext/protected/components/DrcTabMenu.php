<?php
/**
 * DrcTabMenu class file.
 * @author J Snook <jsnook@ucsc.edu>
 * @package xx.widgets
 */

Yii::import('zii.widgets.CMenu');

class DrcTabMenu extends TabMenu
{
	public function init()
	{
		parent::init();
		$this->items = array(
			array(
				'label'=>'<i class="icon-dashboard"></i> Dashboard', 
				'url'=>array('/site/about'), 
				'visible'=>false,
			),
			array(
				'itemOptions'=>array('class'=>'dropdown pull-right'), 
				'url'=>'#',
				'linkOptions'=>array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown'), 
				'label'=>'<i class="icon-user"></i> Users <b class="caret"></b>', 
				'visible'=>Yii::app()->user->checkAccess('admin'), 
				'active'=>Yii::app()->controller->id == 'DrcUser',
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

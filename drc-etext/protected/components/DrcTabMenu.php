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
		$this->items = array(
			array(
				'label'=>'<i class="icon-dashboard"></i> Dashboard', 
				'url'=>array('/site/about'), 
				'visible'=>false,
			),
			array(
				'label'=>'Courses', 
				'url'=>array('/course/courses', 
				'term_code'=>Yii::app()->controller->model->term_code, ), 
				'active'=> Yii::app()->controller->id == 'Course',
			),
			array(
				'label'=>'Assignments', 
				'url'=>array('/assignment/manage', 
					'term_code'=>Yii::app()->controller->model->term_code,), 
				'visible'=>Yii::app()->user->checkAccess('admin'),
				'active'=> Yii::app()->controller->id == 'Assignment',
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
				'active'=>Yii::app()->controller->id == 'DrcUser',
				'items'=>array(
					array(
						'label'=>'Students', 
						'url'=>array('/drcUser/students', 'term_code'=>Yii::app()->controller->model->term_code,),
					),
					array(
						'label'=>'Faculty', 
						'url'=>array('/drcUser/faculty', 'term_code'=>Yii::app()->controller->model->term_code,), 
					),
					array(
						'label'=>'Staff', 
						'url'=>array('/drcUser/staff', 'term_code'=>Yii::app()->controller->model->term_code,), 
					),
				),
			),
		);
		// normalize items
		parent::init();
	}
	
}

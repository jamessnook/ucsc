<?php
/**
 * DrcTabMenu class file.
 * @author J Snook <jsnook@ucsc.edu>
 * @package xx.widgets
 */

Yii::import('zii.widgets.CMenu');

class DrcTabMenu extends TabMenu
{
	/**
	 * @var integer the term code used for urls for emnu options
	 * Defaults to null,
	 */
	public $termCode;
	
	public function init()
	{
		if (!$this->termCode &&  isset(Yii::app()->controller->model->term_code)){
			$this->termCode = Yii::app()->controller->model->term_code;
		} else {
			$this->termCode = Term::currentTermCode();
		}
		if (Yii::app()->user->checkAccess('admin')){
			$coursesUrl = array('/course/courses', 'term_code'=>$this->termCode, );
		} else {
			$coursesUrl = array('/drcUser/courses', 'term_code'=>$this->termCode, 'username'=>Yii::app()->user->name, );
					}
		$this->items = array(
			array(
				'label'=>'<i class="icon-dashboard"></i> Dashboard', 
				'url'=>array('/site/about'), 
				'visible'=>false,
			),
			array(
				'label'=>'Courses', 
				'url'=>$coursesUrl, 
				'active'=> Yii::app()->controller->id == 'course',
			),
			array(
				'label'=>'Assignments', 
				'url'=>array('/assignment/manage', 
				'term_code'=>$this->termCode,), 
				'visible'=>Yii::app()->user->checkAccess('admin'),
				'active'=> Yii::app()->controller->id == 'assignment',
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
				'active'=>Yii::app()->controller->id == 'drcUser',
				'items'=>array(
					array(
						'label'=>'Students', 
						'url'=>array('/drcUser/students', 'term_code'=>$this->termCode,),
					),
					array(
						'label'=>'Faculty', 
						'url'=>array('/drcUser/faculty', 'term_code'=>$this->termCode,), 
					),
					array(
						'label'=>'Staff', 
						'url'=>array('/drcUser/staff', 'term_code'=>$this->termCode,), 
					),
				),
			),
		);
		// normalize items
		parent::init();
	}
	
}

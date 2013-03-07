<?php
/**
 * UerEditFOrm class file.
 * @author J Snook <jsnook@ucsc.edu>
 * @package xx.widgets
 */

//Yii::import('zii.widgets.CActiveForm');

class UserEditForm extends BaseForm
{
	public function init()
	{
		$this->id = 'user-edit-form';
		$this->widgets = array(
			/*
			'username'=>array( 'className' => 'BaseControl', 'type' => 'textField',	),
			'first_name'=>array( 'className' => 'BaseControl', 'type' => 'textField',	),
			'last_name'=>array( 'className' => 'BaseControl', 'type' => 'textField',	),
			'email'=>array( 'className' => 'BaseControl', 'type' => 'textField',	),
			'phone'=>array( 'className' => 'BaseControl', 'type' => 'textField',	),
			*/
		);
		parent::init();
		$this->controller->widget('BaseControl', array( 'name' => 'username', 'type' => 'textField', 'model'=>$this->model, 'form'=>$this, ));
		$this->controller->widget('BaseControl', array( 'name' => 'first_name', 'type' => 'textField', 'model'=>$this->model, 'form'=>$this,));
		$this->controller->widget('BaseControl', array( 'name' => 'last_name', 'type' => 'textField', 'model'=>$this->model, 'form'=>$this, 'htmlContentOptions'=>array('maxlength'=>127)));
		$this->controller->widget('BaseControl', array( 'name' => 'email', 'type' => 'textField', 'model'=>$this->model, 'form'=>$this, 'htmlContentOptions'=>array('maxlength'=>127)));
		$this->controller->widget('BaseControl', array( 'name' => 'phone', 'type' => 'textField', 'model'=>$this->model, 'form'=>$this,));
		echo ' <div class="control-group">';
        echo CHtml::label('Role', 'role');
        echo '<div class="controls">';
				
		$username = $this->model->username;
        $userRoles = Yii::app()->authManager->getRoles($username);
        $selected = key($userRoles);
        //if (!$username) $selected = rtrim($activeTab, 's');
        if (!$username) $selected = 'staff';
        $options = array();
        $roles = array_keys (Yii::app()->authManager->getRoles());
        foreach ($roles as $role){
        	$options[$role]=$role;
        }
        echo CHtml::dropDownList('role', $selected, $options);

        echo '</div>';
        echo '</div>';

        echo '<div class="form-actions">';
          
		echo CHtml::submitButton($this->model->isNewRecord ? 'Create' : 'Save', array( 'class'=>"btn btn-primary" ));
		echo CHtml::button('Cancel', array( 'class'=>"btn", 'onclick'=> "history.back()" )); 
            
        echo '</div>';
		
	}
	
	
}

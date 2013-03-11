<?php
/**
 * UerEditFOrm class file.
 * @author J Snook <jsnook@ucsc.edu>
 * @package xx.widgets
 */

//Yii::import('zii.widgets.CActiveForm');

class FileEditForm extends BaseForm
{
	public function init()
	{
		$this->id = 'file-edit-form';
		parent::init();
		$this->controlRow('name', 'textField', array());
		$this->controlRow('title', 'textField', array());
		$this->controlRow('label', 'textField', array());
		$this->controlRow('description', 'textArea', array());
		/*
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
		*/
		echo $this->hiddenField($this->model,'type'); 
		 
        echo '<div class="form-actions">';
          
		echo CHtml::submitButton('Save Changes', array( 'class'=>"btn btn-primary" ));
		echo CHtml::button('Cancel', array( 'class'=>"btn", 'onclick'=> "history.back()" )); 
            
        echo '</div>';
		
	}
	
	
}

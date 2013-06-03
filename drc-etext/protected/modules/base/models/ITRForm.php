<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ITRForm extends CFormModel
{
	public $message;
	public $returnUrl;
	
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// message is required
			array('message', 'required'),
			array('returnUrl', 'required'),
			);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'message'=>'Report your problem:',
		);
	}

	/**
	 * Initializes return Url
	 */
	protected function afterConstruct(){
		$this->returnUrl = Yii::app()->request->urlReferrer;
		parent::afterConstruct();
	}
	
	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether create of itr is successful
	 */
	public function createITR()
	{
		return true;
		if (Yii::app()->email->send('createITR@email.address','jsnook@ucsc.edu','Test Email for: ','message') != 1){
			throw new CHttpException(404,'ERROR could not send e-mail to create ITR.'); // temporary error code
			return false;
		}
		return true;
	}
}

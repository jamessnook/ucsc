<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 * 
 * @author JSnook <jsnook@ucsc.edu>
 * @package drc-etext.protected.components
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
    public function authenticate()
    {
        $username=strtolower($this->username);
        $user=User::model()->find('LOWER(username)=?',array($username));
        if($user===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else
        {
            $this->username=$user->username;
            $this->errorCode=self::ERROR_NONE;
        }
	    return $this->errorCode==self::ERROR_NONE;
    }
 
}

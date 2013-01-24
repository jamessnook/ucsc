<?php
/**
 * CloudDbConnection add dynamic database configuration on clud hosts.
 * 
 * @author JSnook <jsnook@ucsc.edu>
 * @copyright Copyright &copy; 2012 University of California, Santa Cruz
 * @package drc-etext.protected.components
 */
class CloudDbConnection extends CDbConnection
{

	public $dbName=0;
	
	/**
	 * Override parent method to provide needed initialization.
	 */
	public function init()
	{
		parent::init();
		// check for appFog dynamic database config
		if ($dbEnv = getenv("VCAP_SERVICES") && isset(Yii::app()->db->connectionString) && stripos(Yii::app()->db->connectionString, 'mysql') !== false){
			$services_json = json_decode($dbEnv,true);
			$mysql_config = $services_json["mysql-5.1"][$dbName]["credentials"];
			$this->username = $mysql_config["username"];
			$this->password = $mysql_config["password"];
			$hostname = $mysql_config["hostname"];
			//$port = $mysql_config["port"];
			$db = $mysql_config["name"];
			$this->connectionString = "mysql:host=$hostname;dbname=$db";
		}
	}
	
}
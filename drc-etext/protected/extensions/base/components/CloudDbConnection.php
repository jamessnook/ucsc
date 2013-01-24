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

	public $serviceName='db';
	
	/**
	 * Override parent method to provide needed initialization.
	 */
	public function init()
	{
		// check for appFog dynamic database config
		//if ($dbEnv = getenv("VCAP_SERVICES") && isset(Yii::app()->db->connectionString) && stripos(Yii::app()->db->connectionString, 'mysql') !== false){
		if ($dbEnv = getenv("VCAP_SERVICES")){
			$services_json = json_decode($dbEnv,true);
			foreach($services_json["mysql-5.1"] as $service){
				if ($service['name'] == $this->serviceName){
					$mysql_config = $service["credentials"];
					$this->username = $mysql_config["username"];
					$this->password = $mysql_config["password"];
					$hostname = $mysql_config["hostname"];
					$db = $mysql_config["name"];
					$this->connectionString = "mysql:host=$hostname;dbname=$db";
					parent::init();
					return;
				}
			}
		}
		parent::init();
	}
	
}
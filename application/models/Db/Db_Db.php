<?php
/**
 * Database handler
 */
class Db_Db
{
	public static function conn(){
		$connParams = array(
			"host"=>"localhost",
			"port"=>"3306",
			"username"=>"loudbite",
			"password"=>"sFu7sndxDDpXsq4B",
			"dbname"=>"loudbite"
		);
		$db = new Zend_Db_Adapter_Pdo_Mysql($connParams);
		return $db;
	}
}

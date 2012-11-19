<?php
class Application_Model_Auto extends Zend_Db_Table
{
	/**
	 * Author Fabio Bottan
	 *
	 * @_name Db Table's name
	 * @_primary Table's primary key
	 */
	protected $_name = 'auto';
	protected $_primary = 'Id_Auto';
	
	protected  $_data = array(
				"Marca" => "",
				"Modello" => "",
				"Colore" => "",
			    "Prezzo" => 0,
				"Anno" => 0
			);
	
	public function __construct($config = array(), $definition = null) {

		parent::__construct();

		$this->_data = array_merge($this->_data, $config);
		
	}
	
	public function insertAuto(){
		$this->insert($this->_data);
	}
	public function buyAuto(){
		$db = new Zend_Db_Table("auto_user");
		$query = $db->insert(array("Id_Auto" => $this->_data["Id_Auto"],
							"Id_User" => Application_Model_User::isLogged()));
	}
	
	public function assicuraAuto(){
		$db = new Zend_Db_Table("insurance");
		$query = $db->insert(array("Id_Auto" => $this->_data["Id_Auto"],
				"Id_User" => Application_Model_User::isLogged()));
	}
	/***
	 * Sell a car!
	 * This method delete a car from auto_user and insurance tables
	 */
	public function vendiAuto(){
		//Delete from auto_user table
		$db = new Zend_Db_Table("auto_user");
		$where = $db->getAdapter()->quoteInto("Id_Auto = ?", $this->_data["Id_Auto"]);
		$db->delete($where);
		//Delete from insurace table
		$db = new Zend_Db_Table("insurance");
		$db->delete($where);
	}
	
	static function getAllAuto(){
		$db = new Application_Model_Auto();
		$table2 = new Zend_Db_Table("auto_user");
		$query = $db->select()->where("Id_Auto NOT IN ?", 
											$table2->select()->
											from("auto_user", array("auto_user.Id_Auto")));
		$rows = $db->fetchAll($query);
		return Application_Model_Auto::getAllAutoFormat($rows);
	}
	static function getAuto($id_auto){
		$db = new Zend_Db_Table("auto");
		$row = $db->find($id_auto);
		$row = $row->toArray();
		$auto = new Application_Model_Auto($row[0]);
		return $auto;
	}
	static function getYears(){
		$keys = array();
		$values = array();
		$array = array();
		for($i = 1999; $i < 2013; $i++)
		{
			array_push($keys, $i);
			array_push($values, $i);
		}
		$array = array_combine($keys, $values);
		return $array;
	}
	
	static function getAllAutoFormat($rows){
		$keys = array();
		$values = array();
		foreach ($rows as $row)
		{
			array_push($keys, $row["Id_Auto"]);
			array_push($values, implode(" ", array($row["Marca"], $row["Modello"], $row["Anno"])));
		}
		return array_combine($keys, $values);
	}
}
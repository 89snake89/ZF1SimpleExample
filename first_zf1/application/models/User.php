<?php

class Application_Model_User extends Zend_Db_Table
{
	/**
	 * Author Fabio Bottan
	 * 
	 * @_name Db Table's name
	 * @_primary Table's primary key
	 */
	protected $_name = 'User';
	protected $_primary = 'Id_User';
	
	protected $_data = array(
			"Id_User" => null,
			"Mail" => "",
			"Psw" => "",
			"Nome" => "",
			"Cognome" => "",
			"Sesso" => "",
			"Tipo_Patente" => ""
	);
	
	public function __construct($config = array(), $definition = null) {

		parent::__construct();
		
		$config["Psw"] = sha1($config["Psw"]);
		$this->_data = array_merge($this->_data, $config);
		
	}
	/**
	 * La mail inserita è già presente?
	 * @return boolean
	 */
	public function exists(){
		$query = $this->select()
			->where("Mail = ?", $this->_data["Mail"]);
		
		$row = $this->fetchRow($query);
		
		return ($row) ? true : false;
	}
	
	public function save(){
		$this->insert($this->_data);
	}

	static function getUserById($id){
		$db = new Zend_Db_Table("user");
		$row = $db->find($id);
		$row = $row->toArray();
		$user = new Application_Model_User($row[0]);
		$user->_data["Psw"] = $row[0]["Psw"];
		return $user;
	}	
	public function getFullName(){
		if(isset($this->_data["Nome"]) && isset($this->_data["Cognome"]))
		{
			return implode(" ", array($this->_data["Nome"], $this->_data["Cognome"]));
		}
		else
		{
			return false;
		}
	}
	public function getMail(){
		if(isset($this->_data["Mail"]))
		{
			return $this->_data["Mail"];
		}
		else
		{
			return false;
		}
	}
	public function getId(){
		if(isset($this->_data["Id_User"]))
		{
			return $this->_data["Id_User"];
		}
		else
		{
			return false;
		}
	}
	public function getPsw(){
		if(isset($this->_data["Psw"]))
		{
			return $this->_data["Psw"];
		}
		else
		{
			return false;
		}
	}
	public function LogIn($mail, $psw){
		$query = $this->select()
				->where("Mail = ?", $this->_data["Mail"])
				->where("Psw = ?", $this->_data["Psw"]);
		
		$row = $this->fetchRow($query);

		if($row){
			$_SESSION["id"] =(int)$row["Id_User"];
			return $_SESSION["id"];
		}else{
			return false;
		}
	}
	public function cambiaPsw($newPsw){		
		$query = $this->update(array("Psw" => $newPsw), array("Id_User = ?" => $this->_data["Id_User"]));
		return $query;
	}
	
	static function isLogged(){
		if(isset($_SESSION['id']) && $_SESSION['id']){
			return $_SESSION['id'];
		}
		else return false;
	}
	static function getMyCars($insur){
		$db = new Zend_Db_Table("auto");
		
		if($insur == false)
		{
			$query = $db
			->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
			->setIntegrityCheck(false)
			->joinLeft(array("au" =>"auto_user"), "au.Id_Auto = auto.Id_Auto", "")
			->where("au.Id_User = ?", Application_Model_User::isLogged());
			$rows = $db->fetchAll($query);
			return Application_Model_Auto::getAllAutoFormat($rows);
		}
		else
		{
			$table = new Zend_Db_Table("insurance");
			$query = $db
			->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
			->setIntegrityCheck(false)
			->joinLeft(array("au" =>"auto_user"), "au.Id_Auto = auto.Id_Auto", "")
			->where("au.Id_User = ?", Application_Model_User::isLogged())
			->where("auto.Id_Auto NOT IN ?", 
					$table->select()->from("insurance", array("insurance.Id_Auto")));
			//die($query);
			$rows = $db->fetchAll($query);
			return Application_Model_Auto::getAllAutoFormat($rows);
		}
		
	}
	public function  getAllUsers(){
		$query = $this->select()->where("Id_User != ?", Application_Model_User::isLogged());
		//die($query);
		$rows = $this->fetchAll($query);
		$nomi = array();
		$mail = array();
		foreach ($rows as $row){
			array_push($nomi, $row["Nome"]);
			array_push($mail, $row["Mail"]);
		}

		return array_combine($mail, $nomi);
	}
	public function getAllMessage($ricevuti){
		$db = new Zend_Db_Table("messages");
		$messages = array();
		if($ricevuti === true)
		{
			$query = $db->select()->where("Receiver = ?", Application_Model_User::isLogged());
			
			$rows = $db->fetchAll($query);
			$keys = array();
			$values = array();
			
			foreach ($rows as $row){
				array_push($keys, $row["Id_Mess"]);
				$user = Application_Model_User::getUserById($row["Sender"]);
				array_push($values, implode(" ", array("Da: " . $user->getFullName(),  $row["Message"])));
			}
			$messages = array_combine($keys, $values);
		}
		else
		{
			$query = $db->select()->where("Sender = ?", Application_Model_User::isLogged());
			
			$rows = $db->fetchAll($query);
			$keys = array();
			$values = array();
			
			foreach ($rows as $row){
				array_push($keys, $row["Id_Mess"]);
				$user = Application_Model_User::getUserById($row["Receiver"]);
				array_push($values, implode(" ", array("A: " . $user->getFullName(),  $row["Message"])));
			}
			$messages = array_combine($keys, $values);
		}
		return $messages;
	}
	public function getUserByMail(){
		$query = $this->select()->where("Mail = ?", $this->getMail());

		$row = $this->fetchRow($query);
		$row = $row->toArray();
		
		$user = new Application_Model_User($row);
		return $user;
	}
	static function logOff(){
		$_SESSION['id'] = false;
		session_destroy();
	}
}
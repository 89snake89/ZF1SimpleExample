<?php 
class Application_Model_Message
{
	protected $_data = array(
		"Mail" => "",
		"Sender" => 0,
		"Receiver" => 0,
		"Message" => "",
		"Date" => "",	
		"Hour" => ""	
	);
	
	function __construct($data = Array()){

		$this->_data['Date'] = date("Y-m-d");
		$this->_data["Hour"] = date("H:i:s");
		$this->_data["Sender"] = Application_Model_User::isLogged();
		$this->setData($data);		
	}
	public function setData($data = array()) {
		$this->_data = array_merge($this->_data, $data);
	}
	
	public function __set($name, $value){		
	}
    public function __get($name) {}
   
    public function insert(){
    	$data = array(
			"Id_User" => null,
			"Mail" => $this->getMail(),
			"Psw" => "",
			"Nome" => "",
			"Cognome" => "",
			"Sesso" => "",
			"Tipo_Patente" => ""
			);
	
    	$user = new Application_Model_User($data);
    	$user = $user->getUserByMail();
    	
    	$db = new Zend_Db_Table("messages");
    	$this->_data["Receiver"] = $user->getId();
    	
    	$newData = array_diff_key($this->_data, array("Mail" => ""));
    	$db->insert($newData);
    }
    public function getMail(){
    	if(!empty($this->_data["Mail"]))
    	{
    		return $this->_data["Mail"];
    	}
    	else
    	{
    		return null;
    	}	
    }
    
    public function getSender(){
    	if($this->_data["Sender"] != 0)
    	{
    		return $this->_data["Sender"];
    	}
    	else
    	{
    		return null;
    	}
    }
    
    public function getReceiver(){
    	if($this->_data["Sender"] != 0)
    	{
    		return $this->_data["Receiver"];
    	}
    	else
    	{
    		return null;
    	}
    }
    public function getMessage(){
    if(!empty($this->_data["Message"]))
    	{
    		return $this->_data["Message"];
    	}
    	else
    	{
    		return null;
    	}
    }
    public function send(){
    	$message = $this->_data["Message"];
    	$to = $this->_data["Mail"];
    	$subject = "";
   		return mail($to, $subject, $message);
    }
    
    public function getMessageById($id){
    	$db = new Zend_Db_Table("messages");
    	$message = $db->find($id);
    	$newMex = $message->toArray();
    	$message = new Application_Model_Message($newMex[0]);
    	return $message;
    }

}

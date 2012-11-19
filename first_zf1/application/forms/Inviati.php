<?php
 
class Application_Form_Inviati extends Zend_Form 
{
	
	
	public function init() {
		
		$this->setMethod("post");
		
		$usr = new Application_Model_User(array("Mail" =>"", "Psw" => ""));
		$select = new Zend_Form_Element_Select("Id_Mess");
		$select->setLabel("Mittente");
		ini_set("display_errors", 1);
		ini_set("error_reporting", E_ALL);
		$usr = Application_Model_User::getUserById(Application_Model_User::isLogged());
		$select->addMultiOptions($usr->getAllMessage($ricevuti = false));
		$this->addElement($select);
		
		
		$input = new Zend_Form_Element_Submit("submit_inviati");
		$input->setValue("Vedi_Inviato");
		$input->setLabel("Vedi");
		$this->addElement($input);
		
	}
}
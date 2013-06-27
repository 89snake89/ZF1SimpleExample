<?php
 
class Application_Form_Mail extends Zend_Form {
	
	
	public function init() {
		
		$this->setMethod("post");
		
		$usr = new Application_Model_User(array("Mail" =>"", "Psw" => ""));
		$select = new Zend_Form_Element_Select("Mail");
		$select->setLabel("Destinatario");
		ini_set("display_errors", 1);
		ini_set("error_reporting", E_ALL);
		$select->addMultiOptions($usr->getAllUsers());
		$this->addElement($select);
		
		$text = new Zend_Form_Element_Textarea("Message");
		$text->setLabel("Il tuo nome");
		$text->isRequired("true");
		$this->addElement($text);
		
		
		$input = new Zend_Form_Element_Submit("submit_invia");
		$input->setValue("Invia");
		$input->setLabel("Invia");
		$this->addElement($input);
		
	}
}
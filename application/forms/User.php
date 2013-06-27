<?php
 
class Application_Form_User extends Zend_Form {
	
	
	public function init() {
		
		$this->setMethod("post");
		$this->setAttrib('id', 'formIscriviti');
		
		$textNome = new Zend_Form_Element_text("Nome");
		$textNome->setLabel("Nome");
		$textNome->setRequired("true");
		$this->addElement($textNome);
		
		$textCognome = new Zend_Form_Element_Text("Cognome");
		$textCognome->setLabel("Cognome");
		$textCognome->setRequired("true");
		$this->addElement($textCognome);
		
		$textMail = new Zend_Form_Element_Text("Mail");
		$textMail->setLabel("E-Mail");
		$textMail->setRequired("true");
		$this->addElement($textMail);
		
		$textPsw = new Zend_Form_Element_Password("Psw");
		$textPsw->setLabel("Password");
		$textPsw->setRequired("true");
		$this->addElement($textPsw);
		
		$select = new Zend_Form_Element_Select("Tipo_Patente");
		$select->setLabel("Tipo Patente");
		ini_set("display_errors", 1);
		ini_set("error_reporting", E_ALL);
		$select->addMultiOptions(array(
				 				"A" => "A",
								"B" => "B",
								"C" => "C",
								"D" => "D",
								"BE" => "BE",
								"CE" => "CE",
								"DE" => "DE"));
		$this->addElement($select);
		
		$sex = new Zend_Form_Element_Radio("Sesso");
		$sex->addMultiOptions(array("M" => "M", "F" => "F"));
		$sex->setLabel("Sesso:");
		$this->addElement($sex);
				
		$input = new Zend_Form_Element_Submit("submit_iscriviti");
		$input->setValue("submit");
		$input->setLabel("Iscriviti");
		$this->addElement($input);
		
	}
}
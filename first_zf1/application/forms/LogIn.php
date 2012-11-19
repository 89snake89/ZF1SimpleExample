<?php
class Application_Form_LogIn extends Zend_Form
{
	public function init(){
		$this->setMethod("post");
		
		$textMail = new Zend_Form_Element_Text("Mail");
		$textMail->setLabel("E-Mail");
		$textMail->isRequired("true");
		$this->addElement($textMail);
		
		$textPsw = new Zend_Form_Element_Password("Psw");
		$textPsw->setLabel("Password");
		$textPsw->isRequired("true");
		$this->addElement($textPsw);
		
		$input = new Zend_Form_Element_Submit("submit_login");
		$input->setValue("submit");
		$input->setLabel("Entra");
		$this->addElement($input);
	}
}
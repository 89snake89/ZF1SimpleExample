<?php

class Application_Form_Cambiapsw extends Zend_Form
{
	public function init(){
		
		parent::init();
		
		$this->setMethod("post");
		
		$textVecchiaPsw = new Zend_Form_Element_Password("vecchia_psw");
		$textVecchiaPsw->setLabel("Vecchia password");
		$textVecchiaPsw->setRequired(true);
		
		$textVecchiaPsw->addValidator(new Zend_Validate_StringLength(4));
		
		$this->addElement($textVecchiaPsw);
		
		$textNuovaPsw = new Zend_Form_Element_Password("nuova_psw");
		$textNuovaPsw->setLabel("Nuova password");
		$textNuovaPsw->setRequired(true);
		
		$this->addElement($textNuovaPsw);
		
		$textConfermaPsw = new Zend_Form_Element_Password("conferma_psw");
		$textConfermaPsw->setLabel("Conferma password");
		$textConfermaPsw->setRequired(true);
		
		$this->addElement($textConfermaPsw, 'conferma_psw', 
							array('validators' => array('validator' => 'Identical', 
														'options' => 'nuova_psw')));
		
		$input = new Zend_Form_Element_Submit("cambia_psw");
		$input->setValue("cambia_psw");
		$input->setLabel("Cambia password");
		
		$this->addElement($input);
	}
}			

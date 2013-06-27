<?php

class Application_Form_Messaggio extends Zend_Form
{
	public function init(){
		$this->setMethod("post");
	}
	public function costruisci($id){
		$hidden = new Zend_Form_Element_Hidden("Id_Mess");
		$hidden->setValue($id);
		$this->addElement($hidden);
		
		
		$text = new Zend_Form_Element_Textarea("Message");
		$text->setLabel("Risposta");
		$text->isRequired("true");
		$this->addElement($text);
		
		$input = new Zend_Form_Element_Submit("submit_invia");
		$input->setValue("Invia");
		$input->setLabel("Rispondi");
		
		$this->addElement($input);
	}
}
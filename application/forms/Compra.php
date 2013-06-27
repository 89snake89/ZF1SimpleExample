<?php
class Application_Form_Compra extends Zend_Form
{
	public function init(){
		$selectAuto = new Zend_Form_Element_Select("Id_Auto");
		$selectAuto->setLabel("Auto");
		//Lda popolare con l'insieme delle auto in possesso
		$selectAuto->addMultiOptions(Application_Model_Auto::getAllAuto());
		$this->addElement($selectAuto);
	
		$input = new Zend_Form_Element_Submit("submit_compra");
		$input->setValue("submit");
		$input->setLabel("Compra subito!");
		$this->addElement($input);
	}
}
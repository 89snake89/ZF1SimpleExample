<?php
class Application_Form_Vendita extends Zend_Form
{
	public function init(){
		$selectAuto = new Zend_Form_Element_Select("Id_Auto");
		$selectAuto->setLabel("Auto");
		//Lda popolare con l'insieme delle auto in possesso
		$selectAuto->addMultiOptions(Application_Model_User::getMyCars(false));
		$this->addElement($selectAuto);
		
		$input = new Zend_Form_Element_Submit("submit_vendi");
		$input->setValue("submit");
		$input->setLabel("Vendi la vettura");
		$this->addElement($input);
	}
}
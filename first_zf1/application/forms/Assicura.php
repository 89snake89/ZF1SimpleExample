<?php
class Application_Form_Assicura extends Zend_Form
{
	public function init(){
		$selectAuto = new Zend_Form_Element_Select("Id_Auto");
		$selectAuto->setLabel("Assicurati");
		//Lda popolare con l'insieme delle auto in possesso
		$selectAuto->addMultiOptions(Application_Model_User::getMyCars(true));
		$this->addElement($selectAuto);
		
		$input = new Zend_Form_Element_Submit("submit_assicurati");
		$input->setValue("submit");
		$input->setLabel("Assicurati ora!");
		$this->addElement($input);
	}
}
<?php
class Application_Form_Auto extends Zend_Form
{
	public function init(){
		$textMarca = new Zend_Form_Element_Text("Marca");
		$textMarca->setLabel("Marca");
		$textMarca->isRequired(true);
		$this->addElement($textMarca);
		
		$textModello = new Zend_Form_Element_Text("Modello");
		$textModello->setLabel("Modello");
		$textModello->isRequired(true);
		$this->addElement($textModello);
		
		$textColore = new Zend_Form_Element_Text("Colore");
		$textColore->setLabel("Colore");
		$textColore->isRequired(false);
		$this->addElement($textColore);
		
		$textPrezzo = new Zend_Form_Element_Text("Prezzo");
		$textPrezzo->setLabel("Prezzo");
		$textPrezzo->isRequired(true);
		$this->addElement($textPrezzo);
		
		$selectAnno = new Zend_Form_Element_Select("Anno");
		$selectAnno->setLabel("Anno");
		$selectAnno->addMultiOptions(Application_Model_Auto::getYears());
		$this->addElement($selectAnno);
		
		$input = new Zend_Form_Element_Submit("submit_inserisci_auto");
		$input->setLabel("Inserisci");
		$input->setValue("submit");
		$this->addElement($input);
	}
}
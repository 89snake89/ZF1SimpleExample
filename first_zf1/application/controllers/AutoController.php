<?php
class AutoController extends Zend_Controller_Action
{
	public function init(){
		$this->_helper->layout()->setLayout('layoutuser');
	}
	public function indexAction(){
		$formInsertAuto = new Application_Form_Auto();
		$this->view->autoform = $formInsertAuto;
		if($this->getRequest()->isPost() && $formInsertAuto->isValid($this->_getAllParams()) && $this->hasParam("submit_inserisci_auto"))
		{
			$auto = new Application_Model_Auto($formInsertAuto->getValues());
			$auto->insertAuto();
		}
	}
	
}
<?php 
class MailController extends Zend_Controller_Action
{
	public function init(){
		
		/* Initialize action controller here */
	}
	public function indexAction(){		
		$this->_helper->layout()->setLayout('layoutprivate');
		$form = new Application_Form_Mail();
		$this->view->testForm = $form;
		
		if($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) 
		{
			$mex = new Application_Model_Message($form->getValues());
			//die($mex->getMail());
			if(!$mex->send())
			{
				echo "Errore!";
			}
			else
			{
				//Inserisci messaggio nel db
				$mex->insert();
			}
			$this->view->messaggio = $mex;
		}		
	}
}
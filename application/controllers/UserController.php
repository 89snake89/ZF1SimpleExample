<?php
class UserController extends Zend_Controller_Action
{

	public function init(){
	
	}
	public function indexAction(){
		$this->_helper->layout()->setLayout('layoutuser');		
		//$this->view->headScript()->appendFile('../views/JavaScript/jquery_validate.js');
		/*$this->_helper->actionStack('assicurati', "user", "default");
		$this->_helper->actionStack('vendi', "user", "default");
		$this->_helper->actionStack('compra', "user", "default");*/
	}

	public function iscrivitiAction(){
		$formUser = new Application_Form_User();
		$this->view->userform = $formUser;
		$this->view->inlineScript()->appendFile('/js/jquery_validate.js');
		if($this->getRequest()->isPost() && $formUser->isValid($this->_getAllParams()) && $this->hasParam("submit_iscriviti"))
		{
			$newUser = new Application_Model_User($formUser->getValues());
			$this->view->nuovoIscritto = $newUser->getFullName();
			
			if (!$newUser->exists()) {
				$newUser->save();
			} else {
				$this->view->error = "existing user!";
			}
		}	
	}
	public function loginAction(){
		$formlogin = new Application_Form_LogIn();
		$this->view->loginform = $formlogin;
		if($this->getRequest()->isPost() && $formlogin->isValid($this->_getAllParams()) && $this->hasParam("submit_login"))
		{
			//user::logIn;
			$userToLog = new Application_Model_User($formlogin->getValues());
			
			if($userToLog->LogIn($userToLog->getMail() , $userToLog->getPsw())){
				//OK
				//echo "Loggato";
				$this->_helper->layout()->setLayout('layoutuser');
					$this->forward("index");			
			}else{
				//Error
				echo "<h3>Non loggato</h3>";
			}
		}
	}
	
	public function cambiapswAction(){
		$this->_helper->layout()->setLayout('layoutprivate');
		$form = new Application_Form_Cambiapsw();
		
		$form->populate($this->_getAllParams());
		
		if ($this->getRequest()->isPost()) {
			if ($this->hasParam("cambia_psw") && $form->isValid($this->_getAllParams())) {
				$user = Application_Model_User::getUserById(Application_Model_User::isLogged());
					
				if(sha1($form->getValue("vecchia_psw")) == $user->getPsw()) {
					$user->cambiaPsw(sha1($form->getValue("nuova_psw")));
				} else {
					echo "Errore password errata";
				}
			} else {
				//Errori
				
			}
		} else {
			
			//Carico da database
			
			$form->populate(array("vecchia_psw" => 'walter'));
		}
		
		$this->view->form = $form;
	}
	
	public function vendiAction(){
		$this->_helper->layout()->setLayout('layoutuser');
		$formVendita = new Application_Form_Vendita();
		$this->view->vendiform = $formVendita;
		if($this->getRequest()->isPost() && $formVendita->isValid($this->_getAllParams()) && $this->hasParam("submit_vendi"))
		{
			$newAuto = Application_Model_Auto::getAuto($formVendita->getValue("Id_Auto"));
			$newAuto->vendiAuto();			
		}
	}
	public function assicuratiAction(){
		$this->_helper->layout()->setLayout('layoutuser');
		$formAssicura = new Application_Form_Assicura();
		$this->view->assicuraform = $formAssicura;
		if($this->getRequest()->isPost() && $formAssicura->isValid($this->_getAllParams()) && $this->hasParam("submit_assicurati"))
		{
			$this->_helper->layout()->setLayout('layoutuser');
			$newAuto = Application_Model_Auto::getAuto($formAssicura->getValue("Id_Auto"));
			$newAuto->assicuraAuto();
		}
	}
	public function compraAction(){
		$this->_helper->layout()->setLayout('layoutuser');
		$formCompra = new Application_Form_Compra();
		$this->view->compraform = $formCompra;
		if($this->getRequest()->isPost() && $formCompra->isValid($this->_getAllParams()) && $this->hasParam("submit_compra"))
		{
			$this->_helper->layout()->setLayout('layoutuser');
			$newAuto = Application_Model_Auto::getAuto($formCompra->getValue("Id_Auto"));
			$newAuto->buyAuto();
		}
	}
	
	/***
	 * Action relative ai messaggi.
	 */
	public function ricevutiAction(){
		$this->_helper->layout()->setLayout('layoutprivate');
		$formRicevuti = new Application_Form_Ricevuti();
		$this->view->form = $formRicevuti;
		if($this->getRequest()->isPost() && $formRicevuti->isValid($this->_getAllParams()))
		{
			//Cambio action per visualizzare il messaggio ed inviare un eventuale risposta.
			$this->forward('messaggio', null, null, array($formRicevuti->getValues()));	
		}
	}
	
	public function inviatiAction(){
		$this->_helper->layout()->setLayout('layoutprivate');
		$formInviati = new Application_Form_Inviati();
		$this->view->form = $formInviati;
		if($this->getRequest()->isPost() && $formInviati->isValid($this->_getAllParams()))
		{
			$data = array(
					"Mail" => "",
					"Sender" => 0,
					"Receiver" => 0,
					"Message" => "",
					"Date" => "",	
					"Hour" => ""
				);
			$mex = new Application_Model_Message($data);
			$mex = $mex->getMessageById($this->getParam("Id_Mess"));
			$this->view->destinatario = Application_Model_User::getUserById($mex->getReceiver())->getFullName();
			$this->view->messaggio = $mex->getMessage();
		}
	}
	
	public function messaggioAction(){
		$this->_helper->layout()->setLayout('layoutprivate');
		$data = array(
					"Mail" => "",
					"Sender" => 0,
					"Receiver" => 0,
					"Message" => "",
					"Date" => "",	
					"Hour" => ""
				);
		$mex = new Application_Model_Message($data);
		$mex = $mex->getMessageById($this->getParam("Id_Mess"));
		$mittente = Application_Model_User::getUserById($mex->getSender())->getFullName();
		$formMessaggio = new Application_Form_Messaggio();
		$formMessaggio->costruisci($this->getParam("Id_Mess"));
		$this->view->form = $formMessaggio;
		$this->view->mittente = $mittente;
		$this->view->messaggio = $mex->getMessage();
		if($this->getRequest()->isPost() && $formMessaggio->isValid($this->_getAllParams()) && $this->hasParam("Message"))
		{
			$user = Application_Model_User::getUserById($mex->getSender());
			$datiNewMex = array(
						"Mail" => $user->getMail(),
						"Sender" => Application_Model_User::isLogged(),
						"Receiver" => $mex->getSender(),
						"Message" => $formMessaggio->getValue("Message"),
						"Date" => "",
						"Hour" => ""
					);
			$newMex = new Application_Model_Message($datiNewMex);
			if(!$newMex->send())
			{
				//Errore di invio
				echo "Errore";
			}
			else 
			{
				$newMex->insert();
			}
		} 
	}
	
	public function logoffAction(){
		Application_Model_User::logOff();
		$this->_helper->layout()->setLayout('layout');
	}
	public function privateAction(){
		$this->_helper->layout()->setLayout('layoutprivate');
	}
}
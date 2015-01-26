<?php
namespace Registro\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Registro\Form\RegisterForm;

class RegisterController extends AbstractActionController
{
 public function indexAction()
 {
 	if ($this->request->isPost()) {
 		//inicializacion de variables
 		$post = $this->request->getPost();
		 $form = new RegisterForm();
		 $form->setData($post);

		 if (!$form->isValid()) {
			 $model = new ViewModel(array(
			 'error' => true,
			 'form' => $form,
			 ));
			$model->setTemplate('registro/register/index');
		 	return $model;
		 }

		 $this->createParticipante($form->getData());

		 return $this->redirect()->toRoute(NULL , array(
		 'controller' => 'register',
		 'action' => 'confirm'
		 ));

	 } //Fin es POST
	 
	//que hacer al principio 
	$form = new RegisterForm();
	$viewModel = new ViewModel(array('form' => $form));
	return $viewModel;
 }
 public function confirmAction()
 {
	 $viewModel = new ViewModel();
	 return $viewModel;
 }

 protected function createParticipante(array $data)
	{
		 $sm = $this->getServiceLocator();
		 $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

		 $resultSetPrototype = new \Zend\Db\ResultSet\ResultSet();

		 $resultSetPrototype->setArrayObjectPrototype(new \Registro\Model\Participante);

		 $tableGateway = new \Zend\Db\TableGateway\TableGateway('Participante', $dbAdapter, null, $resultSetPrototype);

		$participante = new \Registro\Model\Participante();
		$participante->exchangeArray($data);

		$participanteTable = new \Registro\Model\ParticipanteTable($tableGateway);
		$participanteTable->saveParticipante($participante);

		 return true;
	}

}
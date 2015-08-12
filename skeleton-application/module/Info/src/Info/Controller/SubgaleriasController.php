<?php
namespace Info\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Info\Model\Subgaleria;
use Info\Model\SubgaleriaTable;
use Info\Form\SubgaleriaForm;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class SubgaleriasController extends AbstractActionController
{
	protected $SubgaleriaTableVar;

	public $dbadapter;

	public function getAdapter()
	{
		if (!$this->dbadapter) {
			$sm = $this->getServiceLocator();
			$this->dbadapter = $sm->get('Zend\Db\Adapter\Adapter');
		}
		return $this->dbadapter;
	}

	public function indexAction()
	{
		$view =  new ViewModel();
		return $view;
	}

	public function addAction()
	{
		if (!$this->zfcUserAuthentication()->hasIdentity()) {
			return $this->redirect()->toUrl('/user/login');
		}

		$form = new SubgaleriaForm();
		$form->get('submit')->setValue('Add');
		$form->get('activo')->setAttribute('value', 'y');

		$request = $this->getRequest();
		if ($request->isPost()) {
			$subgal = new Subgaleria();

			$form->setData($request->getPost());
			if ($form->isValid()) {
				$subgal->exchangeArray($form->getData());
				$this->getSubgaleriaTable()->saveSubgaleria($subgal);
				// Redirect to list
				return $this->redirect()->toRoute(NULL, array(
					'controller' => 'subgalerias',
					'action' => 'lista'
					));
			}
		}
		return array('form' => $form);
	}

	public function editAction()
	{
		if (!$this->zfcUserAuthentication()->hasIdentity()) {
			return $this->redirect()->toUrl('/user/login');
		}
		$id = (int)$this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute(NULL, array(
				'controller' => 'subgalerias',
				'action' => 'add'
				));
		}

		try {
			$GetFormData = $this->getSubgaleriaTable()->getSubgaleria($id);
		}
		catch (\Exception $ex) {
			//
		}

		$form  = new SubgaleriaForm();
		$form->bind($GetFormData);
		$form->get('submit')->setAttribute('value', 'Editar');

		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setData($request->getPost());

			if ($form->isValid()) {
				$this->getSubgaleriaTable()->saveSubgaleria($GetFormData);

				// Redirect to list
				return $this->redirect()->toRoute(NULL, array(
					'controller' => 'subgalerias',
					'action' => 'lista'
					));
			}
		}

		$viewModel = new ViewModel(array(
			'form' => $form,
			'id' => $id,
			));
		return $viewModel;
	}

	public function listaAction()
	{
		if (!$this->zfcUserAuthentication()->hasIdentity()) {
			return $this->redirect()->toUrl('/user/login');
		}

		$view =  new ViewModel(array(
			'subgalerias' => $this->getSubgaleriaTable()->fetchAll(),
			));
		return $view;
	}

	public function getSubgaleriaTable()
	{
		if (!$this->SubgaleriaTableVar) {
			$sm = $this->getServiceLocator();
			$this->SubgaleriaTableVar = $sm->get('SubgaleriaTable');
		}
		return $this->SubgaleriaTableVar;
	}
}
<?php
namespace Registro\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Registro\Model\Obra;
use Registro\Model\ObraTable;
use Registro\Form\ObraForm;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class ObrasController extends AbstractActionController
{
	protected $ObraTableVar;

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
		$subgaleria = $this->params()->fromRoute('id', null);

		if($subgaleria){
			$tabla = $this->getObraTable()->fetchActiveSubgaleria($subgaleria);
			$tabla2 = $this->getObraTable()->fetchActiveSubgaleria($subgaleria);
		} else {
			$tabla = $this->getObraTable()->fetchActive();
			$tabla2 = $this->getObraTable()->fetchActive();
		}

	  //Fetch subgalerias
		$adapter = $this->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select()->from('Subgaleria')->where(array('galeria' => 'Obra', 'activo' => 'y'));
		$statement = $sql->prepareStatementForSqlObject($select);
		$result = $statement->execute();
		$resultSet = new ResultSet;
		$row = $resultSet->initialize($result)->toArray();

		$view =  new ViewModel(array(
			'obras' => $tabla,
			'obras2' => $tabla2,
			'subgalerias' => $row,
			));
		return $view;
	}

	public function addAction()
	{
		if (!$this->zfcUserAuthentication()->hasIdentity()) {
			return $this->redirect()->toUrl('/user/login');
		}

	  //Fetch subgalerias
		$subgal = $this->Subgalerias('Obra');

		$form = new ObraForm();
		$form->get('submit')->setValue('Add');
		$form->add(array(
			'name' => 'subgaleria',
			'type' => 'Select',
			'attributes' => array(
				'required' => ' ',
				),
			'options' => array(
				'label' => 'Subgaleria',
				'value_options' => $subgal,
				),
			));
		$form->get('activo')->setAttribute('value', 'y');

		$request = $this->getRequest();
		if ($request->isPost()) {
			$objeto = new Obra();

			$nonFile = $request->getPost()->toArray();
			$File    = $this->params()->fromFiles('fileupload');
			$data = array_merge(
				$nonFile,
				array('fileupload'=> $File['name'])
				);

			$form->setData($data);

			if ($form->isValid()) {
				$adapter = new \Zend\File\Transfer\Adapter\Http();
				//$adapter->setValidators(array($size), $File['name']);
				if ($adapter->isValid()) {
					$adapter->setDestination(getcwd() . '/public_html/galeria/obras');
					if ($adapter->receive($File['name'])) {
						$objeto->exchangeArray($form->getData());
						$objeto->setpath('/galeria/obras/'.$File['name']);
						$this->getObraTable()->saveObra($objeto);

						// Redirect to list
						return $this->redirect()->toRoute(NULL, array(
							'controller' => 'obras',
							'action' => 'lista'
						));
					} else {
						echo 'Error al subir el archivo';
					}
				}
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
				'controller' => 'obras',
				'action' => 'add'
				));
		}

		try {
			$GetFormData = $this->getObraTable()->getObra($id);
		}
		catch (\Exception $ex) {
			//
		}

		$form  = new ObraForm();
		$form->add(array(
			'name' => 'subgaleria',
			'type' => 'Select',
			'attributes' => array(
				'required' => ' ',
				),
			'options' => array(
				'label' => 'Subgaleria',
				'value_options' => $this->Subgalerias('Obra'),
				),
			));
		$form->bind($GetFormData);
		$form->get('submit')->setAttribute('value', 'Editar');
		$path = $GetFormData->path;

		$request = $this->getRequest();
		if ($request->isPost()) {
			$nonFile = $request->getPost()->toArray();
			$File    = $this->params()->fromFiles('fileupload');
			$data = array_merge(
				$nonFile,
				array('fileupload'=> $File['name'])
				);

			$form->setData($data);

			if ($form->isValid()) {
				$adapter = new \Zend\File\Transfer\Adapter\Http();
				if ($adapter->isValid()) {
					$adapter->setDestination(getcwd() . '/public_html/galeria/obras');
					if ($adapter->receive($File['name'])) {
						$GetFormData->setpath('/galeria/obras/'.$File['name']);
						//$this->getObraTable()->saveObra($GetFormData);
					} else {
						echo 'Error al subir el archivo';
					}
				}

				$this->getObraTable()->saveObra($GetFormData);

				// Redirect to list
				return $this->redirect()->toRoute(NULL, array(
					'controller' => 'obras',
					'action' => 'lista'
					));
			}
		}

		$viewModel = new ViewModel(array(
			'form' => $form,
			'id' => $id,
			'path' => $path,
			));
		return $viewModel;
	}

	public function listaAction()
	{
		if (!$this->zfcUserAuthentication()->hasIdentity()) {
			return $this->redirect()->toUrl('/user/login');
		}

		$view =  new ViewModel(array(
			'obras' => $this->getObraTable()->fetchAll(),
			));
		return $view;
	}

	public function getObraTable()
	{
		if (!$this->ObraTableVar) {
			$sm = $this->getServiceLocator();
			$this->ObraTableVar = $sm->get('ObraTable');
		}
		return $this->ObraTableVar;
	}

	public function Subgalerias($subgaleria) {
		//Fetch subgalerias
		$adapter = $this->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select()->from('Subgaleria')->where(array('galeria' => $subgaleria));
		$statement = $sql->prepareStatementForSqlObject($select);
		$result = $statement->execute();
		$resultSet = new ResultSet;
		$rows = $resultSet->initialize($result)->toArray();

		$subgal[''] = 'Seleccione';
		foreach ($rows as $row) {
			$subgal[$row['subgaleria']] = $row['subgaleria'];
		}

		return $subgal;
	}
}
<?php
namespace Registro\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class IndexController extends AbstractActionController
{
     public function indexAction()
     {
        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

        $resultSetPrototype = new \Zend\Db\ResultSet\ResultSet();

        $resultSetPrototype->setArrayObjectPrototype(new \Registro\Model\Participante);

        $tableGateway = new \Zend\Db\TableGateway\TableGateway('Obra', $dbAdapter, null, $resultSetPrototype);

        $sql = new Sql($adapter);
        $select = $sql->select()->from('Obra')->where(array('activo' => 'y'));
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $resultSet = new ResultSet;
        $row = $resultSet->initialize($result)->toArray();

        $view = new ViewModel(array(
            'obras' => $row
            ));
        return $view;
     }
     public function registerAction()
     {
         $view = new ViewModel();
         //$view->setTemplate('users/index/new-user');
         return $view;
     }
     public function loginAction()
     {
         $view = new ViewModel();
         //$view->setTemplate('users/index/login');
         return $view;
     }
}
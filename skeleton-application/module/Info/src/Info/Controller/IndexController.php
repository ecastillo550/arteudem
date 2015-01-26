<?php
namespace Info\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Info\Model\Conferencia;
use Info\Model\ConferenciaTable;

class IndexController extends AbstractActionController
{
    protected $Table;

     public function indexAction()
     {
        $view =  new ViewModel(array(
             'conferencias' => $this->getTable()->fetchAll(),
         ));
        return $view;
     }
     public function talleresAction()
     {

        $conferenciaTable = $this->getServiceLocator()->get('ConferenciasTable');

        $view = new ViewModel(array(
             'conferencias' => $this->conferenciaTable()->fetchAll()
        ));
        return $view;
     }

     public function getTable()
     {
         if (!$this->Table) {
             $sm = $this->getServiceLocator();
             $this->Table = $sm->get('ConferenciaTable');
         }
         return $this->Table;
     }
}
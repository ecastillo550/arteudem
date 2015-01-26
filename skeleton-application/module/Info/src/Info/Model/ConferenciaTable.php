<?php
namespace Info\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class ConferenciaTable
{
 protected $tableGateway;
 public function __construct(TableGateway $tableGateway)
 {
 $this->tableGateway = $tableGateway;
 }

 public function saveConferencia(Conferencia $conferencia)
 {
	 $data = array(
		 'nombre' => $conferencia->nombre,
		 'informacion' => $conferencia->informacion,
		 'carrera' => $conferencia->carrera
	 );

 	$id = (int)$conferencia->id;
	 if ($id == 0) {
	 	$this->tableGateway->insert($data);
	 } else {
	 if ($this->getConferencia($id)) {
	 	$this->tableGateway->update($data, array('id' => $id));
	 } else {
		 throw new \Exception('No existe');
		 }
	 }
 }
	
	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}
}
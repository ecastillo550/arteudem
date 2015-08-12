<?php
namespace Info\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class SubgaleriaTable
{
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function saveSubgaleria(Subgaleria $galeria)
	{
		$data = array(
			'subgaleria' => $galeria->subgaleria,
			'galeria' => $galeria->galeria,
			'activo' => $galeria->activo,
			);

		$id = (int) $galeria->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getSubgaleria($id)) {
				$this->tableGateway->update($data, array('id' => $id));
			} else {
				throw new \Exception('No existe');
			}
		}
	}

	public function getSubgaleria($id)
	{
		$id  = (int)$id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	public function fetchActive()
	{
		$resultSet = $this->tableGateway->select(array('activo' => 'y'));
		return $resultSet;
	}

	public function fetchSubgaleria($subgaleria)
	{
		$resultSet = $this->tableGateway->select(array('subgaleria' => $subgaleria));
		return $resultSet;
	}

	public function fetchActiveSubgaleria($subgaleria)
	{
		$resultSet = $this->tableGateway->select(array('subgaleria' => $subgaleria, 'activo' => 'y'));
		return $resultSet;
	}
}
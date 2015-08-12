<?php
namespace Registro\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class ObraTable
{
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function saveObra(Obra $participante)
	{
		$data = array(
			'nombre' => $participante->nombre,
			'apellido_paterno' => $participante->apellido_paterno,
			'apellido_materno' => $participante->apellido_materno,
			'titulo' => $participante->titulo,
			'tecnica' => $participante->tecnica,
			'medidax' => $participante->medidax,
			'mediday' => $participante->mediday,
			'descripcion' => $participante->descripcion,
			'activo' => $participante->activo,
			'path' => $participante->path,
			'subgaleria' => $participante->subgaleria,
			);

		$id = (int)$participante->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getObra($id)) {
				$this->tableGateway->update($data, array('id' => $id));
			} else {
				throw new \Exception('No existe');
			}
		}
	}
	public function getObra($id)
	{
		$id = (int) $id;
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
		//$resultSet = $this->tableGateway->select(array('activo' => 'y'));
		$select = $this->tableGateway->getSql()->select()->join('Subgaleria', 'Obra.subgaleria=Subgaleria.subgaleria')->where(array('Subgaleria.activo'=>'y', 'Obra.activo'=>'y'));

		$resultSet = $this->tableGateway->selectWith($select);

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
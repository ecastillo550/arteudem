<?php
namespace Registro\Model;

class Obra
{
	public $id;
	public $nombre;
	public $apellido_paterno;
	public $apellido_materno;
	public $titulo;
	public $tecnica;
	public $medidax;
	public $mediday;
	public $descripcion;
	public $activo;
	public $path;
	public $subgaleria;

	 public function exchangeArray($data)
	 {
	 	$this->id = (isset($data['id'])) ? $data['id'] : null;
		$this->nombre = (isset($data['nombre'])) ? $data['nombre'] : null;
		$this->apellido_paterno = (isset($data['apellido_paterno'])) ? $data['apellido_paterno'] : null;
		$this->apellido_materno = (isset($data['apellido_materno'])) ? $data['apellido_materno'] : null;
		$this->path = (isset($data['path'])) ? $data['path'] : null;
		$this->subgaleria = (isset($data['subgaleria'])) ? $data['subgaleria'] : null;
		$this->activo = (isset($data['activo'])) ? $data['activo'] : 'y';
		$this->titulo = (isset($data['titulo'])) ? $data['titulo'] : null;
		$this->tecnica = (isset($data['tecnica'])) ? $data['tecnica'] : null;
		$this->medidax = (isset($data['medidax'])) ? $data['medidax'] : null;
		$this->mediday = (isset($data['mediday'])) ? $data['mediday'] : null;
		$this->descripcion = (isset($data['descripcion'])) ? $data['descripcion'] : null;
	 }

	public function getArrayCopy()
	{
	    return get_object_vars($this);
	}

	public function setpath($path)
	{
	    $this->path = $path;
	}
}
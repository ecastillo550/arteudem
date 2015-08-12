<?php
namespace Info\Model;

class Subgaleria
{
	public $id;
	public $galeria;
	public $subgaleria;
	public $activo;


	 public function exchangeArray($data)
	 {
	 	$this->id = (isset($data['id'])) ? $data['id'] : null;
		$this->galeria = (isset($data['galeria'])) ? $data['galeria'] : null;
		$this->activo = (isset($data['activo'])) ? $data['activo'] : 'y';
		$this->subgaleria = (isset($data['subgaleria'])) ? $data['subgaleria'] : null;
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
<?php
// filename : module/Users/src/Users/Form/RegisterForm.php
namespace Info\Form;
use Zend\Form\Form;

class SubgaleriaForm extends Form
{
	public function __construct($name = null)
	{
	 parent::__construct('subgaleria');
	 $this->setAttribute('method', 'post');
	 $this->setAttribute('enctype','multipart/form-data');

	 	$this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));

		 $this->add(array(
	      'name' => 'galeria',
	      'type' => 'Select',
	      'attributes' => array(
	        'required' => ' ',
	        ),
	      'options' => array(
	        'label' => 'Galeria',
	        'value_options' => array(
	        	'' => 'Seleccione',
	        	'Obra' => 'Obra',
	        	),
	        ),
	      ));

		 $this->add(array(
				 'name' => 'subgaleria',
				 'type' => 'textarea',
				 'attributes' => array(
				 	'required' => ' ',
				 	'pattern' => 'alphanumesp',
				 ),
				 'options' => array(
					 'label' => 'Subgaleria',
				),
		 ));

		 $this->add(array(
			'name' => 'activo',
			'type' => 'Checkbox',
			'options' => array(
				'label' => 'Activo',
				'checked_value' => 'y',
				'unchecked_value' => 'n'
				),
			));

		 $this->add(array(
				 'name' => 'submit',
				 'type' => 'Submit',
				 'attributes' => array(
				 	'value' => 'Guardar',
				 	'class' => 'button',
				 ),
		 ));
	}
}
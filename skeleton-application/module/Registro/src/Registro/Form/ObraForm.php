<?php
// filename : module/Users/src/Users/Form/RegisterForm.php
namespace Registro\Form;
use Zend\Form\Form;

class ObraForm extends Form
{
	public function __construct($name = null)
	{
	 parent::__construct('Register');
	 $this->setAttribute('method', 'post');
	 $this->setAttribute('enctype','multipart/form-data');

	 $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));

		 $this->add(array(
				 'name' => 'nombre',
				 'type' => 'text',
				 'attributes' => array(
				 	'required' => ' ',
				 	'pattern' => 'alphanumesp',
				 ),
				 'options' => array(
					 'label' => 'Nombre',
				),
		 ));

		 $this->add(array(
				 'name' => 'apellido_paterno',
				 'type' => 'text',
				 'attributes' => array(
				 	'required' => ' ',
				 	'pattern' => 'alphanumesp',
				 ),
				 'options' => array(
					 'label' => 'Apellido Paterno',
				),
		 ));

		 $this->add(array(
				 'name' => 'apellido_materno',
				 'type' => 'text',
				 'attributes' => array(
				 	'required' => ' ',
				 	'pattern' => 'alphanumesp',
				 ),
				 'options' => array(
					 'label' => 'Apellido Materno',
				),
		 ));
         $this->add(array(
                         'name' => 'titulo',
                         'type' => 'text',
                         'attributes' => array(
                                'required' => ' ',
                                'pattern' => 'alphanumesp',
                         ),
                         'options' => array(
                                 'label' => 'Título de la obra',
                        ),
         ));
         $this->add(array(
                         'name' => 'medidax',
                         'type' => 'text',
                         'attributes' => array(
                                'required' => ' ',
                                'pattern' => 'alphanumesp',
                         ),
                         'options' => array(
                                 'label' => 'Ancho de la obra',
                        ),
         ));
         $this->add(array(
                         'name' => 'mediday',
                         'type' => 'text',
                         'attributes' => array(
                                'required' => ' ',
                                'pattern' => 'alphanumesp',
                         ),
                         'options' => array(
                                 'label' => 'Alto de la obra',
                        ),
         ));
         $this->add(array(
                         'name' => 'tecnica',
                         'type' => 'text',
                         'attributes' => array(
                                'required' => ' ',
                                'pattern' => 'alphanumesp',
                         ),
                         'options' => array(
                                 'label' => 'tecnica',
                        ),
         ));

         $this->add(array(
                         'name' => 'descripcion',
                         'type' => 'text',
                         'attributes' => array(
                                'required' => ' ',
                                'pattern' => 'alphanumesp',
                         ),
                         'options' => array(
                                 'label' => 'descripcion',
                        ),
         ));

         $this->add(array(
				 'name' => 'path',
				 'type' => 'textarea',
				 'attributes' => array(
				 	'required' => ' ',
				 	'pattern' => 'alphanumesp',
				 ),
		 ));

		 $this->add(array(
            'name' => 'fileupload',
            'attributes' => array(
                'type'  => 'file',
            ),
            'options' => array(
                'label' => 'File Upload',
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
				 	'value' => 'Enviar',
				 	'class' => 'button',
				 ),
		 ));
	}
}
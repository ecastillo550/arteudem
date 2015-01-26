<?php
// filename : module/Users/src/Users/Form/RegisterForm.php
namespace Users\Form;
use Zend\Form\Form;

class RegisterForm extends Form
{
	public function __construct($name = null)
	{
	 parent::__construct('Register');
	 $this->setAttribute('method', 'post');
	 $this->setAttribute('enctype','multipart/form-data');

		 $this->add(array(
				 'name' => 'name',
				 'type' => 'text',
				 'attributes' => array(),
				 'options' => array(
					 'label' => 'Full Name',
					),
		 ));

		 $this->add(array(
				 'name' => 'password',
				 'type' => 'text',
				 'attributes' => array(),
				 'options' => array(
					 'label' => 'email',
					),
		 ));

		 $this->add(array(
				 'name' => 'submit',
				 'type' => 'Submit',
				 'attributes' => array(
				 	'value' => 'Enviar',
				 ),
		 ));
	}
}
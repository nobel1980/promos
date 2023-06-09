<?php

namespace Vokuro\Forms;

use Phalcon\Forms\Form,
	Phalcon\Forms\Element\Text,
    Phalcon\Forms\Element\TextArea,
	Phalcon\Forms\Element\Hidden,
	Phalcon\Forms\Element\Password,
	Phalcon\Forms\Element\Submit,
	Phalcon\Forms\Element\Select,
	Phalcon\Forms\Element\Check,
	Phalcon\Validation\Validator\PresenceOf,
	Phalcon\Validation\Validator\Email;

use Vokuro\Models\Division;

class DivisionForm extends Form
{

	public function initialize($entity=null, $options=null)
	{
		//In edition the id is hidden
		if (isset($options['edit']) && $options['edit']) {
			$id = new Hidden('divid');
		} else {
			$id = new Text('divid');
		}

		$this->add($id);

		$this->add(new Text('divid',array('class'=>'input-large')));
		$this->add(new Text('divname',array('class'=>'input-xxlarge')));
		//$this->add(new Text('description',array('class'=>'input-xxlarge')));

        $this->add(new Select('active', array(
            '1' => 'Yes',
            '0' => 'No'
        )));
    }
}
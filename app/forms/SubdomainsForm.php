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

use Vokuro\Models\Domains;
use Vokuro\Models\Units;

class SubdomainsForm extends Form
{
	public function initialize($entity=null, $options=null)
	{
		//In edition the id is hidden
		if (isset($options['edit']) && $options['edit']) {
			$id = new Hidden('id');
		} else {
			$id = new Text('id');
		}

		$this->add($id);

		$this->add(new Text('weight',array('class'=>'input')));

		$this->add(new Text('title',array('class'=>'input-xxlarge')));

        $this->add(new Select('domain_id', Domains::find(), array(
            'using' => array('id', 'title'),
            'useEmpty' => true,
        )));
        $this->add(new Select('unit_id', Units::find(), array(
            'using' => array('id', 'title'),
            'useEmpty' => true,
        )));

        $this->add(new Select('active', array(
            '1' => 'Yes',
            '0' => 'No'
        )));
    }

}
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

class ZillaForm extends Form
{
	public function initialize($entity=null, $options=null)
	{
		//In edition the id is hidden
		if (isset($options['edit']) && $options['edit']) {
			$id = new Hidden('zillaid');
		} else {
			$id = new Text('zillaid');
		}

		$this->add($id);

		$this->add(new Text('zillid',array('class'=>'input')));
		$this->add(new Text('zillaname',array('class'=>'input')));

		//$this->add(new Text('title',array('class'=>'input-xxlarge')));

        $this->add(new Select('divid', Division::find(), array(
            'using' => array('divid', 'divname'),
            'useEmpty' => true,
        )));

        $this->add(new Select('active', array(
            '1' => 'Yes',
            '0' => 'No'
        )));
    }

}
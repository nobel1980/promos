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


use Vokuro\Models\Electionarea,
    Vokuro\Models\Division,
    Vokuro\Models\Zilla;

class ElectionareaForm extends Form
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

		$this->add(new Text('title_bn',array('class'=>'input-xxlarge')));
        $this->add(new Text('title_en',array('class'=>'input-xxlarge')));

        $this->add(new Text('constituencies',array('class'=>'input-xxlarge')));

        $this->add(new Text('code',array()));

        $this->add(new Select('division', Division::find(), array(
            'using' => array('divid', 'divname'),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => '',
            'onChange' => "showZilla(this.value,'district')"
        )));

        $this->add(new Select('district', Zilla::find(), array(
            'using' => array('zillaid', 'zillaname'),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => ''
        )));

    }
}
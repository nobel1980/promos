<?php

namespace Vokuro\Forms;

use Phalcon\Forms\Form,
	Phalcon\Forms\Element\Text,
	Phalcon\Forms\Element\Date,
	Phalcon\Forms\Element\Select,
	Phalcon\Forms\Element\Hidden,
    Vokuro\Models\Schedules;

class schedulesForm extends Form
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

        $this->add(new Text("sdate", array(
            'maxlength' => 30,
            'id' => 'sdate',
            'readonly' => 'readonly'
        )));

        $this->add(new Select('active', array(
            '1' => 'Yes',
            '0' => 'No'
        )));
    }
}
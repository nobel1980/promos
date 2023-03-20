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
	Phalcon\Forms\Element\Date,
	Phalcon\Validation\Validator\PresenceOf,
	Phalcon\Validation\Validator\Email;

use Vokuro\Models\Informations,
    Vokuro\Models\Division,
    Vokuro\Models\Zilla,
    Vokuro\Models\Electionarea,
    Vokuro\Models\Schedules;

use Vokuro\Controllers\InformationsController;

class InformationsForm extends Form
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

		//$this->add(new Text('dateinfo'), array('id'=>'date'));
		/*
		$this->add(new Text("dateinfo", array(
            'maxlength' => 30,
            'id' => 'dateinfo',
            'readonly' => 'readonly',
            'class' => 'nikosh_font'
        )));
        */

        $this->add(new Select('dateinfo', Schedules::find(), array(
            'using' => array('sdate', 'sdate'),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => '',
            'class' => 'nikosh_font'
        )));

        $this->add(new Select('division', Division::find(), array(
            'using' => array('divid', 'divname'),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => '',
            'onchange' => "showZilla(this.value,'district')"
        )));

        $this->add(new Select('district', Zilla::find(), array(
            'using' => array('zillaid', 'zillaname'),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => '',
            'onchange' => "showElectionarea(this.value,'electionarea')"
        )));

        $dd = new InformationsController();
       $district_code = $dd->getUserInfo(); // "district=$district_code"

        $this->add(new Select('electionarea', Electionarea::find("district=".$district_code['district']), array(
            'using' => array('id', 'title_bn'),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => ''
        )));

    }
}
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
    Vokuro\Models\Domains,
    Vokuro\Models\Subdomains,
    Vokuro\Models\Schedules;

use Vokuro\Controllers\InformationsController;

class AnalysisForm extends Form
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

        $this->add(new Select('datefirst', Schedules::find(), array(
            'using' => array('sdate', 'sdate'),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => '',
            'class' => 'nikosh_font'
        )));

         $this->add(new Select('datesecond', Schedules::find(), array(
                'using' => array('sdate', 'sdate'),
                'useEmpty' => true,
                'emptyText' => '...',
                'emptyValue' => '',
                'class' => 'nikosh_font'
            )));

        $dd = new InformationsController();
        $user_info = $dd->getUserInfo(); // "district=$district_code"
        if($user_info['profileid'] == '5')
        {
            $this->add(new Select('division', Division::find("divid=".$user_info['division']), array(
                'using' => array('divid', 'divname'),
                'useEmpty' => true,
                'emptyText' => '...',
                'emptyValue' => '',
                'onchange' => "showZilla(this.value,'district')"
            )));

            $this->add(new Select('district', Zilla::find("divid=".$user_info['division']), array(
                'using' => array('zillaid', 'zillaname'),
                'useEmpty' => true,
                'emptyText' => '...',
                'emptyValue' => '',
                'onchange' => "showElectionarea(this.value,'electionarea')"
            )));

            $this->add(new Select('electionarea', Electionarea::find("division=".$user_info['division']), array(
                'using' => array('id', 'title_bn'),
                'multiple' => 'multiple',
                'style' => 'width: 300px',
                'emptyValue' => ''
            )));
        }
        else
        {
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

            $this->add(new Select('electionarea', Electionarea::find(), array(
                'using' => array('id', 'title_bn'),
                'useEmpty' => true,
                'emptyText' => '...',
                'multiple' => 'multiple',
                'style' => 'width: 300px',
                'emptyValue' => ''
            )));
        }



        $this->add(new Select('domain', Domains::find(), array(
            'using' => array('id', 'title'),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => '',
            'onchange' => "showSubdomain(this.value,'subdomain')"
        )));

        $this->add(new Select('subdomain', Subdomains::find(), array(
            'using' => array('id', 'title'),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => '',
            'onchange' => ''
        )));

    }
}
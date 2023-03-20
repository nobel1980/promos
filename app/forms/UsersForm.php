<?php
namespace Vokuro\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Vokuro\Models\Profiles;

use Vokuro\Models\Zilla;
use Vokuro\Models\Division;
use Vokuro\Models\Electionarea;

class UsersForm extends Form
{

    public function initialize($entity = null, $options = null)
    {

        // In edition the id is hidden
        if (isset($options['edit']) && $options['edit']) {
            $id = new Hidden('id');
        } else {
            $id = new Text('id');
        }

        $this->add($id);

        $name = new Text('name', array(
            'placeholder' => 'Name'
        ));

        $name->addValidators(array(
            new PresenceOf(array(
                'message' => 'The name is required'
            ))
        ));

        $this->add($name);

        $email = new Text('email', array(
            'placeholder' => 'Email'
        ));

        $email->addValidators(array(
            new PresenceOf(array(
                'message' => 'The e-mail is required'
            )),
            new Email(array(
                'message' => 'The e-mail is not valid'
            ))
        ));

        $this->add($email);

        $this->add(new Select('profilesId', Profiles::find('active = "Y"'), array(
            'using' => array(
                'id',
                'name'
            ),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => '',
            'onchange' => 'showZilla(this.value);showDivision(this.value);showElectionarea(this.value);'
        )));

        $this->add(new Select('banned', array(
            'Y' => 'Yes',
            'N' => 'No'
        )));

        $this->add(new Select('suspended', array(
            'Y' => 'Yes',
            'N' => 'No'
        )));

        $this->add(new Select('active', array(
            'Y' => 'Yes',
            'N' => 'No'
        )));

         $this->add(new Select('district', Zilla::find(), array(
            'using' => array('zillaid', 'zillaname'),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => '',
            'onchange' => ''
        )));

        $this->add(new Select('division', Division::find(), array(
            'using' => array('divid', 'divname'),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => '',
            'onchange' => ''
        )));

        $this->add(new Select('electionarea', Electionarea::find(), array(
            'using' => array('id', 'title_bn'),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => '',
            'onchange' => ''
        )));

    }
}
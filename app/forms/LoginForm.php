<?php
namespace Vokuro\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;

class LoginForm extends Form
{

    public function initialize()
    {
        // Email
        $email = new Text('email', array(
            'placeholder' => 'ই-মেইল',
            'class' => 'form-control'
        ));

        $email->addValidators(array(
            new PresenceOf(array(
                'message' => 'ই-মেইল দিতে হবে'
            )),
            new Email(array(
                'message' => 'ই-মেইলটি সঠিক নয়'
            ))
        ));

        $this->add($email);

        // Password
        $password = new Password('password', array(
            'placeholder' => 'পাসওয়ার্ড',
            'class' => 'form-control'
        ));

        $password->addValidator(new PresenceOf(array(
            'message' => 'পাসওয়ার্ড দিতে হবে'
        )));

        $this->add($password);

        // Remember
        $remember = new Check('remember', array(
            'value' => 'yes'
        ));
        $remember->setLabel('মনে রাখো');


        $this->add($remember);

        // CSRF
        $csrf = new Hidden('csrf');

        $csrf->addValidator(new Identical(array(
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation failed'
        )));

        $this->add($csrf);

        $this->add(new Submit('go', array(
             'value' => 'প্রবেশ',
            'class' => 'btn btn-lg btn-primary btn-block'
        )));
    }
}

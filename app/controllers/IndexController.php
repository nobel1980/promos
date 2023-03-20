<?php
namespace Vokuro\Controllers;

/**
 * Display the default index page.
 */
class IndexController extends ControllerBase
{

    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function indexAction()
    {
        $this->view->setTemplateBefore('public');

         return $this->dispatcher->forward(array(
            "controller" => "session",
            "action" => "login"
        ));

        //return $this->response->redirect('session/login');
    }
}
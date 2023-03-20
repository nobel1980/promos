<?php

namespace Vokuro\Controllers;

use Phalcon\Tag,
    Phalcon\Mvc\Model\Criteria,
    Phalcon\Http\Response,
    Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Forms\SchedulesForm;
use Vokuro\Models\Schedules;

class SchedulesController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setTemplateBefore('private');
    }

    public function indexAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new SchedulesForm();
    }

    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\Schedules', $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $schedules = Schedules::find($parameters);
        if (count($schedules) == 0) {
            $this->flash->notice("The search did not find any Schedules");
            return $this->dispatcher->forward(array(
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $schedules,
            "limit" => 10,
            "page" => $numberPage
        ));
        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Creates a Content Type
     *
     */
    public function createAction()
    {
        if ($this->request->isPost()) {

            $schedules = new schedules();
            //$id = $this->request->getPost('id', 'int');
            $schedules->assign(array(
                //'id' => $this->request->getPost('id', 'striptags'),
                'sdate' => $this->request->getPost('sdate', 'striptags'),
                'active' => $this->request->getPost('active'),
            ));

            if (!$schedules->save()) {
                $this->flash->error($schedules->getMessages());
            } else {

                $this->flash->success("শিডিউলটি  সফলভাবে  সংরক্ষণ হয়েছে।");

                Tag::resetInput();
            }
        }

        $this->view->form = new schedulesForm(null);
    }

    /**
     * Saves the schedules from the 'edit' action
     *
     */
    public function editAction($id)
    {

        $schedules = schedules::findFirstById($id);
        if (!$schedules) {
            $this->flash->error("Schedules was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if ($this->request->isPost()) {
            //$id = $this->request->getPost('id', 'int');

            $schedules->assign(array(
                'sdate' => $this->request->getPost('sdate', 'striptags'),
                'active' => $this->request->getPost('active'),
            ));

            if (!$schedules->save()) {
                $this->flash->error($schedules->getMessages());
            } else {

                $this->flash->success("শিডিউলটি সফলভাবে আপডেট হয়েছে।");

                Tag::resetInput();
            }

        }

        $this->view->form = new SchedulesForm($schedules, array('edit' => true));
    }

    /**
     * Deletes a schedules
     *
     * @param int $id
     */
    public function deleteAction($id)
    {

        $schedules = Schedules::findFirstById($id);
        if (!$schedules) {
            $this->flash->error("Schedules was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if (!$schedules->delete()) {
            $this->flash->error($schedules->getMessages());
        } else {
            $this->flash->success("শিডিউলটি মুছে ফেলা হয়েছে।");
        }

        return $this->dispatcher->forward(array('action' => 'index'));
    }
}


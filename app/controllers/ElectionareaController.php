<?php

namespace Vokuro\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Vokuro\Forms\ElectionareaForm;
use Vokuro\Models\Electionarea;


class ElectionareaController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setTemplateBefore('private');
    }

    public function indexAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new ElectionareaForm();
    }

    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\Electionarea', $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $parameters['order'] = "code";
        $electionarea = Electionarea::find($parameters);

        /*
        $robots = Robots::find(array(
            "type = 'virtual'",
            "order" => "name"
        ));
        */


        if (count($electionarea) == 0) {
            $this->flash->notice("The search did not find any Election area");
            return $this->dispatcher->forward(array(
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $electionarea,
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

            $electionarea = new Electionarea();
            $id = $this->request->getPost('id', 'int');
            $electionarea->assign(array(
                'title_bn' => $this->request->getPost('title_bn', 'striptags'),
                'title_en' => $this->request->getPost('title_en', 'striptags'),
                'code' => $this->request->getPost('code', 'striptags'),
                'district' => $this->request->getPost('district', 'striptags'),
                'constituencies' => $this->request->getPost('constituencies', 'striptags'),
                'division' => $this->request->getPost('division', 'striptags'),
                'id' => $id?$id:0,
            ));

            if (!$electionarea->save()) {
                $this->flash->error($electionarea->getMessages());
            } else {

                $this->flash->success("Election area was created successfully");

                Tag::resetInput();
            }
        }

        $this->view->form = new ElectionareaForm(null);
    }

    /**
     * Saves the user from the 'edit' action
     *
     */
    public function editAction($id)
    {

        $electionarea = Electionarea::findFirstById($id);
        if (!$electionarea) {
            $this->flash->error("Election area was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if ($this->request->isPost()) {
            $id = $this->request->getPost('id', 'int');

            $electionarea->assign(array(
                'title_bn' => $this->request->getPost('title_bn', 'striptags'),
                'title_en' => $this->request->getPost('title_en', 'striptags'),
                'code' => $this->request->getPost('code', 'striptags'),
                'district' => $this->request->getPost('district', 'striptags'),
                'constituencies' => $this->request->getPost('constituencies', 'striptags'),
                'division' => $this->request->getPost('division', 'striptags'),
                'id' => $id?$id:0,
            ));

//print_r($electionarea);exit;
            if (!$electionarea->save()) {
                $this->flash->error($electionarea->getMessages());
            } else {

                $this->flash->success("Election area was updated successfully");

                Tag::resetInput();
            }

        }

        $this->view->form = new ElectionareaForm($electionarea, array('edit' => true));
    }

    /**
     * Deletes a User
     *
     * @param int $id
     */
    public function deleteAction($id)
    {
        return $this->dispatcher->forward(array('action' => 'index'));
    }
}
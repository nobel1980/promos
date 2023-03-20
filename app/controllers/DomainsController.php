<?php

namespace Vokuro\Controllers;

use Phalcon\Tag,
    Phalcon\Mvc\Model\Criteria,
    Phalcon\Http\Response,
    Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Forms\DomainsForm;
use Vokuro\Models\Domains;


class DomainsController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setTemplateBefore('private');
    }

    public function indexAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new DomainsForm();
    }

    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\Domains', $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $domains = Domains::find($parameters);
        if (count($domains) == 0) {
            $this->flash->notice("The search did not find any Category");
            return $this->dispatcher->forward(array(
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $domains,
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

            $domains = new Domains();
            //$domainid = $this->request->getPost('id', 'int');
            $domains->assign(array(
                'title' => $this->request->getPost('title', 'striptags'),
                'description' => $this->request->getPost('description', 'striptags'),
                'active' => $this->request->getPost('active'),
            ));

            if (!$domains->save()) {
                $this->flash->error($domains->getMessages());
            } else {

                $this->flash->success("Category was created successfully");

                Tag::resetInput();
            }
        }

        $this->view->form = new DomainsForm(null);
    }

    /**
     * Saves the user from the 'edit' action
     *
     */
    public function editAction($id)
    {

        $domains = Domains::findFirstById($id);
        if (!$domains) {
            $this->flash->error("Category was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if ($this->request->isPost()) {
            //$id = $this->request->getPost('id', 'int');

            $domains->assign(array(
                'title' => $this->request->getPost('title', 'striptags'),
                'description' => $this->request->getPost('description', 'striptags'),
                'active' => $this->request->getPost('active'),
            ));

            if (!$domains->save()) {
                $this->flash->error($domains->getMessages());
            } else {

                $this->flash->success("Categroy was updated successfully");

                Tag::resetInput();
            }

        }

        $this->view->form = new DomainsForm($domains, array('edit' => true));
    }

    /**
     * Deletes a User
     *
     * @param int $id
     */
    public function deleteAction($id)
    {

//        $user = Domains::findFirstById($id);
//        if (!$user) {
//            $this->flash->error("Lookup Types was not found");
//            return $this->dispatcher->forward(array('action' => 'index'));
//        }
//
//        if (!$user->delete()) {
//            $this->flash->error($user->getMessages());
//        } else {
//            $this->flash->success("Lookup Types was deleted");
//        }

        return $this->dispatcher->forward(array('action' => 'index'));
    }
}


<?php

namespace Vokuro\Controllers;

use Phalcon\Tag,
    Phalcon\Mvc\Model\Criteria,
    Phalcon\Http\Response,
    Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Forms\DivisionForm;
use Vokuro\Models\Division;


class DivisionController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setTemplateBefore('private');
    }

    public function indexAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new DivisionForm();
    }

    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\Division', $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $division = Division::find($parameters);
        if (count($division) == 0) {
            $this->flash->notice("The search did not find any Category");
            return $this->dispatcher->forward(array(
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $division,
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

            $division = new division();
            //$domainid = $this->request->getPost('divid', 'int');
            $division->assign(array(
                'divid' => $this->request->getPost('divid', 'striptags'),
                'divname' => $this->request->getPost('divname', 'striptags'),
               // 'description' => $this->request->getPost('description', 'striptags'),
                'active' => $this->request->getPost('active'),
            ));

                    if (!$division->save()) {
                $this->flash->error($division->getMessages());
            } else {

                $this->flash->success("বিভাগটি  সফল্ভাবে সংরক্ষণ হয়েছে।");

                Tag::resetInput();
            }
        }

        $this->view->form = new DivisionForm(null);
    }

    /**
     * Saves the division from the 'edit' action
     *
     */
    public function editAction($id)
    {

        $division = division::findFirstByDivid($id);
        if (!$division) {
            $this->flash->error("Category was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if ($this->request->isPost()) {
            //$id = $this->request->getPost('divid', 'int');

            $division->assign(array(
                'divname' => $this->request->getPost('divname', 'striptags'),
               // 'description' => $this->request->getPost('description', 'striptags'),
                'active' => $this->request->getPost('active'),
            ));

            if (!$division->save()) {
                $this->flash->error($division->getMessages());
            } else {

                $this->flash->success("বিভাগটি সফল্ভাবে আপডেট হয়েছে।");

                Tag::resetInput();
            }

        }

        $this->view->form = new DivisionForm($division, array('edit' => true));
    }

    /**
     * Deletes a division
     *
     * @param int $id
     */
    public function deleteAction($id)
    {

        $division = Division::findFirstByDivid($id);
        if (!$division) {
            $this->flash->error("Lookup Types was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if (!$division->delete()) {
            $this->flash->error($division->getMessages());
        } else {
            $this->flash->success("বিভাগটি মুছে ফেলা হয়েছে।");
        }

        return $this->dispatcher->forward(array('action' => 'index'));
    }
}


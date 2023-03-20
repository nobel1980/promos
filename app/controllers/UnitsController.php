<?php

namespace Vokuro\Controllers;

use Phalcon\Tag,
    Phalcon\Mvc\Model\Criteria,
    Phalcon\Http\Response,
    Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Forms\UnitsForm;
use Vokuro\Models\Units;


class UnitsController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setTemplateBefore('private');
    }

    public function indexAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new UnitsForm();
    }

    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\Units', $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $units = Units::find($parameters);
        if (count($units) == 0) {
            $this->flash->notice("The search did not find any Category");
            return $this->dispatcher->forward(array(
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $units,
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

            $units = new units();
            //$id = $this->request->getPost('id', 'int');
            $units->assign(array(
                //'id' => $this->request->getPost('id', 'striptags'),
                'title' => $this->request->getPost('title', 'striptags'),
                'description' => $this->request->getPost('description', 'striptags')
                //'active' => $this->request->getPost('active'),
            ));

                    if (!$units->save()) {
                $this->flash->error($units->getMessages());
            } else {

                $this->flash->success("ইউনিটটি  সফলভাবে  সংরক্ষণ হয়েছে।");

                Tag::resetInput();
            }
        }

        $this->view->form = new UnitsForm(null);
    }

    /**
     * Saves the units from the 'edit' action
     *
     */
    public function editAction($id)
    {

        $units = units::findFirstById($id);
        if (!$units) {
            $this->flash->error("Units was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if ($this->request->isPost()) {
            //$id = $this->request->getPost('id', 'int');

            $units->assign(array(
                'title' => $this->request->getPost('title', 'striptags'),
                'description' => $this->request->getPost('description', 'striptags'),
                'active' => $this->request->getPost('active'),
            ));

            if (!$units->save()) {
                $this->flash->error($units->getMessages());
            } else {

                $this->flash->success("ইউনিটটি সফলভাবে আপডেট হয়েছে।");

                Tag::resetInput();
            }

        }

        $this->view->form = new UnitsForm($units, array('edit' => true));
    }

    /**
     * Deletes a units
     *
     * @param int $id
     */
    public function deleteAction($id)
    {

        $units = Units::findFirstById($id);
        if (!$units) {
            $this->flash->error("Units was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if (!$units->delete()) {
            $this->flash->error($units->getMessages());
        } else {
            $this->flash->success("ইউনিটটি মুছে ফেলা হয়েছে।");
        }

        return $this->dispatcher->forward(array('action' => 'index'));
    }
}


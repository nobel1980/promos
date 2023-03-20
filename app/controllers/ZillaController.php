<?php

namespace Vokuro\Controllers;

use Phalcon\Tag,
    Phalcon\Mvc\Model\Criteria,
    Phalcon\Http\Response,
    Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Forms\ZillaForm;
use Vokuro\Models\Division;
use Vokuro\Models\Zilla;

class ZillaController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setTemplateBefore('private');
    }

    public function indexAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new ZillaForm();
    }

    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\Zilla', $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\Zilla', $this->request->get());
            $this->persistent->searchParams = $query->getParams();
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $zilla = Zilla::find($parameters);
        if (count($zilla) == 0) {
            $this->flash->notice("The search did not find any Sub Category");
            return $this->dispatcher->forward(array(
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $zilla,
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

            $zilla = new Zilla();

            $zilla->assign(array(
                'zillaid' => $this->request->getPost('zillaid', 'striptags'),
                'zillaname' => $this->request->getPost('zillaname', 'striptags'),
                'divid' => $this->request->getPost('divid', 'int'),
                'active' => $this->request->getPost('active', 'int'),

                'createdby' => $this->getUserId(),
                'lastmodifiedby' => $this->getUserId(),
            ));

            if (!$zilla->save()) {
                $this->flash->error($zilla->getMessages());
            } else {

                $this->flash->success("জেলাটি  সফলভাবে সংরক্ষণ হয়েছে");

                Tag::resetInput();
            }
        }

        $this->view->form = new ZillaForm(null);
    }

    /*
    public function listAction()
    {
        $zilla = zilla::find();
        $this->view->zilla = $zilla;
    }
    */

    /**
     * Saves the user from the 'edit' action
     *
     */
    public function editAction($id)
    {
        $zilla = Zilla::findFirst('zillaid='.$id);
        if (!$zilla) {
            $this->flash->error("SubCategory was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if ($this->request->isPost()) {
            $zilla->assign(array(
                'zillaname' => $this->request->getPost('zillaname', 'striptags'),
                'divid' => $this->request->getPost('divid', 'int'),
                'active' => $this->request->getPost('active', 'int'),

                'lastmodifiedby' => $this->getUserId(),
            ));

            if (!$zilla->save()) {
                $this->flash->error($zilla->getMessages());
            } else {

                $this->flash->success("জেলাটি সফলভাবে আপডেট হয়েছে।");

                Tag::resetInput();
            }

        }
        $this->view->form = new ZillaForm($zilla, array('edit' => true));
    }

    /**
     * Deletes a Zilla
     *
     * @param int $id
     */

    public function deleteAction($id)
    {
        $zilla = Zilla::findFirstByZillaid($id);
        if (!$zilla) {
            $this->flash->error("Lookup Types was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if (!$zilla->delete()) {
            $this->flash->error($zilla->getMessages());
        } else {
            $this->flash->success("জেলাটি মুছে ফেলা হয়েছে।");
        }
        return $this->dispatcher->forward(array('action' => 'index'));
    }

}
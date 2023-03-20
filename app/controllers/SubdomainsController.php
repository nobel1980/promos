<?php

namespace Vokuro\Controllers;

use Phalcon\Tag,
    Phalcon\Mvc\Model\Criteria,
    Phalcon\Http\Response,
    Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Forms\SubdomainsForm;
use Vokuro\Models\Domains;
use Vokuro\Models\Subdomains;

class SubdomainsController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setTemplateBefore('private');
    }

    public function indexAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new SubdomainsForm();
    }

    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\Subdomains', $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\Subdomains', $this->request->get());
            $this->persistent->searchParams = $query->getParams();
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $parameters['order'] = " domain_id, weight ";

        $subdomains = Subdomains::find($parameters);
        if (count($subdomains) == 0) {
            $this->flash->notice("The search did not find any Sub Category");
            return $this->dispatcher->forward(array(
                "action" => "index"
            ));
        }

         //echo "<pre>";
         //print_r($subdomains);exit;

         //title
         //domain_id

        $data_sub;
        $i=0;

        foreach($subdomains as $sub)
        {
            $data_sub[$i]['no'] = $i+1;
            $data_sub[$i]['title'] = $sub->title;
            $data_sub[$i]['domain'] = $this->domain_name_by_id($sub->domain_id);
            $data_sub[$i]['id'] = $sub->id;
            $i++;
        }

        $paginator = new Paginator(array(
            "data" => $subdomains,
            "limit" => 20,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();

        $this->view->data_sub = $data_sub;
    }

    /**
     * Creates a Content Type
     *
     */

    public function createAction()
    {
        if ($this->request->isPost()) {

            $subdomains = new Subdomains();

            $subdomains->assign(array(
                'title' => $this->request->getPost('title', 'striptags'),
                'domain_id' => $this->request->getPost('domain_id', 'int'),
                'weight' => $this->request->getPost('weight', 'int'),
                'unit_id' => $this->request->getPost('unit_id', 'int'),
                'active' => $this->request->getPost('active', 'int'),

                'createdby' => $this->getUserId(),
                'lastmodifiedby' => $this->getUserId(),
            ));

            if (!$subdomains->save()) {
                $this->flash->error($subdomains->getMessages());
            } else {

                $this->flash->success("Sub Category was created successfully");

                Tag::resetInput();
            }
        }

        $this->view->form = new SubdomainsForm(null);
    }

    /*
    public function listAction()
    {
        $subdomains = Subdomains::find();
        $this->view->subdomains = $subdomains;
    }
    */

    /**
     * Saves the user from the 'edit' action
     *
     */
    public function editAction($id)
    {
        $subdomains = Subdomains::findFirst('id='.$id);
        if (!$subdomains) {
            $this->flash->error("SubCategory was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if ($this->request->isPost()) {
            $subdomains->assign(array(
                'title' => $this->request->getPost('title', 'striptags'),
                'domain_id' => $this->request->getPost('domain_id', 'int'),
                'weight' => $this->request->getPost('weight', 'int'),
                'unit_id' => $this->request->getPost('unit_id', 'int'),
                'active' => $this->request->getPost('active', 'int'),

                'lastmodifiedby' => $this->getUserId(),
            ));

            if (!$subdomains->save()) {
                $this->flash->error($subdomains->getMessages());
            } else {

                $this->flash->success("Sub Category was updated successfully");

                Tag::resetInput();
            }

        }
        $this->view->form = new SubdomainsForm($subdomains, array('edit' => true));
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

    public function domain_name_by_id($id)
    {
       $domains = Domains::findFirst("id = '$id' and active='1'");

       return $domains->title;
    }

}
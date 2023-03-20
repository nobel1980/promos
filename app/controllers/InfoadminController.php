<?php
namespace Vokuro\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Forms\InfoAdminForm;
use Vokuro\Models\Informations;
use Vokuro\Models\Infodetails;

use Vokuro\Models\Domains;
use Vokuro\Models\Subdomains;
use Vokuro\Models\Units;
use Vokuro\Models\Zilla;
use Vokuro\Models\Electionarea;

class InfoadminController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateBefore('private');
    }

    public function indexAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new InfoAdminForm();
    }

    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Vokuro\Models\Informations', $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $information = Informations::find($parameters);
        if (count($information) == 0) {
            $this->flash->notice("The search did not find any Data");
            return $this->dispatcher->forward(array(
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $information,
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
            $information = new Informations();
            // Assign the Information details array
            //$information->infodetails = $infodetails;
            $information->assign(array(
                'electionarea' => $this->request->getPost('electionarea', 'striptags'),
                'district' => $this->request->getPost('district', 'striptags'),
                'division' => $this->request->getPost('division', 'striptags'),
                'dateinfo' => $this->request->getPost('dateinfo', 'striptags'),
                'status' => 'send',
                'user' => $this->getUserId(),
                'userip' => $this->request->getClientAddress(),
                'useragent' => $this->request->getUserAgent()
            ));

            if (!$information->save()) {
                $this->flash->error($information->getMessages());
            }
            else {
                ////////////////////////////////////////////////////////
                $j=0;
                $details_success = 0;
                $infodetails = array();
                foreach($this->request->getPost("amount") as $key=>$am)
                {
                    if($am)
                    {
                        $infodetails[$j] = new Infodetails();
                        //'id' => 'id',
                        $infodetails[$j]->info_id = $information->id;
                        $infodetails[$j]->subdomain_id = $key;
                        $infodetails[$j]->amount = $am;
                        $infodetails[$j]->status = 1;
                        $infodetails[$j]->unit_id = 1;//todo//

                        if (!$infodetails[$j]->save()) {
                            $details_success = 0;
                            break;
                        } else {
                            $details_success++;
                        }

                        $j++;
                    }
                }

                if($details_success>0)
                {
                    $this->flash->success("Data was created successfully");
                    Tag::resetInput();
                }
                else
                {
                    //===========TOTODODO============//
                    //RollBack//
                    //===========TOTODODO============//
                    $this->flash->error($infodetails[$j]->getMessages());
                }
                ///////////////////////////////////////////////////////

            }
        }

        /*==============================================*/
        $domains = Domains::find();
        $subdomains;
        $units;
        foreach($domains as $domain)
        {
            $subdomains[$domain->id] = $domain->getSubdomains();
            //echo "<pre>";print_r($subdomains[$domain->id]);exit;
            foreach($subdomains[$domain->id] as $sub)
            {
                 $units[$domain->id][$sub->id] = $this->unitsInfo($sub->unit_id);
            }

        }

        $this->view->form = new InfoAdminForm(null);
        $this->view->domains = $domains;
        $this->view->subdomains = $subdomains;
        $this->view->units = $units;
        /*==============================================*/
    }

    /**
     * Saves the user from the 'edit' action
     *
     */
    public function editAction($id)
    {
        $information = Informations::findFirstById($id);
        if (!$information) {
            $this->flash->error("Any Data not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if ($this->request->isPost()) {
            $id = $this->request->getPost('id', 'int');

            $information->assign(array(
                'electionarea' => $this->request->getPost('electionarea', 'striptags'),
                'district' => $this->request->getPost('district', 'striptags'),
                'division' => $this->request->getPost('division', 'striptags'),
                'dateinfo' => $this->request->getPost('dateinfo', 'striptags'),
                'id' => $id?$id:0,
            ));

            if (!$information->save()) {
                $this->flash->error($information->getMessages());
            } else {

                $this->flash->success("Data was updated successfully");

                Tag::resetInput();
            }

        }

        $this->view->form = new InfoAdminForm($information, array('edit' => true));
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

    public function unitsInfo($id)
    {
       return $units = Units::findFirst("id = '$id' and active='1'");
    }

    public function  getzillaAction()
    {
        $this->view->disable();
        $childs = array();
        if (($this->request->isPost()) && ($this->request->isAjax() == true)) {
            $divId = $this->request->getQuery("ld", "string");

            $tmp = array();
            if ($divId) {
                $tmp = Zilla::find("divid=" . $divId);
            }

            foreach ($tmp as $t) {

                $childs[] = array('id' => $t->zillaid, 'name' => $t->zillaname);

            }
        }
//        var_dump($childs);
        $response = new \Phalcon\Http\Response();
        $response->setContentType('application/json', 'UTF-8');
        $response->setContent(json_encode($childs));
        return $response;
    }

   public function getelectionareaAction()
   {
       $this->view->disable();
       $childs = array();
       if (($this->request->isPost()) && ($this->request->isAjax() == true)) {
           $disId = $this->request->getQuery("ld", "string");

           $tmp = array();
           if ($disId) {
               $tmp = Electionarea::find("district=" . $disId);
           }
           foreach ($tmp as $t) {
               $childs[] = array('id' => $t->id, 'name' => $t->title_bn);
           }
       }
//        var_dump($childs);
       $response = new \Phalcon\Http\Response();
       $response->setContentType('application/json', 'UTF-8');
       $response->setContent(json_encode($childs));
       return $response;
   }

}
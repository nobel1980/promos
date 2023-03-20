<?php
namespace Vokuro\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Forms\InformationsForm;
use Vokuro\Models\Informations;
use Vokuro\Models\Infodetails;

use Vokuro\Models\Domains;
use Vokuro\Models\Subdomains;
use Vokuro\Models\Units;
use Vokuro\Models\Division;
use Vokuro\Models\Zilla;
use Vokuro\Models\Electionarea;
use Vokuro\Models\Schedules;


class AdmindashController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateBefore('private');
    }

    public function indexAction()
    {
        $this->persistent->conditions = null;

        $logged_user_info = $this->getUserInfo();

        foreach(Division::find() as $dv)
        {
            $division[$dv->divid]['divid'] = $dv->divid;
            $division[$dv->divid]['divname'] = $dv->divname;
            $division[$dv->divid]['divnameeng'] = $dv->divnameeng;
            $division[$dv->divid]['countdis'] = $this->countDistrict($dv->divid);
        }

        foreach(Zilla::find() as $zl)
        {
            $district[$zl->zillaid]['zillaid'] = $zl->zillaid;
            $district[$zl->zillaid]['zillaname'] = $zl->zillaname;
            $district[$zl->zillaid]['zillanameeng'] = $zl->zillanameeng;
            $district[$zl->zillaid]['divid'] = $zl->divid;
            $district[$zl->zillaid]['countea'] = $this->countElectionarea($zl->zillaid);
        }

//echo "<pre>"; print_r($district);

        foreach(Electionarea::find(array("order" => "code")) as $ea)
        {
            $electionarea[$ea->id]['title_bn'] = $ea->title_bn;
            $electionarea[$ea->id]['title_en'] = $ea->title_en;
            $electionarea[$ea->id]['code'] = $ea->code;
            $electionarea[$ea->id]['district'] = $ea->district;
            $electionarea[$ea->id]['division'] = $ea->division;

            $electionarea[$ea->id]['district_name'] = $district[$ea->district]['zillaname'];
            $electionarea[$ea->id]['division_name'] = $division[$ea->division]['divname'];

            $electionarea[$ea->id]['district_eacount'] = $district[$ea->district]['countea'];
            $electionarea[$ea->id]['division_discount'] = $division[$ea->division]['countdis'];

            //echo "<pre>"; print_r($electionarea);
            /*--------info data-------------*/
            $ea_sc = Schedules::find(array(
                "active=1",
                "order"=> "sdate DESC"));
            foreach($ea_sc as $es)
            {
                $info = Informations::findFirst("dateinfo='".$es->sdate."' and electionarea='".$ea->id."' and status='received'");
                if(isset($info->id))
                {
                    $electionarea[$ea->id][$es->sdate] = $info->id;
                }
            }
            /*---------info data------------*/
        }

//echo "<pre>"; print_r($electionarea);
//exit;
        $this->view->schedules = Schedules::find(array(
                    "active=1",
                    "order"=> "sdate DESC"));
        $this->view->electionarea = $electionarea;
        $this->view->user_info = $logged_user_info;
    }

    public function viewAction($id)
    {
        $information = Informations::findFirstById($id);
        $information_details = Infodetails::find("info_id=$id");

        $district_info = $this->getDistrictInfo($information->district);
        $earea_info = $this->getEareaInfo($information->electionarea);

        if (!$information) {
            $this->flash->error("Any Data not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }
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

        $this->view->information = $information;
        $this->view->domains = $domains;
        $this->view->subdomains = $subdomains;
        $this->view->units = $units;

        $this->view->information = $information;
        $this->view->info_detials = $information_details;
        $this->view->district_info = $district_info;
        $this->view->earea_info = $earea_info;
    }

    public function countDistrict($divid)
    {
        $tmp = array();
        if ($divid) {
            $tmp = Electionarea::find("division=" . $divid);
        }
        return count($tmp);
    }

    public function countElectionarea($disid)
    {
        $tmp = array();
        if ($disid) {
            $tmp = Electionarea::find("district=" . $disid);
        }
        return count($tmp);
    }


    public function unitsInfo($id)
    {
        return $units = Units::findFirst("id = '$id' and active='1'");
    }

    public function getEareaInfo($id)
    {
        return $eareainfo = Electionarea::findFirst("id = '$id'");
    }

    public function getDistrictInfo($id)
    {
        return $disinfo = Zilla::findFirst("zillaid = '$id'");
    }

}
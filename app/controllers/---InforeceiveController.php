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


class InforeceiveController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateBefore('private');
    }

    public function indexAction()
    {
        $this->persistent->conditions = null;

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
        }

//echo "<pre>"; print_r($electionarea);
//exit;

        $sdate = Schedules::find(array(
            "active='1'",
            "order" => "sdate DESC"
        ));

        $this->view->sdate = $sdate;
        $this->view->electionarea = $electionarea;

    }

     public function getrecinfoAction(){

        $this->view->disable();

        $informationdate = $this->request->getQuery("idate");

        //echo $informationdate;
        $information = Informations::find(
            array("dateinfo = '".$informationdate."'",
                      "order" => "dateinfo DESC")
        );

//print_r($information);exit;
        $info_data = array();
        //$info_exist = array();
        foreach($information as $inf)
        {
            $info_data['status'][$inf->electionarea] =  $inf->status;
            $info_data['iid'][$inf->electionarea] =  $inf->id;

            //$info_exist[$inf->electionarea] = $inf->status;
        }

        //var_dump($info_exist);exit;

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


            if(array_key_exists($ea->id,$info_data['status']))
            {
                $electionarea[$ea->id]['recinfo'] = $info_data['status'][$ea->id]; //send received back resend//
                $electionarea[$ea->id]['recinfoid'] = $info_data['iid'][$ea->id];
            }
            else
            {
                $electionarea[$ea->id]['recinfo'] = 'notsend';
                $electionarea[$ea->id]['recinfoid'] = '';
            }

        }

        /*
        echo "<pre>";
        print_r($electionarea);exit;
        */

        $sdate = Schedules::find(array(
                            "active='1'",
                            "order" => "sdate DESC"
                        ));

        //echo "<pre>";
        //print_r($sdate);exit;

        $divisions = $this->unique_value_array($electionarea,'division', 'division_name');
        ///////////////////////////////////
        $html = "";
        $table_head = "<table class='table table-bordered  table-hover'>
                          <thead>
                              <tr>
                                  <th>জেলা</th>
                                  <th>নির্বাচনী এলাকা</th>
                                  <th>".$informationdate."</th>
                              </tr>
                          </thead>
                          <tbody>";

        $table_foot = "</tbody>
                    </table>";

        $i=0;
        foreach($divisions as $divkey=>$divname)
        {
            if($i>0)
            {
                $html .="<div class='tab-pane' id='tab".$divkey."'>";
            }
            else
            {
                $html .="<div class='tab-pane active' id='tab".$divkey."'>";
            }
            ////////////////////////////////////
            $html .= $table_head;

                $tmp_district = "";
                foreach($electionarea as $ea)
                {
                    if($ea['division'] == $divkey)
                    {

                        $html .= "<tr>";

                        if($tmp_district != $ea['district'])
                        {
                            $html .= "<td rowspan='".$ea['district_eacount']."'>".$ea['district_name']."</td>";
                            $tmp_district = $ea['district'];
                        }
                        $html .= "<td>".$ea['title_bn']."</td>";

                        /////////////////////////////////
                        if($ea['recinfo'] == 'send' || $ea['recinfo'] == 'resend')
                        {
                            $html .= "<td><a href='/inforeceive/infoback/".$ea['recinfoid']."' title='প্রতিবেদন পুনরায় প্রদানের জন্য প্রেরণ করুন'><i class='flaticon-email94'></i></a><a title='প্রতিবেদন গ্রহণ করুন' href='/inforeceive/inforeceived/".$ea['recinfoid']."'><i class='flaticon-receiving5'></i></a><a href='/inforeceive/view/".$ea['recinfoid']."' title='প্রতিবেদন দেখুন'><i class='flaticon-viewing'></i></a></td>";
                        }
                        else if($ea['recinfo'] == 'notsend')
                        {
                            $html .= "<td><i title='প্রতিবেদন প্রদান করা হয়নি' class='flaticon-close40'></i></td>";
                        }
                        else if($ea['recinfo'] == 'back')
                        {
                            $html .= "<td><i title='প্রতিবেদন পুনরায় প্রদানের জন্য প্রেরণ করা হয়েছে ' class='flaticon-share10'></i><a href='/infoReceive/view/".$ea['recinfoid']."' title='প্রতিবেদন দেখুন'><i class='flaticon-viewing'></i></a></td>";
                        }
                        else if($ea['recinfo'] == 'received')
                        {
                            $html .= "<td><i title='প্রতিবেদন গ্রহণ করা হয়েছে' class='flaticon-affirmative1'></i><a href='/inforeceive/view/".$ea['recinfoid']."' title='প্রতিবেদন দেখুন'><i class='flaticon-viewing'></i></a></td>";
                        }
                        ////////////////////////////////////

                        $html .= "</tr>";
                    }
                }

            $html .= $table_foot;
            ////////////////////////////////////
            $html .= "</div>";

            $i++;
        }

        /*
        $childs= array(info_data=>$html);

        $response = new \Phalcon\Http\Response();
        $response->setContentType('application/json', 'UTF-8');
        $response->setContent(json_encode($childs));
        return $response;
        */

        $response = new \Phalcon\Http\Response();
        $response->setContent($html);
        return $response;
        ///////////////////////////////////
    }


    public function inforeceivedAction($id)
    {
        $information = Informations::findFirstById($id);

        if (!$information) {
            $this->flash->error("Any Data not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        $information->assign(array(
            'status' => 'received',
            'id' => $id?$id:0,
        ));

        if (!$information->save()) {
            $this->flash->error($information->getMessages());
        } else {
            $this->flash->success("তথ্যটি সফলভাবে গৃহীত হয়েছে। ");
            Tag::resetInput();
        }

        return $this->dispatcher->forward(array(
            "controller" => "infoReceive",
            "action" => "index"
        ));
    }

    public function infobackAction($id)
    {
        $information = Informations::findFirstById($id);

        if (!$information) {
            $this->flash->error("Any Data not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        $information->assign(array(
            'status' => 'back',
            'id' => $id?$id:0,
        ));

        if (!$information->save()) {
            $this->flash->error($information->getMessages());
        } else {
            $this->flash->success("তথ্যটি সফলভাবে গৃহীত হয়েছে। ");
            Tag::resetInput();
        }

        return $this->dispatcher->forward(array(
            "controller" => "infoReceive",
            "action" => "index"
        ));
    }


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
                'division' => $this->request->getPost('division', 'striptags'),
                'id' => $id?$id:0,
            ));

            if (!$electionarea->save()) {
                $this->flash->error($electionarea->getMessages());
            } else {
                $this->flash->success("Election area was updated successfully");
                Tag::resetInput();
            }
        }
        $this->view->form = new ElectionareaForm($electionarea, array('edit' => true));
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

    public function unique_value_array($arr,$key_str,$val_str)
    {
        $new_arr;
        $i=0;
        foreach($arr as $key => $val) {
            $new_arr[$val[$key_str]] = $val[$val_str];
            $i++;
        }
        return $uniq_arr = array_unique($new_arr);
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
<?php
namespace Vokuro\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Forms\ReportsForm;
use Vokuro\Models\Informations;
use Vokuro\Models\Infodetails;

use Vokuro\Models\Domains;
use Vokuro\Models\Subdomains;
use Vokuro\Models\Units;
use Vokuro\Models\Zilla;
use Vokuro\Models\Electionarea;


class ReportsController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateBefore('private');
    }

    public function indexAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new ReportsForm();

        $logged_user_info = $this->getUserInfo();
        $this->view->user_info = $logged_user_info;
    }


    public function getreportsAction()
    {
        //var url = "/reports/getreports?datefirst="+datefirst+"&datesecond="+datesecond+"&division="+division+"&district="+district+"&electionarea="+electionarea+"&domain="+domain+"&subdomain="+subdomain;
        $this->view->disable();
        if (($this->request->isPost()) && ($this->request->isAjax() == true)) {
               $datefirst = $this->request->getQuery("datefirst", "string");
               $datesecond = $this->request->getQuery("datesecond", "string");
               $division = $this->request->getQuery("division", "int");
               $district = $this->request->getQuery("district", "int");
               $electionarea = $this->request->getQuery("electionarea", "int");
        }

        $earea_info = array();
        $district_info = array();

        if($electionarea !="")
        {
            $earea_info = $this->getEareaInfo($electionarea);
        }
        else
        {
            if($district != "")
            {
                $earea_info = $this->getEareaInfoByDid($district);
            }
            else
            {
                $earea_info = $this->getEareaInfoByDivid($division);
            }

        }

        $html = "";
        $html .= "<div class='clearfix' style='float: right; margin-bottom: 5px;'><input class='btn btn-primary' type='button' value='প্রিন্ট' onclick='print_report();'></div>";
        $html .= "<div id='printable_area'>";
        $html .= "<div class='clearfix' style='clear: both; text-align: center; font-size: 20px;'>
            <h3>উল্ল্যেখযোগ্য উন্নয়নমূলক প্রকল্প/কাজের তথ্যাদিঃ</h3>
        </div>";
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
        /*=============================================*/

        /*-------------*/
            $d_s_1;
            $d_s_2;
            $d_s_p;
        /*-------------*/
        foreach($earea_info as $eai)
        {
            $dis_name = $this->dis_name_by_ea($eai->id);
            $head = "<hr /><div style='clear: both; font-size: 16px;' class='clearfix'>
                        <div style='float: left;'><span style='font-weight: bold;'>নির্বাচনী এলাকাঃ</span>&nbsp;".$eai->title_bn."&nbsp;(".$eai->constituencies.")</div>
                        <div style='float: right;'><span style='font-weight: bold;'>জেলার নামঃ</span>&nbsp;".$dis_name."</div>
                    </div>";
            $html .=$head;

            /*------------------------------------------------------------*/
            /*----------------------data data data------------------------*/
            /*------------------------------------------------------------*/
            $info_first = Informations::findFirst("dateinfo='".$datefirst."' and electionarea='".$eai->id."'");
            $info_second = Informations::findFirst("dateinfo='".$datesecond."' and electionarea='".$eai->id."'");
            $details_first = array();
            $details_second = array();

            if($info_first && $info_second)
            {
                $info_d_first = Infodetails::find("info_id=".$info_first->id);

                //echo $info_d_first->count();exit;

                if($info_d_first->count()>0)
                {
                    foreach($info_d_first as $infod1)
                    {
                        $details_first[$infod1->subdomain_id] = (isset($infod1->amount))?$infod1->amount:0; //$r =(1 == $v) ? 'Yes' : 'No'; // $r is set to 'Yes'
                    }
                }

                $info_d_second = Infodetails::find("info_id=".$info_second->id);

                if($info_d_second->count()>0)
                {
                    foreach($info_d_second as $infod2)
                    {
                        $details_second[$infod2->subdomain_id] = (isset($infod2->amount))?$infod2->amount:0;
                    }
                }

                if(isset($info_d_first) && $info_d_first->count()>0 && isset($info_d_second) && $info_d_second->count()>0)
                {
                    foreach($domains as $domain)
                    {
                        $subdomains[$domain->id] = $domain->getSubdomains();
                        foreach($subdomains[$domain->id] as $sub)
                        {
                            $d_s_1[$domain->id][$sub->id] = (isset($details_first[$sub->id]))?$details_first[$sub->id]:0;
                            $d_s_2[$domain->id][$sub->id] = (isset($details_second[$sub->id]))?$details_second[$sub->id]:0;
                            $temp = ($d_s_2[$domain->id][$sub->id] - $d_s_1[$domain->id][$sub->id])/$d_s_1[$domain->id][$sub->id];
                            $d_s_p[$domain->id][$sub->id] = round($temp*100, 2);

                        }
                    }

                    /*------------------------------------------------------------*/
                    /*---------------------data data data---------------------*/
                    /*------------------------------------------------------------*/

                    $i=0;
                    $domain_no = 1;

                    foreach($domains as $dd)
                    {
                        if($i>0)
                        {
                            $html .= "<div class='tab-pane' id='tab".$dd->id."'>";
                        }
                        else
                        {
                            $html .= "<div style='clear: both;' class='tab-pane active' id='tab".$dd->id."'>";
                        }

                        $table_head = "<table class='table table-bordered'>
                      <thead>
                          <tr><th colspan='2'>".$dd->title."</th><th style='font-family: nikoshBan;' >".$datefirst." - এর অবস্থান(সংখ্যা/পরিমান)</th><th style='font-family: nikoshBan;' >"
                            .$datesecond." -  এর অবস্থান(সংখ্যা/পরিমান)</th><th>অগ্রগতির শতকরা হার</th></tr>
                      </thead>
                      <tbody>";

                        $html .= $table_head;
                        ////////////////////////////////////
                        $sub_domain_no=1;
                        foreach($subdomains[$dd->id] as $sub)
                        {
                            $html .= "<tr><td style='font-family: nikoshBan;' width='5%' >"
                                .$domain_no.".".$sub_domain_no."</td><td width='50%'>"
                                .$sub->title."</td><td width='15%' style='font-family: nikoshBan;' >".$d_s_1[$dd->id][$sub->id]." ".$units[$dd->id][$sub->id]->title."</td><td width='15%' style='font-family: nikoshBan;' >".$d_s_2[$dd->id][$sub->id]." "
                                .$units[$dd->id][$sub->id]->title."</td><td width='15%' style='font-family: nikoshBan;' >".$d_s_p[$dd->id][$sub->id]."%</td></tr>";
                            $sub_domain_no++;
                        } // sub domain loop end
                        ////////////////////////////////////
                        $table_foot = "</tbody>
                                </table>";
                        $html .= $table_foot;

                        $html .= "</div>";
                        $i++;
                        $domain_no++;
                    } // domain loop end
                    /*------------------------------------------------------------*/
                    /*----------------------data data data------------------------*/
                    /*------------------------------------------------------------*/

                }
                else{
                    $html .= "<div style='color: red;font-style: italic;'>অপর্যাপ্ত তথ্য রয়েছে। প্রতিবেদন তৈরি করা যায়নি।</div>";
                }
            }
            else{
                $html .= "<div style='color: red;font-style: italic;'>অপর্যাপ্ত তথ্য রয়েছে। প্রতিবেদন তৈরি করা যায়নি।</div>";
            }

        } // election area loop end
        /*==============================================*/
        $html .= "</div>"; // end of printable area

        $response = new \Phalcon\Http\Response();
        $response->setContent($html);
        return $response;
    }

    public function unitsInfo($id)
    {
       return $units = Units::findFirst("id = '$id' and active='1'");
    }

    public function getEareaInfoByDivid($id)
    {
        return $eareainfo = Electionarea::find("division = '$id'");
    }

    public function getEareaInfoByDid($id)
    {
       return $eareainfo = Electionarea::find("district = '$id'");
    }

    public function getEareaInfo($id)
    {
       return $eareainfo = Electionarea::find("id = '$id'");
    }

    public function getDistrictInfo($id)
    {
       return $disinfo = Zilla::findFirst("zillaid = '$id'");
    }

    public function dis_name_by_ea($id)
    {
        $eareainfo = Electionarea::findFirst("id = '$id'");
        $disinfo = Zilla::findFirst("zillaid = '$eareainfo->district'");
        return $disinfo->zillaname;
    }

}
<?php
namespace Vokuro\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Forms\AnalysisForm;
use Vokuro\Models\Informations;
use Vokuro\Models\Infodetails;

use Vokuro\Models\Domains;
use Vokuro\Models\Subdomains;
use Vokuro\Models\Units;
use Vokuro\Models\Zilla;
use Vokuro\Models\Electionarea;


class AnalysisController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateBefore('private');
    }

    public function indexAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new AnalysisForm();
    }


    public function getreportsAction()
    {
        //var url = tms_url+"analysis/getreports?datefirst="+datefirst+"&subdomain="+subdomain+"&eareas="+eareas;
        $this->view->disable();

        if (($this->request->isPost()) && ($this->request->isAjax() == true)) {
            $datefirst = $this->request->getQuery("datefirst", "string");
            $subdomain = $this->request->getQuery("subdomain", "int");
            $eareas = $this->request->getQuery("eareas", "string");
        }

        $election_area = explode(',',$eareas);
        $info = Informations::find("dateinfo='".$datefirst."' and electionarea in (".$eareas.")");
        $amount = array();
        $report_info = array();
        if($info->count() > 0)
        {
            foreach($info as $in)
            {
                $info_d= Infodetails::findFirst("info_id=".$in->id." and subdomain_id=".$subdomain);
                $amount[$in->electionarea]=$info_d->amount;
            }

            foreach($election_area as $ea)
            {
                if(isset($amount[$ea]))
                {
                    $report_info[$ea]=$amount[$ea];
                }
                else{
                    $report_info[$ea]=0;
                }
            }
        }
        else{
            foreach($election_area as $ea)
            {
                $report_info[$ea]=0;
            }
        }

        ////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////

        $html = '';
        $html .= '<div id="bar_of_pies" data-sort="true" data-width="800" class="jChart chart-sm" name="'.Subdomains::findFirst("id=$subdomain")->title.'('.$datefirst.'-এর প্রতিবেদন অনুযায়ী)">';

        $color_bank = array("#6B9BD6","#683091","#8BC643","#DBEAF9","#DA0000","#FFE500","#F7F7F9");

        foreach($report_info as $e=>$am)
        {
            $eareainfo = Electionarea::findFirst("id = '$e'");
            $bar_color_keys = array_rand($color_bank,2);
            $html .='<div class="define-chart-row" data-color="'.$color_bank[$bar_color_keys[0]].'" title="'.$eareainfo->title_bn.'">'.$am.'</div>';
        }

        $middle = max($report_info)/2;
        $html .='
        <div class="define-chart-footer">0</div>
        <div class="define-chart-footer">'.$middle.'</div>
        <div class="define-chart-footer">'.max($report_info).'</div>
        ';

        $html .= "</div>";

        $html .= "<script>
        $(document).ready(function() {
            $('#bar_of_pies').jChart();
        });
        </script>";
        ////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////

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
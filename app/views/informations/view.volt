<form method="post" autocomplete="off">

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("informations", "&larr; পেছনে") }}
        </li>
        <li class="pull-right">
            <input class='btn btn-primary' type='button' value='প্রিন্ট' onclick='print_report();'>
        </li>
    </ul>
{{ content() }}

<?php
/*
echo "<pre>";
print_r($info_detials);exit;
*/
$details = array();
foreach($info_detials as $infod)
{
    $details[$infod->subdomain_id] = $infod->amount;
}
                $i=0;
                $domain_no = 1;
                $datefirst = $information->dateinfo;
                $datesecond = "";
                $html = "";

                   $html .= "<div id='printable_area'>";
                    $html .= "<div class='clearfix' style='clear: both; text-align: center; font-size: 20px;'>
                           <h4>উল্ল্যেখযোগ্য উন্নয়নমূলক প্রকল্প/কাজের তথ্যাদিঃ</h4>
                       </div>";
                   $head = "<hr /><div style='clear: both; font-size: 16px;' class='clearfix'>
                               <div style='float: left;'><span style='font-weight: bold;'>নির্বাচনী এলাকাঃ</span>&nbsp;".$earea_info->title_bn."</div>
                               <div style='float: right;'><span style='font-weight: bold;'>জেলার নামঃ</span>&nbsp;".$district_info->zillaname."</div>
                           </div>";
                   $html .=$head;

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
                                 <tr><th colspan='2'>".$dd->title."</th><th style='font-family: nikoshBan;' >".$datefirst." - এর অবস্থান(সংখ্যা/পরিমান)</th></tr>
                             </thead>
                             <tbody>";

                       $html .= $table_head;
                       ////////////////////////////////////
                           $sub_domain_no=1;
                           foreach($subdomains[$dd->id] as $sub)
                           {
                                if(!isset($details[$sub->id]))
                                {
                                    $details[$sub->id] = '---';
                                }

                               $html .= "<tr><td style='font-family: nikoshBan;' width='4%' >"
                                   .$domain_no.".".$sub_domain_no."</td><td width='36%'>"
                                   .$sub->title."</td><td width='20%' style='font-family: nikoshBan;' >".$details[$sub->id]." ".$units[$dd->id][$sub->id]->title."</td></tr>";
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

                    $html .="</div>";
                   echo $html;
?>

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("informations", "&larr; পেছনে") }}
        </li>
        <li class="pull-right">
            <input class='btn btn-primary' type='button' value='প্রিন্ট' onclick='print_report();'>
        </li>
    </ul>
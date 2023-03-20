<form method="post" autocomplete="off">
    <div style="position: absolute; right: 205px; top: 93px; width: 350px;" class="highlight_div">
       <ul>
           <li><i class='flaticon-receiving5'></i>&nbsp;প্রতিবেদন প্রেরণ করা হয়েছে, গ্রহণ করুন</li>
           <li><i class='flaticon-email94'></i>&nbsp;প্রতিবেদন পুনরায় প্রদানের জন্য প্রেরণ করুন</li>
       </ul>
   </div>
    <ul class="pager" style="margin-top: 80px;">
        <li class="previous pull-left">
            {{ link_to("inforeceive", "&larr; পেছনে") }}
        </li>
        <li class="pull-right">
            <?php
            //print_r($information);exit;
            /*
            $html .= "<td><a href='javascript:void(0);' data-id='".$ea['recinfoid']
                ."' onclick='infoback(this);' title='প্রতিবেদন পুনরায় প্রদানের জন্য প্রেরণ করুন' data-msg ='আপনি কি ".$ea['title_bn']
                ." আসনের তথ্য প্রতিবেদন পুনরায় প্রদানের জন্য প্রেরণ করবেন।' class='confirmation-resend'><i class='flaticon-email94'></i></a>
                <a class='confirmation-received' onclick='inforec(this);' title='প্রতিবেদন গ্রহণ করুন'  href='javascript:void(0);'data-id='".$ea['recinfoid']
                ."' data-msg ='আপনি কি ".$ea['title_bn']
                ." আসনের তথ্য প্রতিবেদন গ্রহণ করতে চান।' ><i class='flaticon-receiving5'></i></a>
                <a  href='inforeceive/view/".$ea['recinfoid']
                ."' title='প্রতিবেদন দেখুন'><i class='flaticon-viewing'></i></a></td>";
            */
            echo "<a href='javascript:void(0);' data-id='".$information->id."' onclick='infoback(this);'
                title='প্রতিবেদন পুনরায় প্রদানের জন্য প্রেরণ করুন'
                data-msg ='আপনি কি প্রতিবেদন্তি পুনরায় প্রদানের জন্য প্রেরণ করবেন।' class='confirmation-resend'>
                <i class='flaticon-email94'></i></a>
                <a class='confirmation-received' onclick='inforec(this);' title='প্রতিবেদন গ্রহণ করুন'
                href='javascript:void(0);' data-id='".$information->id."'
                data-msg ='আপনি কি প্রতিবেদনটি গ্রহণ করতে চান।' ><i class='flaticon-receiving5'></i></a>";
            ?>
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

    <style>
    ul li
    {
        list-style: none;
    }

    i.flaticon-receiving5
    {
        color: green !important;
    }

    i.flaticon-email94
    {
        color: red !important;
    }
    </style>
{{ content() }}

<div align="left">
     {{ link_to("informations/create", "<i class='icon-plus-sign'></i> তথ্য সংযোজন করুন", "class": "btn btn-primary") }}
</div>

<?php
$table_head = "<table class='table table-bordered  table-hover'>
                  <thead>
                      <tr>";
foreach($schedules as $sc)
{
    $table_head .="<th style='font-family: nikoshBan;'>".$sc->sdate."</th>";
}

$table_head .= "</tr>
            </thead>
          <tbody>";
$table_foot = "</tbody>
            </table>";
?>

<div class="center scaffold">
    <h3><?php echo $district_info->zillaname; ?> জেলার নির্বাচনী এলাকা ভিত্তিক তথ্যের বিবরণ</h3>

    <div class="tabbable">
        <ul class="nav nav-tabs">
            <?php
            $i=0;
            foreach($electionarea as $ea)
            {
                if($i>0)
                {
                    echo "<li><a href='#tab".$ea['code']."' data-toggle='tab'><h4 style='line-height: 1px;'>".$ea['title_bn']."</h4></a></li>";
                }
                else
                {
                    echo "<li class='active'><a href='#tab".$ea['code']."' data-toggle='tab'><h4 style='line-height: 1px;'>".$ea['title_bn']."</h4></a></li>";
                }

                $i++;
            }
            ?>
        </ul>
        <div class="tab-content">
            <?php
               $i=0;
               foreach($electionarea as $ea)
               {
                    if($i>0)
                    {
                        echo "<div class='tab-pane' id='tab".$ea['code']."'>";
                    }
                    else
                    {
                        echo "<div class='tab-pane active' id='tab".$ea['code']."'>";
                    }
                    ////////////////////////////////////
                    echo $table_head;
                    echo "<tr>";

                    foreach($schedules as $sc)
                    {
                        if(isset($ea[$sc->sdate]))
                        {
                            $contents = explode('~',$ea[$sc->sdate]);
                            if($contents[1] == "send")
                            {
                                echo "<td><a href='informations/edit/".$contents[0]."'><i class='flaticon-email94'></i></a></td>";
                            }
                            else if($contents[1] == "back")
                            {
                                echo "<td><a href='informations/edit/".$contents[0]."'><i class='flaticon-receiving5'></i></a></td>";
                            }
                            else if($contents[1] == "received")
                            {
                                echo "<td><a href='informations/view/".$contents[0]."'><i class='flaticon-affirmative1'></i></a></td>";
                            }
                        }
                        else
                        {
                            echo "<td><i class='flaticon-close40'></i></td>";
                        }
                    }

                    echo "</tr>";
                    echo $table_foot;
                    ////////////////////////////////////
                    echo "</div>";
                    $i++;
                }
            ?>
        </div>
    </div>
</div>

<div style="position: absolute; right: 190px; top: 97px; width: 350px;" class="highlight_div">
   <ul>
       <li><i class='flaticon-close40'></i>&nbsp;প্রতিবেদন প্রেরণ করা হয়নি</li>
       <li><i class='flaticon-receiving5'></i>&nbsp;প্রতিবেদন ত্রুটিপূর্ণ, পুনরায় প্রেরণ করতে হবে</li>
       <li><i class='flaticon-affirmative1'></i>&nbsp;প্রতিবেদন গৃহীত হয়েছে</li>
       <li><i class='flaticon-email94'></i>&nbsp;প্রতিবেদন প্রেরণ করা হয়েছে, গ্রহণের অপেক্ষায়</li>
   </ul>
</div>

<style>
ul li
{
    list-style: none;
}
i.flaticon-close40
{
    color: red !important;
}

a i.flaticon-affirmative1, i.flaticon-affirmative1
{
    color: green !important;
}

a i.flaticon-receiving5, i.flaticon-receiving5
{
    color: red !important;
}

a i.flaticon-email94, i.flaticon-email94
{
    color: green !important;
}
</style>
{{ content() }}
<?php
/*
echo "Schedules";
echo count($schedules);
print_r($schedules);exit;
*/
//print_r($user_info);exit;

$table_head = "<table class='table table-bordered  table-hover'>
                  <thead>
                      <tr>
                          <th>জেলা</th>
                          <th>নির্বাচনী এলাকা</th>";

foreach($schedules as $sc)
{
    $table_head .="<th width='10%' style='font-family: nikoshBan;'>".$sc->sdate."</th>";
}

$table_head .= "</tr>
            </thead>
          <tbody>";

$table_foot = "</tbody>
            </table>";

$divisions = unique_value_array($electionarea,'division', 'division_name');
//print_r($divisions);exit;
?>

<div class="center scaffold">
    <?php
    if($user_info['profileid']=='5')
    {
        echo "<h2>বিভাগীয় কমিশনারের ড্যাশবোর্ড</h2>";
    }
    else
    {
        echo "<h2>এডমিন ড্যাশবোর্ড</h2>";
    }
?>
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <?php
            $i=0;

            if($user_info['profileid']=='5')
            {
                foreach($divisions as $divkey=>$divname)
                {
                    if($user_info['division'] != $divkey)
                    {
                        echo "<li style='display: none;'><a href='#tab".$divkey."' data-toggle='tab'><h4 style='line-height: 1px;'>".$divname."</h4></a></li>";
                    }
                    else
                    {
                        echo "<li class='active'><a href='#tab".$divkey."' data-toggle='tab'><h4 style='line-height: 1px;'>".$divname."</h4></a></li>";
                    }

                    $i++;
                }
            }
            else
            {
                foreach($divisions as $divkey=>$divname)
                {
                    if($i>0)
                    {
                        echo "<li><a href='#tab".$divkey."' data-toggle='tab'><h4 style='line-height: 1px;'>".$divname."</h4></a></li>";
                    }
                    else
                    {
                        echo "<li class='active'><a href='#tab".$divkey."' data-toggle='tab'><h4 style='line-height: 1px;'>".$divname."</h4></a></li>";
                    }

                    $i++;
                }
            }
            ?>

        </ul>
        <div class="tab-content">
            <?php
                $i=0;
                foreach($divisions as $divkey=>$divname)
                {
                    if($user_info['profileid']=='5')
                    {
                        if($divkey != $user_info['division'])
                        {
                            echo "<div class='tab-pane' id='tab".$divkey."'>";
                        }
                        else
                        {
                            echo "<div class='tab-pane active' id='tab".$divkey."'>";
                        }
                    }
                    else
                    {
                        if($i>0)
                        {
                            echo "<div class='tab-pane' id='tab".$divkey."'>";
                        }
                        else
                        {
                            echo "<div class='tab-pane active' id='tab".$divkey."'>";
                        }
                    }


                    ////////////////////////////////////
                    echo $table_head;

                        $tmp_district = "";
                        foreach($electionarea as $ea)
                        {
                            if($ea['division'] == $divkey)
                            {

                                echo "<tr>";
                                    if($tmp_district != $ea['district'])
                                    {
                                        echo "<td rowspan='".$ea['district_eacount']."'>".$ea['district_name']."</td>";
                                        $tmp_district = $ea['district'];
                                    }
                                    echo "<td>".$ea['title_bn']."</td>";

                                    foreach($schedules as $sc)
                                    {
                                        if(isset($ea[$sc->sdate]))
                                        {
                                            echo "<td><a href='admindash/view/".$ea[$sc->sdate]."'><i class='flaticon-affirmative1'></i></a></td>";
                                        }
                                        else
                                        {
                                            echo "<td><i class='flaticon-close40'></i></td>";
                                        }
                                    }

                                echo "</tr>";
                            }
                        }

                    echo $table_foot;
                    ////////////////////////////////////
                    echo "</div>";
                    $i++;
                }
            ?>
        </div>
    </div>
</div>
<?php
function unique_value_array($arr,$key_str,$val_str)
{
    $new_arr;
    $i=0;
    foreach($arr as $key => $val) {
        $new_arr[$val[$key_str]] = $val[$val_str];
        $i++;
    }
    return $uniq_arr = array_unique($new_arr);
}
?>


<style>

i.flaticon-close40
{
    color: red !important;
}

a i.flaticon-affirmative1
{
    color: green !important;
}

</style>
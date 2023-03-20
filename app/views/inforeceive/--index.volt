{{ content() }}

<!--<th style='font-family: nikoshBan !important;'>".$sdate->sdate."<input type='hidden' name='sdate' value='"
                          .$sdate->sdate."'><input type='hidden' name='sid' value='"
                          .$sdate->id."' /></th>-->
<?php

$table_head = "<table class='table table-bordered  table-hover'>
                  <thead>
                      <tr>
                          <th>জেলা</th>
                          <th>নির্বাচনী এলাকা</th>
                          <th></th>
                      </tr>
                  </thead>
                  <tbody>";

$table_foot = "</tbody>
            </table>";

$divisions = unique_value_array($electionarea,'division', 'division_name');
//print_r($divisions);exit;
?>

<div class="center scaffold">
    <h3 style="color: #6F3091;">তথ্য গ্রহণ বিস্তারিত</h3>

    <div class="clearfix">
       <label for="name">তারিখ</label>
          <select id="daterec" name="daterec" class="nikosh_font" onchange="load_recinfo(this)">
            <option value="">...</option>
            <option value="2013-01-01">2013-01-01</option>
            <option value="2013-07-01">2013-07-01</option>
            <option value="2014-01-01">2014-01-01</option>
            <option value="2014-07-01">2014-07-01</option>
            <option value="2015-01-01">2015-01-01</option>
          </select>
    </div>

   <div style="position: absolute; right: 215px; top: 93px; width: 350px;" class="highlight_div">
       <ul>
           <li><i class='flaticon-close40'></i>&nbsp;প্রতিবেদন প্রেরণ করা হয়নি</li>
           <li><i class='flaticon-receiving5'></i>&nbsp;প্রতিবেদন প্রেরণ করা হয়েছে, গ্রহণ করুন</li>
           <li><i class='flaticon-affirmative1'></i>&nbsp;প্রতিবেদন গ্রহণ করা হয়েছে</li>
           <li><i class='flaticon-email94'></i>&nbsp;প্রতিবেদন পুনরায় প্রদানের জন্য প্রেরণ করুন</li>
           <!--<li><i class='flaticon-share10'></i>&nbsp;প্রতিবেদন পুনরায় প্রদানের জন্য প্রেরণ করা হয়েছে </li>-->
           <li><i class='flaticon-viewing'></i>&nbsp;প্রতিবেদন দেখুন </li>
       </ul>
   </div>

    <div class="tabbable">
        <ul class="nav nav-tabs">
            <?php
            $i=0;
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
            ?>
        </ul>
        <div class="tab-content" id="div_recinfo">
            <?php
            /*
                $i=0;
                foreach($divisions as $divkey=>$divname)
                {
                    if($i>0)
                    {
                        echo "<div class='tab-pane' id='tab".$divkey."'>";
                    }
                    else
                    {
                        echo "<div class='tab-pane active' id='tab".$divkey."'>";
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
                                    echo "<td><a href='/admindash/view/7'><i class='flaticon-receiving5'></i>
                                    <i class='flaticon-affirmative1'></i><i class='flaticon-close40'></i>
                                    </a></td>";


                                echo "</tr>";
                            }
                        }

                    echo $table_foot;
                    ////////////////////////////////////
                    echo "</div>";
                    $i++;
                }
                */
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
ul li
{
    list-style: none;
}

a i.flaticon-receiving5, i.flaticon-receiving5
{
    color: green !important;
}

i.flaticon-close40
{
    color: red !important;
}

i.flaticon-affirmative1
{
    color: green !important;
}

i.flaticon-share10, i.flaticon-email94
{
    color: red !important;
}

a i.flaticon-viewing
{
    color: green !important;
}
</style>
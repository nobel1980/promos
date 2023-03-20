<form method="post" autocomplete="off">

<?php
$table_head = "<table class='table table-bordered'>
                  <thead>
                      <tr><th>#</th><th>খাতসমূহ</th><th>সংখ্যা/পরিমান</th></tr>
                  </thead>
                  <tbody>";

$table_foot = "</tbody>
            </table>";
?>

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("infoadmin", "&larr; পেছনে") }}
        </li>
        <li class="pull-right">
            {{ submit_button("সংরক্ষণ", "class": "btn btn-success") }}
        </li>
    </ul>
{{ content() }}

<h3 style="color: #713091;">বিস্তারিত তথ্য প্রদান </h3>
<div class="highlight_div" >
    <div class="clearfix">
       <label for="name">তারিখ</label>
       {{ form.render("dateinfo") }}
      <!-- <input class="input" name="dateinfo" id="date" value="" type="text"/>-->
    </div>

    <div class="row">
        <div class="span4">
           <div class="clearfix">
               <label for="name">বিভাগ</label>
               {{ form.render("division") }}
           </div>
        </div>
        <div class="span4">
            <div class="clearfix">
                  <label for="name">জেলা</label>
                  {{ form.render("district") }}
            </div>
        </div>
        <div class="clearfix">
           <label for="name">নির্বাচনী এলাকা</label>
           {{ form.render("electionarea") }}
       </div>
    </div>
</div>
<hr />
<div class="tabbable">
        <ul class="nav nav-tabs">
            <?php
            $i=0;
            foreach($domains as $dd)
            {
                if($i>0)
                {
                    echo "<li><a href='#tab".$dd->id."' data-toggle='tab'><h4 style='line-height: 1px;'>".$dd->id.". ".$dd->title."</h4></a></li>";
                }
                else
                {
                    echo "<li class='active'><a href='#tab".$dd->id."' data-toggle='tab'><h4 style='line-height: 1px;'>".$dd->id.". ".$dd->title."</h4></a></li>";
                }
                $i++;
            }
            ?>
        </ul>

        <div class="tab-content">
         <?php
            $i=0;
            $domain_no = 1;
            foreach($domains as $dd)
            {
                if($i>0)
                {
                    echo "<div class='tab-pane' id='tab".$dd->id."'>";
                }
                else
                {
                    echo "<div class='tab-pane active' id='tab".$dd->id."'>";
                }

                echo $table_head;
                ////////////////////////////////////
                    $sub_domain_no=1;
                    foreach($subdomains[$dd->id] as $sub)
                    {
                        echo "<tr><td style='font-family: nikoshBan;'>"
                            .$domain_no.".".$sub_domain_no."</td><td>"
                            .$sub->title."</td><td><input id='amount_".$dd->id."-".$sub->id."' name='amount[".$sub->id."]' type='text' value=''  /> "
                            .$units[$dd->id][$sub->id]->title."</td></tr>";
                        $sub_domain_no++;
                    }
                ////////////////////////////////////
                echo $table_foot;

                echo "</div>";
                $i++;
                $domain_no++;
            }
        ?>
        </div>
</div>

<?php
/*
$domain_no = 1;
foreach($domains as $dd)
{
    echo "<h3 class='domains_title'>".$dd->title."</h3>";
    echo "<div>";
        echo $table_head;

            $sub_domain_no=1;
            foreach($subdomains[$dd->id] as $sub)
            {
                echo "<tr><td style='font-family: nikoshBan;'>"
                    .$domain_no.".".$sub_domain_no."</td><td style='font-family: nikoshBan;'>"
                    .$sub->title."</td><td><input id='amount_".$dd->id."-".$sub->id."' name='amount[".$sub->id."]' type='text' value=''  /> "
                    .$units[$dd->id][$sub->id]->title."</td></tr>";
                $sub_domain_no++;
            }

        echo $table_foot;

    echo "</div>";

    $domain_no++;
}
//var_dump($subdomains);
*/
?>


    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("infoadmin", "&larr; পেছনে") }}
        </li>
        <li class="pull-right">
            {{ submit_button("সংরক্ষণ", "class": "btn btn-success") }}
        </li>
    </ul>

</form>
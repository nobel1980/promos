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
            {{ link_to("informations", "&larr; পেছনে") }}
        </li>
        <li class="pull-right">
            {{ submit_button("সংরক্ষণ", "class": "btn btn-success") }}
        </li>
    </ul>
{{ content() }}
{{ form.render("id") }}
    
<h3 style="color: #713091;">বিস্তারিত তথ্য প্রদান </h3>
<div class="highlight_div" >

    <div class="row">
        <div class="span4">
           <div class="clearfix">
              <label for="name">নির্বাচনী এলাকা</label>
              {{ form.render("electionarea") }}
          </div>
        </div>
        <div class="span4">
            <div class="clearfix">
               <label for="name">তারিখ</label>
               {{ form.render("dateinfo") }}
            </div>
        </div>
    </div>
</div>
<hr />

<?php
    if($information->comment):
    ?>
    <div style="font-size: 18px;">
		<span style='color: red; font-weight: bold;'>প্রতিবেদনটি ত্রুটিপূর্ণ, ত্রুটিপূর্ণ অংশগুলো সমাধানপূর্বক পুনরায় প্রেরণ করতে হবে।</span><br /><br />
           ফেরত আসার কারণঃ
            <?php
                echo "<span style='color: red; font-style: italic;'>".$information->comment."</span>";
        ?>


    </div>
	<hr />
    <?php
    endif;
    ?>

<?php
foreach($info_detials as $infod)
{
    $details[$infod->subdomain_id] = $infod->amount;
}
?>

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
                        if(!isset($details[$sub->id]))
                        {
                            $details[$sub->id] = '';
                        }

                        echo "<tr><td style='font-family: nikoshBan;'>"
                            .$domain_no.".".$sub_domain_no."</td><td>"
                            .$sub->title."</td><td><input id='amount_".$dd->id."-".$sub->id."' name='amount[".$sub->id."]' type='text' value='".$details[$sub->id]."'  /> "
                            .$units[$dd->id][$sub->id]->title." <input type='hidden' name='unit[".$sub->id."]' id='unit_".$dd->id."-".$sub->id."' value='".
                            $units[$dd->id][$sub->id]->id."' /></td></tr>";
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

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("informations", "&larr; পেছনে") }}
        </li>
        <li class="pull-right">
            {{ submit_button("সংরক্ষণ", "class": "btn btn-success") }}
        </li>
    </ul>

</form>

<script>
$(document).ready(function () {
    $("#electionarea").attr("disabled", "true");
    $("#dateinfo").attr("disabled", "true");
});
</script>
{{ content() }}


<div class="center scaffold">
    <div class="center scaffold">

        <h3>তথ্য অনুসন্ধান করুন</h3>
        <div class="highlight_div" >
            <div class="row">
                <div class="span4">
                    <div class="clearfix">
                        <label for="name">শুরুর তারিখ &nbsp;<span class="req">*</span></label>
                        {{ form.render("datefirst") }}
                    </div>
                </div>
                <div class="span4">
                    <div class="clearfix">
                        <label for="name">শেষের তারিখ &nbsp;<span class="req">*</span></label>
                        {{ form.render("datesecond") }}
                    </div>
                </div>

                <?php
                   if($user_info['profileid']=='4'){
                ?>
                <div class="span4">
                    <div class="clearfix">
                       <label for="name">নির্বাচনী এলাকা </label>
                       {{ form.render("electionarea") }}
                   </div>
                </div>
                <?php
                   }
                ?>
            </div>
        <?php
            if($user_info['profileid']=='6')
            {
        ?>
                {{ form.render("division") }}
                {{ form.render("district") }}
                {{ form.render("electionarea") }}

        <?php
            }

            else if($user_info['profileid']=='4')
            {
        ?>
                {{ form.render("division") }}
                {{ form.render("district") }}
          <?php
            }
            else
            {
          ?>
            <div class='row'>
                <div class="span4">
                   <div class="clearfix">
                       <label for="name">বিভাগ &nbsp;<span class="req">*</span></label>
                       {{ form.render("division") }}
                   </div>
                </div>
                <div class="span4">
                    <div class="clearfix">
                          <label for="name">জেলা </label>
                          {{ form.render("district") }}
                    </div>
                </div>
                <div class="clearfix">
                   <label for="name">নির্বাচনী এলাকা </label>
                   {{ form.render("electionarea") }}
               </div>
            </div>

            <?php } ?>
<!--
            <div class="row">
                <div class="span4">
                    <div class="clearfix">
                        <label for="name">খাত</label>
                        {{ form.render("domain") }}
                    </div>
                </div>
                <div class="span4">
                    <div class="clearfix">
                        <label for="name">উপখাত</label>
                        {{ form.render("subdomain") }}
                    </div>
                </div>
            </div>
-->
            <div class="clearfix">
                <input type="button" onclick="load_report();" value="প্রতিবেদন" class="btn btn-primary">
            </div>
        </div>

        <div id="div_report">

        </div>
    </div>
</form>


<script>
function validate_entry()
{
    var datefirst = $("#datefirst").val();
    var datesecond = $("#datesecond").val();
    var division = $("#division").val();
    var district = $("#district").val();

    if(datefirst=="" || datesecond=="" || division=="")
    {
        alert("সকল আবশ্যকীয় তথ্য প্রদান করুন");
        return false;
    }

    return true;
}

</script>
<style>
span.req
{
    color: red;
}
</style>
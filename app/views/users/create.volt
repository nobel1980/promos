
<form method="post" autocomplete="off">

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("users", "&larr; Go Back") }}
    </li>
    <li class="pull-right">
        {{ submit_button("Save", "class": "btn btn-success") }}
    </li>
</ul>

{{ content() }}

<div class="center scaffold">
    <h2>Create a User</h2>

    <div class="clearfix">
        <label for="name">Name</label>
        {{ form.render("name") }}
    </div>

    <div class="clearfix">
        <label for="email">E-Mail</label>
        {{ form.render("email") }}
    </div>

    <div class="clearfix">
        <label for="profilesId">Profile</label>
        {{ form.render("profilesId") }}
    </div>

    <div class="clearfix"  id="division_div">
        <label for="district">Division</label>
        {{ form.render("division") }}
    </div>

    <div class="clearfix" id="district_div">
        <label for="district">District</label>
        {{ form.render("district") }}
    </div>

    <div class="clearfix" id="ea_div">
        <label for="district">Election Area</label>
        {{ form.render("electionarea") }}
    </div>
</div>

</form>

<style>
#division_div
{
    display: none;
}
#district_div
{
    display: none;
}
</style>
<script>
function showZilla(sel)
{
    $("#district").val("");
    if(sel == '4')
    {
        $("#district_div").show();
    }
    else
    {
        $("#district_div").hide();
    }

}
function showDivision(sel)
{
    $("#division").val("");
    if(sel == '5')
    {
        $("#division_div").show();
    }
    else
    {
        $("#division_div").hide();
    }
}

function showElectionarea(sel)
{
    $("#electionarea").val("");
    if(sel == '6')
    {
        $("#ea_div").show();
    }
    else
    {
        $("#ea_div").hide();
    }
}
</script>
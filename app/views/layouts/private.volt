{{ stylesheet_link('css/bootstrap.min.css') }}
{{ stylesheet_link('css/style_back.css') }}
<?php
    $url = new Phalcon\Mvc\Url();
$promos = '/';
?>
<div id="body-height" class="body-container">
    <div class="navbar navbar-inverse navbar-fixed-top" id="first_bar">
      <div class="container">
        <div class="navbar-header">
          <a href="http://promos.gov.bd"><img  id="promos_logo" height="40" src="<?php echo $promos; ?>image/promos-logo-body-op.png" /><span id="govstatus">উন্নয়নমূলক কার্যক্রম পরিবীক্ষণ সিস্টেম (ProMoS)</span></a>
          <img id="gov_logo" height="40" src="<?php echo $promos; ?>image/bdgovlogo.png" />
        </div>
      </div>
    </div>
<?php
$array_resource = array("users"=>"ব্যবহারকারী","profiles"=>"প্রোফাইল","permissions"=>"অনুমোদন","electionarea"=>"নির্বাচনী এলাকা","zilla"=>"জেলা","division"=>"বিভাগ","units"=>"ইউনিট","domains"=>"খাত",
                    "subdomains"=>"উপখাত","schedules"=>"শিডিউল","admindash"=>"ড্যাশবোর্ড","informations"=>"তথ্য সংযোজন","infoadmin"=>"সার্বিক তথ্য প্রদান","reports"=>"প্রতিবেদন","analysis"=>"ডাটা এনালাইসিস","inforeceive"=>"তথ্য গ্রহণ");
$array_cat = array("users"=>"ব্যবহারকারী","settings"=>"সেটিংস","info"=>"তথ্য" );
//print_r($this->acl->getResourcesPrivate());exit;

?>
    <div class="navbar-inverse navbar-fixed-top" id="second_bar">
        <div class="container" style="width: auto;">
            <div class="nav-collapse">
                <?php
                 echo '<ul class="nav" style="width: 60%;margin-left: 120px;">';
                 $t=1;
                foreach($this->acl->getResourcesPrivate() as $key=>$varray)
                {
                        echo '<li class="dropdown">';
                            echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$array_cat[$key].'<b class="caret"></b></a>';
                            echo '<ul class="dropdown-menu" id="menu_'.$t.'">';
                            foreach($varray as $va)
                            {
                                echo '<li><a href="'.$promos.$va.'">'.$array_resource[$va].'</a></li>';
                            }
                            echo '</ul>';
                        echo '</li>';
                        $t++;
                }
                echo '</ul>';
                ?>
                <ul style="width: 35%;margin-top: -60px;margin-right: -112px;" class="nav pull-right">
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ auth.getName() }} <b class="caret"></b></a>
                    <ul class="dropdown-menu" id="pass_menu">
                      <li>{{ link_to('users/changePassword', 'পাসওয়ার্ড পরিবর্তন') }}</li>
                    </ul>
                  </li>
                  <li style="font-size: 18px;">{{ link_to('session/logout', 'লগআউট') }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container" style="min-height: 470px;">
      {{ content() }}
    </div>
</div>
<footer  style="position: fixed; bottom: 0px; left: 0px; width: 100%;height: 40px;line-height: 45px; ">
    <div class="container">
        <!--<p class="pull-right muted credit">© ২০১৩-২০১৪ একসেস টু ইনফরমেশন (এটুআই) প্রোগ্রাম, প্রধানমন্ত্রীর কার্যালয়</p>-->
        <p class="credit" style="float: left; margin-left: -105px;">প্রযুক্তি সহায়তায়ঃ <img  width="40" height="40" src="<?php echo $promos; ?>image/a2ilogo.png"> একসেস টু ইনফরমেশন (এটুআই) প্রোগ্রাম। </p>
        <p class="credit"  style="float: right; margin-right: -10px;">কপিরাইটঃ প্রধানমন্ত্রীর কার্যালয়।</p>
    </div>
</footer>

<style>
.nav > li > a {
 float: left;
}
</style>
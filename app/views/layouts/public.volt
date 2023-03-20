{{ stylesheet_link('css/signin.css') }}
<?php
$promos = '/promos/';
?>
<div id="body-height" class="body-container">
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header" style="width: 100%;margin-left: -30px;">
          <a class="navbar-brand" href="#"><a href="#"><img height="40" src="<?php echo $promos; ?>image/bdgovlogo.png" /><span id="govstatus">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</span></a>
        </div>
        <div class="navbar-collapse collapse">
        </div><!--/.navbar-collapse -->
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-8 site-intro">
          <h3>উন্নয়ন পরিবীক্ষণ সিস্টেম (ProMoS)</h3>
          <p style="font-size: 17px;">গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের জেলা ও নির্বাচনী এলাকাভিত্তিক গুরুত্বপূর্ণ উন্নয়নমূলক কার্যক্রমের তথ্যাবলি সংরক্ষণ, প্রাপ্ত তথ্যাদি বিশ্লেষণপূর্বক প্রতিবেদন প্রণয়ন এবং প্রকল্পের অগ্রগতি পর্যবেক্ষণ ও মূল্যায়নের লক্ষ্যে এই সিস্টেমটি তৈরি করা হয়েছে।</p>

          <hr />
          <a href="<?php echo $promos; ?>manual/ProMoS_UserManual.docx" style="margin-top: 0px;font-size: 20px;text-decoration: none;float: left;margin-left: -15px;"><i class="flaticon-open163"></i>  ব্যবহার নির্দেশিকা</a>
        </div>

        {{ content() }}

      </div>
    </div> <!-- /container -->
</div>

<footer  style="position: fixed; bottom: 0px; left: 0px; width: 100%;">
    <div class="container">
         <!--<p class="pull-right muted credit">© ২০১৩-২০১৪ একসেস টু ইনফরমেশন (এটুআই) প্রোগ্রাম, প্রধানমন্ত্রীর কার্যালয়</p>-->
               <p style="float: left; margin-left: -15px;font-size: 18px;" class="muted  credit">প্রযুক্তি সহায়তায়ঃ <img height="40" src="<?php echo $promos; ?>image/a2ilogo.png"> একসেস টু ইনফরমেশন (এটুআই) প্রোগ্রাম। </p>
                               <p class="pull-right muted  credit" style="float: right; margin-right: -15px;font-size: 18px;">কপিরাইটঃ প্রধানমন্ত্রীর কার্যালয়।</p>
    </div>
</footer>
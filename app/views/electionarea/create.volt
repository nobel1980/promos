<form method="post" autocomplete="off">

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("electionarea", "&larr; পেছনে") }}
        </li>
        <li class="pull-right">
            {{ submit_button("সংরক্ষণ", "class": "btn btn-success") }}
        </li>
    </ul>
{{ content() }}

<div class="center scaffold">

    <h2> নির্বাচনী এলাকা তৈরি</h2>

   <div class="clearfix">
       <label for="name">নাম (বাংলা)</label>
       {{ form.render("title_bn") }}
   </div>

    <div class="clearfix">
       <label for="name">নাম (ইংরেজি)</label>
       {{ form.render("title_en") }}
   </div>

   <div class="clearfix">
       <label for="name">কোড</label>
       {{ form.render("code") }}
   </div>

   <div class="clearfix">
       <label for="name">বিভাগ</label>
       {{ form.render("division") }}
   </div>

    <div class="clearfix">
       <label for="name">জেলা</label>
       {{ form.render("district") }}
   </div>

   <div class="clearfix">
          <label for="name">এলাকা</label>
          {{ form.render("constituencies") }}
      </div>

</div>
    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("electionarea", "&larr; পেছনে") }}
        </li>
        <li class="pull-right">
            {{ submit_button("সংরক্ষণ", "class": "btn btn-success") }}
        </li>
    </ul>

</form>
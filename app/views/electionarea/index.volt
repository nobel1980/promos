{{ content() }}

<div align="right">
     {{ link_to("electionarea/create", "<i class='icon-plus-sign'></i> নির্বাচনী এলাকা তৈরি", "class": "btn btn-primary") }}
</div>

<form method="post" action="{{ url("electionarea/search") }}" autocomplete="off">

    <div class="center scaffold">

        <h2>নির্বাচনী এলাকা অনুসন্ধান করুন</h2>

        <div class="clearfix">
            <label for="name">নাম (বাংলা)</label>
            {{ form.render("title_bn") }}
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
            {{ submit_button("খুঁজুন", "class": "btn btn-primary") }}
        </div>

    </div>

</form>
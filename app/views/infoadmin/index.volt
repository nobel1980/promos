{{ content() }}

<div align="right">
     {{ link_to("infoadmin/create", "<i class='icon-plus-sign'></i> তথ্য প্রদান করুন", "class": "btn btn-primary") }}
</div>

<form method="post" action="{{ url("infoadmin/search") }}" autocomplete="off">

    <div class="center scaffold">

        <h2>তথ্য অনুসন্ধান করুন</h2>

        <div class="clearfix">
            <label for="name">তারিখ</label>
            {{ form.render("dateinfo") }}
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
            <label for="name">নির্বাচনী এলাকা</label>
            {{ form.render("electionarea") }}
        </div>

        <div class="clearfix">
            {{ submit_button("খুঁজুন", "class": "btn btn-primary") }}
        </div>

    </div>

</form>
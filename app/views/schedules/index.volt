{{ content() }}

<div align="right">
    {{ link_to("schedules/create", "<i class='icon-plus-sign'></i> শিডিউল তৈরি", "class": "btn btn-primary") }}
</div>

<form method="post" action="{{ url("schedules/search") }}" autocomplete="off">

    <div class="center scaffold">

        <h2>শিডিউল অনুসন্ধান করুন</h2>

        <div class="clearfix">
            <label for="name">শিডিউলের তারিখ</label>
            {{ form.render("sdate") }}
        </div>

        <div class="clearfix">
            {{ submit_button("খুঁজুন", "class": "btn btn-primary") }}
        </div>

    </div>

</form>
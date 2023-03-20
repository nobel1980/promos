{{ content() }}

<div align="right">
    {{ link_to("Units/create", "<i class='icon-plus-sign'></i> ইউনিট তৈরি", "class": "btn btn-primary") }}
</div>

<form method="post" action="{{ url("Units/search") }}" autocomplete="off">

    <div class="center scaffold">

        <h2>ইউনিট অনুসন্ধান করুন</h2>

        <div class="clearfix">
            <label for="name">শিরোনাম</label>
            {{ form.render("title") }}
        </div>

        <div class="clearfix">
            <label for="name">বর্ণনা</label>
            {{ form.render("description") }}
        </div>
        <div class="clearfix">
            {{ submit_button("খুঁজুন", "class": "btn btn-primary") }}
        </div>

    </div>

</form>
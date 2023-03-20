{{ content() }}

<div align="right">
    {{ link_to("zilla/create", "<i class='icon-plus-sign'></i> জিলা তৈরি", "class": "btn btn-primary") }}
</div>

<form method="post" action="{{ url("zilla/search") }}" autocomplete="off">

    <div class="center scaffold">

        <h2>জিলা অনুসন্ধান</h2>

        <div class="clearfix">
            <label for="name">জিলার নাম</label>
            {{ form.render("zillaname") }}
        </div>
        <div class="clearfix">
            <label for="name">বিভাগ</label>
            {{ form.render("divid") }}
        </div>

        <div class="clearfix">
            {{ submit_button("খুঁজুন", "class": "btn btn-primary") }}
        </div>

    </div>

</form>
{{ content() }}

<div align="right">
    {{ link_to("Division/create", "<i class='icon-plus-sign'></i> বিভাগ তৈরি", "class": "btn btn-primary") }}
</div>

<form method="post" action="{{ url("Division/search") }}" autocomplete="off">

    <div class="center scaffold">

        <h2>বিভাগ অনুসন্ধান করুন</h2>

        <div class="clearfix">
            <label for="name">বিভাগের নাম</label>
            {{ form.render("divname") }}
        </div>

        <div class="clearfix">
            {{ submit_button("খুঁজুন", "class": "btn btn-primary") }}
        </div>

    </div>

</form>
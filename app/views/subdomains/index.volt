{{ content() }}

<div align="right">
    {{ link_to("subdomains/create", "<i class='icon-plus-sign'></i> উপখাত তৈরি", "class": "btn btn-primary") }}
</div>

<form method="post" action="{{ url("subdomains/search") }}" autocomplete="off">

    <div class="center scaffold">

        <h2>উপখাত অনুসন্ধান</h2>

        <div class="clearfix">
            <label for="name">শিরোনাম</label>
            {{ form.render("title") }}
        </div>
        <div class="clearfix">
            <label for="name">খাত</label>
            {{ form.render("domain_id") }}
        </div>

        <div class="clearfix">
            {{ submit_button("খুঁজুন", "class": "btn btn-primary") }}
        </div>

    </div>

</form>
{{ content() }}

<div align="right">
    {{ link_to("domains/create", "<i class='icon-plus-sign'></i> প্রধান খাত তৈরি", "class": "btn btn-primary") }}
</div>

<form method="post" action="{{ url("domains/search") }}" autocomplete="off">

    <div class="center scaffold">

        <h2>প্রধান খাত অনুসন্ধান করুন</h2>

        <div class="clearfix">
            <label for="name">শিরোনাম</label>
            {{ form.render("title") }}
        </div>
        <div class="clearfix">
            <label for="name">বর্ননা</label>
            {{ form.render("description") }}
        </div>

        <div class="clearfix">
            {{ submit_button("খুঁজুন", "class": "btn btn-primary") }}
        </div>

    </div>

</form>
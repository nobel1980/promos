<form method="post" autocomplete="off">

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("units", "&larr; পেছনে") }}
        </li>
        <li class="pull-right">
            {{ submit_button("সংরক্ষণ", "class": "btn btn-success") }}
        </li>
    </ul>
    {{ content() }}

    <div class="center scaffold">

        <h2> ইউনিট সম্পাদনা</h2>
        {{ form.render("id") }}


        <div class="clearfix">
            <label for="name">শিরোনাম</label>
            {{ form.render("title") }}
        </div>

        <div class="clearfix">
            <label for="name">বর্ণনা</label>
            {{ form.render("description") }}
        </div>

        <div class="clearfix">
            <label for="name">অবস্থা</label>
            {{ form.render("active") }}
        </div>
    </div>
    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("units", "&larr; পেছনে") }}
        </li>
        <li class="pull-right">
            {{ submit_button("সংরক্ষণ", "class": "btn btn-success") }}
        </li>
    </ul>

</form>
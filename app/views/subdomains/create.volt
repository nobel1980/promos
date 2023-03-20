<form method="post" autocomplete="off">

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("subdomains/list", "&larr; পেছনে") }}
        </li>
        <li class="pull-right">
            {{ submit_button("সংরক্ষণ", "class": "btn btn-success") }}
        </li>
    </ul>
{{ content() }}

<div class="center scaffold">

    <h2>উপখাত তৈরি</h2>

    <div class="clearfix">
        <label for="name">শিরোনাম</label>
        {{ form.render("title") }}
    </div>

    <div class="clearfix">
        <label for="name">প্রধান খাত</label>
        {{ form.render("domain_id") }}
    </div>

     <div class="clearfix">
        <label for="name">ইউনিট</label>
        {{ form.render("unit_id") }}
    </div>

    <div class="clearfix">
        <label for="name">ক্রম</label>
        {{ form.render("weight") }}
    </div>

     <div class="clearfix">
        <label for="name">অবস্থা</label>
        {{ form.render("active") }}
    </div>

</div>
    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("subdomains/list", "&larr; পেছনে") }}
        </li>
        <li class="pull-right">
            {{ submit_button("সংরক্ষণ", "class": "btn btn-success") }}
        </li>
    </ul>

</form>
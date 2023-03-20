<form method="post" autocomplete="off">

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("zilla/index", "&larr; পেছনে") }}
        </li>
        <li class="pull-right">
            {{ submit_button("সংরক্ষণ", "class": "btn btn-success") }}
        </li>
    </ul>
    {{ content() }}

    <div class="center scaffold">

        <h2>জিলা সম্পাদনা</h2>
        {{ form.render("zillaid") }}

         <div class="clearfix">
            <label for="name">জিলার নাম</label>
            {{ form.render("zillaname") }}
        </div>

        <div class="clearfix">
            <label for="name">বিভাগের নাম</label>
            {{ form.render("divid") }}
        </div>

         <div class="clearfix">
            <label for="name">অবস্থা</label>
            {{ form.render("active") }}
        </div>

    </div>
    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("zilla/list", "&larr; পেছনে") }}
        </li>
        <li class="pull-right">
            {{ submit_button("সংরক্ষণ", "class": "btn btn-success") }}
        </li>
    </ul>

</form>
<form method="post" autocomplete="off">

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("division", "&larr; পেছনে") }}
        </li>
        <li class="pull-right">
            {{ submit_button("সংরক্ষণ", "class": "btn btn-success") }}
        </li>
    </ul>
    {{ content() }}

    <div class="center scaffold">

        <h2> বিভাগ সম্পাদনা</h2>
        {{ form.render("divid") }}


        <div class="clearfix">
            <label for="divname">বিভাগের নাম</label>
            {{ form.render("divname") }}
        </div>

        <div class="clearfix">
            <label for="name">অবস্থা</label>
            {{ form.render("active") }}
        </div>
    </div>
    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("division", "&larr; পেছনে") }}
        </li>
        <li class="pull-right">
            {{ submit_button("সংরক্ষণ", "class": "btn btn-success") }}
        </li>
    </ul>

</form>
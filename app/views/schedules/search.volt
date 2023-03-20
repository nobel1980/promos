{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("schedules/index", "&larr; পেছনে") }}
    </li>
    <li class="pull-right">
        {{ link_to("schedules/create", "শিডিউল তৈরি", "class": "btn btn-primary") }}
    </li>
</ul>

{% for schedules in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>তারিখ</th>
            <th>অবস্থা</th>
            <th>কার্যক্রম</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ schedules.sdate }}</td>
            <td>
            <?php
            if($schedules->active== 1)
            {
                echo "<i class='flaticon-affirmative1 green'></i>";
            }
            else
            {
                echo "<i class='flaticon-close40 red'>";
            }
            ?>

            </td>
            <td width="">
                {{ link_to("schedules/edit/" ~ schedules.id, '<i class="icon-pencil"></i>', "class": "btn") }}
                {{ link_to("schedules/delete/" ~ schedules.id, '<i class="icon-remove"></i>', "class": "btn") }}
            </td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("schedules/search", '<i class="icon-fast-backward"></i> শুরু', "class": "btn") }}
                    {{ link_to("schedules/search?page=" ~ page.before, '<i class="icon-step-backward"></i> আগে', "class": "btn ") }}
                    {{ link_to("schedules/search?page=" ~ page.next, '<i class="icon-step-forward"></i> পরে', "class": "btn") }}
                    {{ link_to("schedules/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> শেষ', "class": "btn") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    কোন শিডিউল খুঁজে পাওয়া যায়নি
{% endfor %}

<style>
i.flaticon-receiving5
{
    color: orange !important;
}
i.flaticon-close40
{
    color: red !important;
}
i.flaticon-affirmative1
{
    color: green !important;
}
</style>
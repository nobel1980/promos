{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("zilla/index", "&larr; পেছনে") }}
    </li>
    <li class="pull-right">
        {{ link_to("zilla/create", "জিলা তৈরি", "class": "btn btn-primary") }}
    </li>
</ul>

{% for zilla in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>ক্রমিক</th>
            <th>জিলার নাম</th>
            <th>বিভাগের নাম</th>
            <th>কার্যক্রম</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ zilla.zillaid }}</td>
            <td>{{ zilla.zillaname }}</td>
            <td>{{zilla.divid}}</td>
            <td width="">
                {{ link_to("zilla/edit/" ~ zilla.zillaid, '<i class="icon-pencil"></i>', "class": "btn") }}
                {{ link_to("zilla/delete/" ~ zilla.zillaid, '<i class="icon-remove"></i>', "class": "btn") }}
            </td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("zilla/search", '<i class="icon-fast-backward"></i> শুরু', "class": "btn") }}
                    {{ link_to("zilla/search?page=" ~ page.before, '<i class="icon-step-backward"></i> আগে', "class": "btn ") }}
                    {{ link_to("zilla/search?page=" ~ page.next, '<i class="icon-step-forward"></i> পরে', "class": "btn") }}
                    {{ link_to("zilla/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> শেষ', "class": "btn") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    কোন উপখাত পাওয়া যায়নি
{% endfor %}

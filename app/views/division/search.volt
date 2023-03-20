{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("division/index", "&larr; পেছনে") }}
    </li>
    <li class="pull-right">
        {{ link_to("division/create", "বিভাগ তৈরি", "class": "btn btn-primary") }}
    </li>
</ul>

{% for division in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>শিরোনাম</th>
            <th>কার্যক্রম</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ division.divname }}</td>
            <td width="">
                {{ link_to("division/edit/" ~ division.divid, '<i class="icon-pencil"></i>', "class": "btn") }}
                {{ link_to("division/delete/" ~ division.divid, '<i class="icon-remove"></i>', "class": "btn") }}
            </td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("division/search", '<i class="icon-fast-backward"></i> শুরু', "class": "btn") }}
                    {{ link_to("division/search?page=" ~ page.before, '<i class="icon-step-backward"></i> আগে', "class": "btn ") }}
                    {{ link_to("division/search?page=" ~ page.next, '<i class="icon-step-forward"></i> পরে', "class": "btn") }}
                    {{ link_to("division/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> শেষ', "class": "btn") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    কোন খাত খুঁজে পাওয়া যায়নি
{% endfor %}

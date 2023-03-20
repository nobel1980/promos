{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("units/index", "&larr; পেছনে") }}
    </li>
    <li class="pull-right">
        {{ link_to("units/create", "ইউনিট তৈরি", "class": "btn btn-primary") }}
    </li>
</ul>

{% for units in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>শিরোনাম</th>
            <th>বর্ণনা</th>
            <th>কার্যক্রম</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ units.title }}</td>
            <td>{{ units.description }}</td>
            <td width="">
                {{ link_to("units/edit/" ~ units.id, '<i class="icon-pencil"></i>', "class": "btn") }}
                {{ link_to("units/delete/" ~ units.id, '<i class="icon-remove"></i>', "class": "btn") }}
            </td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("units/search", '<i class="icon-fast-backward"></i> শুরু', "class": "btn") }}
                    {{ link_to("units/search?page=" ~ page.before, '<i class="icon-step-backward"></i> আগে', "class": "btn ") }}
                    {{ link_to("units/search?page=" ~ page.next, '<i class="icon-step-forward"></i> পরে', "class": "btn") }}
                    {{ link_to("units/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> শেষ', "class": "btn") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    কোন ইউনিট খুঁজে পাওয়া যায়নি
{% endfor %}

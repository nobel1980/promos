{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("informations/index", "&larr; পেছনে") }}
    </li>
    <li class="pull-right">
        {{ link_to("informations/create", "তথ্য প্রদান করুন", "class": "btn btn-primary") }}
    </li>
</ul>

{% for earea in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>তারিখ</th>
            <th>নির্বাচনী এলাকা</th>
            <th>জেলা</th>
            <th>বিভাগ</th>
            <th>---</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ earea.dateinfo }}</td>
            <td>{{ earea.electionarea }}</td>
            <td>{{ earea.district }}</td>
            <td>{{ earea.division }}</td>
            <td width="">
                {{ link_to("informations/edit/" ~ earea.id, '<i class="icon-pencil"></i>', "class": "btn") }}
                {{ link_to("informations/delete/" ~ earea.id, '<i class="icon-remove"></i>', "class": "btn") }}
            </td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("informations/search", '<i class="icon-fast-backward"></i> প্রথম', "class": "btn") }}
                    {{ link_to("informations/search?page=" ~ page.before, '<i class="icon-step-backward"></i> আগে', "class": "btn ") }}
                    {{ link_to("informations/search?page=" ~ page.next, '<i class="icon-step-forward"></i> পরে', "class": "btn") }}
                    {{ link_to("informations/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> শেষ', "class": "btn") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    কোন তথ্য পাওয়া যায়নি
{% endfor %}

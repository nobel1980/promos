{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("electionarea/index", "&larr; পেছনে") }}
    </li>
    <li class="pull-right">
        {{ link_to("electionarea/create", "নির্বাচনী এলাকা তৈরি", "class": "btn btn-primary") }}
    </li>
</ul>

{% for earea in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>কোড</th>
            <th>নাম</th>
            <th>জেলা</th>
            <th>এলাকা</th>
            <th>বিভাগ</th>
            <th>কার্যক্রম</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ earea.code }}</td>
            <td>{{ earea.title_bn }}</td>
            <td>{{ earea.district }}</td>
            <td>{{ earea.constituencies }}</td>
            <td>{{ earea.division }}</td>
            <td width="">
                {{ link_to("electionarea/edit/" ~ earea.id, '<i class="icon-pencil"></i>', "class": "btn") }}
                {{ link_to("electionarea/delete/" ~ earea.id, '<i class="icon-remove"></i>', "class": "btn") }}
            </td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("electionarea/search", '<i class="icon-fast-backward"></i> শুরু', "class": "btn") }}
                    {{ link_to("electionarea/search?page=" ~ page.before, '<i class="icon-step-backward"></i> আগে', "class": "btn ") }}
                    {{ link_to("electionarea/search?page=" ~ page.next, '<i class="icon-step-forward"></i> পরে', "class": "btn") }}
                    {{ link_to("electionarea/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> শেষ', "class": "btn") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    কোন নির্বাচনী এলাকা পাওয়া যায়নি
{% endfor %}

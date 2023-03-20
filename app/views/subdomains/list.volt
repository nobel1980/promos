{{ content() }}

<div class="center scaffold">
    <h2>Sub Category List</h2>

{% for subdomain in subdomains %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
    <tr>
        <th>Title</th>
        <th>Action</th>
    </tr>
    </thead>
    {% endif %}
    <tbody>
    <tr>
        <td>{{ subdomain.title }}</td>
        <td width="">
            {{ link_to("subdomains/edit?id=" ~ subdomain.id, '<i class="icon-list"></i>', "class": "btn") }}
        </td>
    </tr>
    </tbody>
    {% if loop.last %}
</table>
{% endif %}
{% else %}
No Sub category are recorded
{% endfor %}
</div>
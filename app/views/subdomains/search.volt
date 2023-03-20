{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("subdomains/index", "&larr; পেছনে") }}
    </li>
    <li class="pull-right">
        {{ link_to("subdomains/create", "উপখাত তৈরি", "class": "btn btn-primary") }}
    </li>
</ul>

<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>ক্রমিক</th>
            <th>শিরোনাম</th>
            <th>প্রধান খাত</th>
            <th>কার্যক্রম</th>
        </tr>
    </thead>
    <tbody>

<?php
/*
echo "<pre>";
print_r($data_sub);exit;
*/
foreach($data_sub as $subdomain)
{
?>
        <tr>
            <td><?php echo $subdomain['no'];?></td>
            <td><?php echo $subdomain['title'];?></td>
            <td><?php echo $subdomain['domain'];?></td>

            <td width="">
                <?php
                    echo "<a class='btn' href='subdomains/edit/".$subdomain['id']."'><i class='icon-pencil'></i></a>";
                    echo "<a class='btn' href='subdomains/delete/".$subdomain['id']."'><i class='icon-remove'></i></a>";
                ?>
            </td>
        </tr>
<?php
}
?>
</tbody>
</table>
<?php 
    $noFields = ['client_id', 'manager_id'];
?>

<a href="/loads/export">export</a>
<a href="/loads/add">add</a>
<a href="?manager">New loads</a>
<a href="/">loads</a>

<?php if (!$list) { ?>
    <br>
    no data

    <?php exit; ?>
<?php } ?>

<table>
    <tr>
        <?php foreach (array_keys($list[0]) as $value) { ?>
            <?php if (!in_array($value, $noFields)) { ?>
                <td><?= $value ?></td>
            <?php } ?>
        <?php } ?>
    </tr>

    <?php foreach ($list as $row) { ?>
        <tr>
            <?php foreach ($row as $key => $value) { ?>
                <?php if (in_array($key, ['client', 'manager'])) { ?>
                    <td><a href="/<?= $key ?>s/<?= $row[$key . '_id'] ?>"><?= $value ?></a></td>
                <?php } else if (!in_array($key, $noFields)) { ?>
                    <?php if (($row['client_id'] == $client) || ($row['manager_id'] == $manager)) { ?>
                        <td><a href="/loads/add/<?= $row['id'] ?>"><?= $value ?></a></td>
                    <?php } else { ?>
                        <td><?= $value ?></td>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <?php if (isset($_GET['manager'])) { ?>
                <td>
                    <a href="/loads/take/<?= $row['id'] ?>">take</a>
                </td>
            <?php } ?>
        </tr>
    <?php } ?>
</table>

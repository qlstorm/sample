<?php 
    $noFields = []; 
?>

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
                <?php if (in_array($key, [])) { ?>
                    <td><a href="/<?= $key ?>s/<?= $row[$key . '_id'] ?>"><?= $value ?></a></td>
                <?php } else { ?>
                    <?php if (!in_array($key, $noFields)) { ?>
                        <td><?= $value ?></td>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </tr>
    <?php } ?>
</table>
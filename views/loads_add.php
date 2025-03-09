<form style="width: 200px" method="POST">
    <?php if (isset($row['id'])) { ?>
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <?php } ?>

    <?php if (!isset($row['client']) || $row['client'] == $client) { ?>
        container <input name="container" value="<?= $row['container'] ?>" style="width: 100%;"><br><br>
    <?php } ?>
    
    <?php if (isset($row['manager']) && $row['manager'] == $manager) { ?>
        status <input name="status" value="<?= $row['status'] ?>" style="width: 100%;"><br><br>
    <?php } ?>

    <?php if (!isset($row['client'])) { ?>
        <input type="hidden" name="client" value="<?= $client ?>">
    <?php } ?>

    <div style="text-align: right;">
        <input type="submit">
    </div>
</form>
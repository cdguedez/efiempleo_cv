<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo get_admin_page_title() ?></h1>
    <?php if($_GET['message']) { ?>
        <div class="notice notice-success is-dismissible"><p><?php echo $_GET['message']; ?></p></div>
    <?php } ?>
    <form action="<?php echo EFI_PLUGIN_DIR.'includes/upload_csv.php' ?>" enctype="multipart/form-data" method="post">
        <label for="dataCsv">Carga tu archivo con CV</label>
        <input type="file" name="dataCsv" id="dataCsv" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" aria-required="true" autocapitalize="none" autocorrect="off" maxlength="60" required >
        <button type="submit" class="button button-primary">Cargar CV's</button>
    </form>
    <br />
    <table class="wp-list-table widefat fixed striped table-view-list posts">
        <thead>
            <tr>
                <th>Cantidad de registros</th>
                <th>Fecha de subida</th>
                <th>Nombre del archivo</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>1.590</th>
                <th>15 Abr, 2021</th>
                <th>Carga primer lote</th>
            </tr>
        </tbody>
    </table>
    <p><?php echo '<br>'. round(memory_get_usage()/1048576) . "MB"; ?></p>
</div>

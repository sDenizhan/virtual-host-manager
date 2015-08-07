<?php
include 'config.php';
include 'header.php';

$db = file_get_contents($config['db']);
$siteler = unserialize($db);

if (!empty($siteler)) {
    ?>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="alert hide" id="delresult">

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12">

            <div class="panel panel-default panel-success">
                <!-- Default panel contents -->
                <div class="panel-heading">Sanal Hostlar</div>

                <!-- Table -->
                <table class="table table-bordered table-responsive">
                    <thead>
                    <tr>
                        <th>Sanal Alan</th>
                        <th>Siteye Git</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($siteler as $site): ?>
                        <tr>
                            <td><?php echo $site['url']; ?></td>
                            <td><a href="<?php echo 'http://' . $site['url']; ?>" target="_blank"
                                   class="btn btn-primary"><span class="glyphicon glyphicon-link"></span> Siteye Git</a>
                            </td>
                            <td>
                                <a href="del_vhost.php?file=<?php echo $site['conf']; ?>"
                                   class="btn btn-danger btn-sm del-link"><span
                                        class="glyphicon glyphicon-remove"></span> Sil</a>
                                <a href="edit_vhost.php?file=<?php echo $site['conf']; ?>"
                                   class="btn btn-success btn-sm"><span class="glyphicon glyphicon-edit"></span> Düzelt</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="alert alert-danger">
                <p>Şu anda Sanal Alan Bulunmamaktadır..!</p>
            </div>
        </div>
    </div>
<?php } ?>
<?php include 'footer.php'; ?>
<?php
include 'config.php';
include 'header.php';

$file = @$_GET['file'];
$islem = @$_GET['islem'];
$path = $config['vhost_path'];
$db_file = $config['db'];

if (empty($islem) || !isset($islem)) {

    if (empty($file) || !isset($file)) {
        header('Location: index.php');
    } else {
        try {
            if (!file_exists($path . $file)) {
                throw new Exception('Konfigürasyon Dosyası Bulunamadı..!');
            } else {
                if ($db = @fopen($db_file, 'rb')) {
                    $site = fread($db, filesize($db_file));
                    $site = unserialize($site);
                    $key = substr($file, 0, -5);
                    $bilgi = $site[$key];

                    if ($conf = @fopen($path . $file, 'rb')) {
                        $conf = fread($conf, filesize($path . $file));

                        ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-xs-12">

                                <div class="panel panel-default panel-success">
                                    <!-- Default panel contents -->
                                    <div class="panel-heading">Sanal Alan Düzenle</div>

                                    <br>

                                    <p class="well well-sm">Bu sayfada yaptığınız değişiklikler sonrasında XammpServer'i
                                        yeniden başlatınız..!</p>

                                    <form class="form form-horizontal" data-role="form" role="form" method="post"
                                          action="edit_vhost.php?file=<?php echo $file; ?>&islem=kaydet">

                                        <div class="form-group">
                                            <label class="col-lg-2 col-xs-12 col-md-12 control-label"
                                                   form="server_name">Sanal Alan Adresi:</label>

                                            <div class="col-lg-8 col-xs-12 col-md-12">
                                                <input type="text" class="form-control" name="server_name"
                                                       id="server_name" value="<?php echo $bilgi['url']; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-2 col-xs-12 col-md-12 control-label"
                                                   form="server_path">Sanal Alan Yolu:</label>

                                            <div class="col-lg-8 col-xs-12 col-md-12">
                                                <input type="text" class="form-control" name="server_path"
                                                       id="server_path" value="<?php echo $bilgi['path']; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-2 col-xs-12 col-md-12 control-label"
                                                   form="file_content">Sanal Alan Konfigürasyonu:</label>

                                            <div class="col-lg-8 col-xs-12 col-md-12">
                                                <textarea class="form-control" rows="15" name="file_content"
                                                          id="file_content"><?php echo $conf; ?></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-lg-8 col-xs-12 col-md-12">
                                                <input type="submit" class="btn btn-success col-lg-offset-8"
                                                       name="button" id="button" value="Düzelt"/>
                                            </div>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                        <?php
                    } else {
                        throw new Exception('Konfigürasyon Dosyası Açılamadı..');
                    }
                } else {
                    throw new Exception('Database Dosyası Açılamadığından Verilere Ulaşılamadı..!');
                }

            }

        } catch (Exception $e) {
            echo '<div class="alert alert-danger">' . $e->getMessage() . ' [ <a href="index.php">Geri Dön</a> ]</div>';
        }

    }
}

if ($islem == 'kaydet') {
    try {
        if (!$_POST) {
            throw new Exception('POST Bilgisine Ulaşılamadı..!');
        } else {
            $sName = $_POST['server_name'];
            $sPath = $_POST['server_path'];
            $fContent = $_POST['file_content'];
            $file = @$_GET['file'];

            if (empty($sName) || empty($sPath) || empty($fContent)) {
                throw new Exception('Tüm Forumu Doldurunuz..!');
            } else {
                if ($db = file_get_contents($db_file)) {
                    $site = unserialize($db);
                    $key = substr($file, 0, -5);

                    //ilk önce eski verileri silelim..
                    unset($site[$key]);
                    //eski conf dosyasını silelim
                    @unlink($path . $file);

                    //yeni verileri düzeltelim...
                    if (stripos($sPath, '\\') != false) {
                        $sPath = str_replace('\\', '/', $sPath);
                    }

                    if (stripos($sName, 'http://') !== false) {
                        $sName = substr($sName, 7);
                    }

                    if (stripos($sName, 'www') !== false) {
                        $sName = substr($sName, 4);
                    }

                    //yeni dosyayı yazalım...
                    $new_conf_file = $sName . '.conf';

                    if ($conf = @fopen($path . $new_conf_file, 'wb+')) {
                        if (@fwrite($conf, $fContent)) {
                            $hosts = $config['hosts_path'];
                            //hosts dosyası sadece yazmak için açılıyor...
                            $hosts = @fopen($hosts, 'ab');

                            if ($hosts) {
                                //hosts dosyası yazılıyor...
                                $hostsWrite = @fwrite($hosts, "\n127.0.0.1 " . $sName . " www." . $sName . "");

                                if ($hostsWrite) {
                                    $mesaj = 'windows hosts dosyası düzenlendi.';
                                } else {
                                    $mesaj = 'windows hosts dosyası yazılamadı. Manuel olarak yazmalısınız.';
                                }
                            } else {
                                $mesaj = 'windows hosts dosyası yazılamadı. Manuel olarak yazmalısınız.';
                            }

                            //yeni verileri yazalım...
                            $site[$sName] = array('conf' => $new_conf_file, 'url' => $sName, 'path' => $sPath);

                            if ($dbtxt = @fopen($db_file, 'wb+')) {
                                if (false == @fwrite($dbtxt, serialize($site))) {
                                    $mesaj = 'Database dosyası yazılamadı..!';
                                }
                            } else {
                                $mesaj = 'Database dosyası açılamadı..!';
                            }

                            throw new Exception('Virtual host dosyası oluşturuldu ve ' . $mesaj . ' XamppServer\'i yeniden başlatınız..!');
                        }
                    } else {
                        throw new Exception('Yeni Konfigürasyon Dosyası Oluşturulamadı..!');
                    }
                } else {
                    throw new Exception('Database Dosyası Açılamadı..!');
                }
            }

        }

    } catch (Exception $e) {
        echo '<div class="alert alert-danger">' . $e->getMessage() . ' [ <a href="index.php">Geri Dön</a> ]</div>';
    }

}

include 'footer.php';
?>
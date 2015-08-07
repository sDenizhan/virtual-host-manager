<?php
//config file
include 'config.php';

if (!$_POST) {
    echo '__NO_POST__';
} else {
    $serverName = $_POST['server_name'];
    $serverPath = strtolower($_POST['server_path']);

    if (empty($serverName) || empty($serverPath)) {
        echo '__EMPTY_FIELDS__';
    } else {
        //windows path'indeki ters slajı düzeltiyoruz...
        if (stripos($serverPath, '\\') !== false) {
            $serverPath = str_replace('\\', '/', $serverPath);
        }

        //serverName isminde http:// varsa siliyoruz..
        if (stripos($serverName, 'http://') !== false) {
            $serverName = substr($serverName, 7);
        }

        //serverName isminde www varsa siliyoruz..
        if (stripos($serverName, 'www') !== false) {
            $serverName = substr($serverName, 4);
        }

        //virtual host config...
        $vhost = '<VirtualHost *:80>
        DocumentRoot "{server_path}"
        ServerName {server_name}
        ServerAlias www.{server_name}
        <Directory "{server_path}">
            Options FollowSymLinks Indexes
            AllowOverride All
            Order deny,allow
            Allow from 127.0.0.1
            Deny from all
            Require all granted
        </Directory>
        </VirtualHost>';

        $vhost = str_replace('{server_path}', $serverPath, $vhost);
        $vhost = str_replace('{server_name}', $serverName, $vhost);

        //virtual host file oluşturuluyor...
        $vfile = $serverName . '.conf';
        $vpath = $config['vhost_path'];
        $hosts = $config['hosts_path'];

        //dosya varsa uyaralım...
        if (file_exists($vpath . $vfile) == true) {
            echo '__VHOST_VAR__';
        } else {
            //dosyayı oluşturalım
            $of = fopen($vpath . $vfile, 'wb+');
            if ($of) {

                if (fwrite($of, $vhost)) {
                    //hosts dosyası sadece yazmak için açılıyor...
                    $hosts = fopen($hosts, 'ab+');

                    if ($hosts) {
                        //hosts dosyası yazılıyor...
                        $hostsWrite = fwrite($hosts, "\n127.0.0.1 " . $serverName . " www." . $serverName . "");

                        if ($hostsWrite) {
                            $mesaj = 'windows hosts dosyası düzenlendi.';
                        } else {
                            $mesaj = 'windows hosts dosyası yazılamadı. Manuel olarak yazmalısınız.';
                        }
                    } else {
                        $mesaj = 'windows hosts dosyası yazılamadı. Manuel olarak yazmalısınız.';
                    }

                    //dbye yazalım
                    $db_file = $config['db'];
                    $db = file_get_contents($db_file);
                    $site = unserialize($db);
                    $site[$serverName] = array('conf' => $vfile, 'url' => $serverName, 'path' => $serverPath);

                    if ($dbtxt = fopen($db_file, 'wb+')) {
                        fwrite($dbtxt, serialize($site));
                    }

                    echo 'Virtual host dosyası oluşturuldu ve ' . $mesaj . ' Apache\'i yeniden başlatınız..!';

                } else {
                    echo '__ERROR_FWRITE__';
                }
            } else {
                echo '__ERROR_FOPEN__';
            }

        }

    }

}
?>
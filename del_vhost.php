<?php
include 'config.php';

if (!$_POST) {
    echo '__NO_POST__';
} else {
    $vhostfile = $_POST['file'];
    $vpath = $config['vhost_path'];

    if (file_exists($vpath . $vhostfile) === true) {
        //dosya siliniyor...
        if (unlink($vpath . $vhostfile)) {
            //db den siliniyor....
            $vhostKey = substr($vhostfile, 0, -5);
            $db = file_get_contents($config['db']);
            $siteler = unserialize($db);
            unset($siteler[$vhostKey]);

            if ($dbtxt = fopen($config['db'], 'wb+')) {
                fwrite($dbtxt, serialize($siteler));
            }

            //hosts dosyasından silelim
            $hosts = fopen($config['hosts_path'], 'rb');

            if ($hosts) {
                //hosts içeriği okunuyor...
                $hosts_content = fread($hosts, filesize($config['hosts_path']));
                //silme kuralı oluşturuluyor...
                $preg = '/127.0.0.1 ' . $vhostKey . ' www\.' . $vhostKey . '/i';
                //siliniyor...
                $hosts_content = preg_replace($preg, '', $hosts_content);
                //hosts dosyası yeniden yazılıyor...
                if ($host_write = fopen($config['hosts_path'], 'wb+')) {
                    fwrite($host_write, $hosts_content);
                }
            }


            echo '__FILE_DELETED__';
        } else {
            echo '__FILE_NOT_DELETED__';
        }
    } else {
        echo '__NO_FILE__';
    }
}
?>
<?php
//hatalar çıkmasın
error_reporting(0);

//Karakter Seti
header('Content-Type: text/html; charset=UTF-8');

//sistem
$sistem = 'xampp';

if ($sistem == 'xampp') {
    //file path
    $config['httpd_path'] = 'C:\\xampp\\apache\\conf\\httpd.conf';
    $config['vhost_path'] = 'C:\\xampp\\apache\\conf\\vhosts\\';
    $config['hosts_path'] = 'C:\\Windows\\System32\\drivers\\etc\\hosts';
} else {
    //file path
    $config['httpd_path'] = 'C:\\xampp\\apache\\conf\\httpd.conf';
    $config['vhost_path'] = 'C:\\xampp\\apache\\conf\\vhosts\\';
    $config['hosts_path'] = 'C:\\Windows\\System32\\drivers\\etc\\hosts';
}

//db dosyası
$config['db'] = 'db.txt';
?>
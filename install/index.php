<!DOCTYPE html>
<html>
<head>
    <title>Sanal Alan Yöneticisi | Skyweboffice.Com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div class="container" style="margin-top: 20px;">

    <div class="row">
        <div class="col-lg-6 col-md-6 col-xs-12">
            <h1>Sanal Alan Yöneticisi
                <small>for Xampp</small>
            </h1>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="padding-top: 40px;padding-left: 480px;">
            <a href="http://www.skyweboffice.com" title="Skyweboffice | Web Sayfanızı Göklere Çıkarıyoruz..!">
                Skyweboffice
            </a>
        </div>


    </div>
    <hr/>

    <?php

    /*---------------------------------------------
    |
    | KURULUM AŞAMALARI
    |
    |----------------------------------------------
    |
    | 1- vhosts klasörü var mı, klasör yoksa oluşturulsun
    | 2- localhost.conf oluşturulacak
    | 3- httpd.conf dosyasına virtual hosts dosyası ekleniyor...
    |
    */

    function alert($mesaj, $class = 'success')
    {
        echo '<div class="alert alert-' . $class . '" role="alert">
		  ' . $mesaj . '
		</div>';
    }

    include '../config.php';

    $step = @$_GET['step'];

    if (!isset($step) || empty($step)) {
        ?>
        <h3>Xampp Virtual Host Manager Kurulumuna Hoşgeldiniz. </h3>

        <p>Bu Yazılımın Temel Amacı Virtual Host ( Sanal Alan ) oluşturmanıza yardımcı olarak sizi bir çok işlemden
            kurtarmaktır.</p>

        <p>Kurulum tamamen otomatiktir fakat kurulum sırasında oluşabilecek hatalar karşısında sizin manuel müdahale
            etmeniz söz konusu olabilir.</p>

        <br><a href="http://localhost/vhostmanager/install/index.php?step=1" class="btn btn-primary"> Kuruluma
            Başla </a>

        <?php
    }

    /*---------------------------------------------
    | ADIM 1 : VHOSTS KLASÖRÜ VAR MI
    |----------------------------------------------
    */
    if ($step == 1) {
        echo '<h3>Adım 1 : Virtual Host Klasörünün Oluşturulması </h3>

	<p>Bu Adımda <b>c:\xampp\apache\conf</b> klasöründe sanal alanlarının konfigürasyon dosyalarının saklanacağı <b>vhosts</b> adında bir klasör oluşturulacaktır.</p>';

        //vhosts klasörü yoksa oluşturalım...
        if (false === file_exists($config['vhost_path'])) {
            if (!mkdir($config['vhost_path'])) {
                alert('Virtual Hosts Klasörü Oluşturulamadı. <b>c:\xampp\apache\conf</b> dizini altında <b>vhosts</b> klasörü oluşturunuz.', 'warning');
                echo '<br><a href="http://localhost/vhostmanager/install/index.php?step=1" class="btn btn-warning"> Tekrar Dene </a>';
            } else {
                alert('Virtual Hosts Klasörü Oluşturuldu. İkinci Adıma Geçebilirsiniz.');
                echo '<br><a href="http://localhost/vhostmanager/install/index.php?step=2" class="btn btn-success"> Kuruluma Devam Et </a>';
            }
        } else {
            alert('Virtual Hosts Klasörü Zaten Oluşturulmuş. İkinci Adıma Geçebilirsiniz.');
            echo '<br><a href="http://localhost/vhostmanager/install/index.php?step=2" class="btn btn-success"> Kuruluma Devam Et </a>';
        }

    }

    /*---------------------------------------------
    | ADIM 2 : LOCALHOST.CONF DOSYASI
    |----------------------------------------------
    */
    if ($step == 2) {
        echo '<h3>Adım 2 : LOCALHOST Yapılandırılması </h3>

	<p>Bu Adımda <b>c:\xampp\apache\conf\vhosts</b> klasöründe localhost.conf dosyası oluşturulacaktır. Bu sayede http://localhost adresi ile varsayılan xampp htdocs\'e erişim sağlayabileceksiniz.</p>';

        //localhost.conf dosyasını oluşturalım...
        if (false == file_exists($config['vhost_path'] . '/localhost.conf')) {
            //localhost dosyasını oluşturalım...
            $fopen = fopen($config['vhost_path'] . '/localhost.conf', 'wb+');
            //dosya oluşturulduğunda
            if ($fopen) {
                //virtual host config...
                $lc = '<VirtualHost *:80>
	        DocumentRoot "c:/xampp/htdocs"
	        ServerName localhost
	        ServerAlias www.localhost.dev
	        <Directory "c:/xampp/htdocs">
	            Options FollowSymLinks Indexes
	            AllowOverride All
	            Order deny,allow
	            Allow from 127.0.0.1
	            Deny from all
	            Require all granted
	        </Directory>
	        </VirtualHost>';

                if (!fwrite($fopen, $lc)) {
                    alert('localhost.conf dosyası oluşturulamadı. c:\xampp\apache\conf\vhosts dizini altına localhost.conf dosyasını kopyalayınız.', 'warning');
                    echo '<br><a href="http://localhost/vhostmanager/install/index.php?step=2" class="btn btn-warning"> Tekrar Dene </a>';
                } else {
                    alert('localhost.conf dosyası oluşturuldu. Üçüncü adıma geçebilirsiniz.');
                    echo '<br><a href="http://localhost/vhostmanager/install/index.php?step=3" class="btn btn-success"> Kuruluma Devam Et </a>';
                }

            } else {
                alert('localhost.conf dosyası oluşturulamadı. c:\xampp\apache\conf\vhosts dizini altına localhost.conf dosyasını kopyalayınız.');
                echo '<br><a href="http://localhost/vhostmanager/install/index.php?step=3" class="btn btn-success"> Kuruluma Devam Et </a>';
            }
        } else {
            alert('localhost.conf dosyası zaten oluşturulmuş. Üçüncü aşamaya geçebilirsiniz.');
            echo '<br><a href="http://localhost/vhostmanager/install/index.php?step=3" class="btn btn-success"> Kuruluma Devam Et </a>';
        }
    }

    /*---------------------------------------------
    | ADIM 3 : HTTPD.CONF DÜZENLENMESİ
    |----------------------------------------------
    */
    if ($step == 3) {

        echo '<h3>Adım 3 : httpd.conf Yapılandırılması </h3>

	<p>Bu Adımda <b>c:\xampp\apache\conf\httpd.conf</b> dosyasına virtual host yolunu ekliyoruz.</p>';

        //httpd.conf dosyasına vhost path yerleştirelim...
        if (false !== file_exists($config['httpd_path'])) {
            $fopen = fopen($config['httpd_path'], 'a+');

            if ($fopen) {
                $vhosts_line = "\n\n# Skyweboffice | Virtual Hosts Manager Sanal Alanları\n\nInclude conf/vhosts/*";

                if (!fwrite($fopen, $vhosts_line)) {
                    alert('httpd.conf dosyası düzenlenemedi. httpd.conf dosyasına <b>Include conf/vhosts/*</b> satırını eklemelisiniz.', 'warning');
                    echo '<br><a href="http://localhost/vhostmanager/install/index.php?step=3" class="btn btn-warning"> Tekrar Dene </a>';
                } else {
                    alert('httpd.conf dosyası düzenlendi. Xampp\'ı Yeniden Başlatınız..!');
                    echo '<br><a href="http://localhost/vhostmanager/" class="btn btn-success"> Kurulum Bitti ... Hayırlı Olsun :) </a>';
                }
            } else {
                alert('httpd.conf dosyası düzenlenemedi. httpd.conf dosyasına <b>Include conf/vhosts/*</b> satırını eklemelisiniz.', 'warning');
                echo '<br><a href="http://localhost/vhostmanager/install/index.php?step=3" class="btn btn-warning"> Tekrar Dene </a>';
            }

        } else {
            alert('httpd.conf dosyası bulunamadı. httpd.conf dosyasına <b>Include conf/vhosts/*</b> satırını eklemelisiniz.', 'warning');
            echo '<br><a href="http://localhost/vhostmanager/install/index.php?step=3" class="btn btn-warning"> Tekrar Dene </a>';
        }

    }

    ?>

</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
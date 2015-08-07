<!DOCTYPE html>
<html>
<head>
    <title>Sanal Alan Yöneticisi | Skyweboffice.Com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div class="container">

    <!-- sanal alan ekle modal -->
    <!-- Modal -->
    <div class="modal fade" id="SanalAlanEkle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLaber">Sanal Alan Ekle</h4>
                </div>
                <div class="modal-body">

                    <div id="result" class="alert"></div>

                    <form method="post" action="add_vhost.php" class="form-horizontal" role="form" id="sanal_alan_form">
                        <div class="form-group">
                            <label for="server_name" class="col-sm-3 control-label">Sanal Alan Adresi:</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="server_name" id="server_name"
                                       placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="server_path" class="col-sm-3 control-label">Sanal Alan Yolu:</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="server_path" id="server_path"
                                       placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-10">
                                <button type="submit" class="btn btn-success">Sanal Alanı Ekle</button>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Kapat</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- sanal alan ekle modal -->

    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12">
            <h1>Sanal Alan Yöneticisi
                <small> [ <?php echo ucfirst($sistem); ?> ]</small>
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12">
            <nav class="navbar navbar-default" role="navigation">

                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
                        <span class="sr-only">Menü</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="menu">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="index.php" class="active">Tüm Sanal Alanlar</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#SanalAlanEkle">Sanal Alan Ekle</a></li>
                    </ul>
                    <p class="navbar-text navbar-right">Programlayan:
                        <a href="http://www.suleymandenizhan.com.tr" class="navbar-link">Süleyman DENİZHAN</a></p>
                </div>
            </nav>
        </div>
    </div>
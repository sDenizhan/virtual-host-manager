</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript">

    $(document).ready(function () {

        $('.del-link').on('click', function (e) {
            e.preventDefault();

            var href = $(this).attr('href');
            var s = href.split('?file=');
            var file = s[1];

            $.post('del_vhost.php', {'file': file}, function (gelen) {

                if (gelen.search('__NO_POST__') > -1) {
                    $('#delresult').addClass('alert-danger').removeClass('hide').show().html('Post Verisi Alınamadı. Lütfen Tekrar Deneyiniz..!');
                    setTimeout(function () {
                        $('#delresult').empty().hide();
                    }, 3000);
                }
                else if (gelen.search('__FILE_DELETED__') > -1) {
                    $('#delresult').addClass('alert-danger').removeClass('hide').show().html('Sanal Alan Dosyası Silindi. Apache\'i Yeniden Başlatınız.');
                    setTimeout(function () {
                        $('#delresult').empty().hide();
                        window.location.href = "http://localhost/vhostmanager";
                    }, 3000);
                }
                else if (gelen.search('__FILE_NOT_DELETED__') > -1) {
                    $('#delresult').addClass('alert-danger').removeClass('hide').show().html('Sanal Alan Dosyası Silinemedi.. Lütfen Tekrar Deneyiniz.');
                    setTimeout(function () {
                        $('#delresult').empty().hide();
                    }, 3000);
                }
                else if (gelen.search('__NO_FILE__') > -1) {
                    $('#delresult').addClass('alert-danger').removeClass('hide').show().html('Sanal Alan Dosyası Bulunamadı...!');
                    setTimeout(function () {
                        $('#delresult').empty().hide();
                    }, 3000);
                }
            });

        });

        $('#sanal_alan_form').on('submit', function (e) {
            e.preventDefault();

            var sName = $('#server_name').val();
            var sPath = $('#server_path').val();

            $.post('add_vhost.php', {'server_name': sName, 'server_path': sPath}, function (gelen) {

                if (gelen.search('__NO_POST__') > -1) {
                    $('#result').addClass('alert-danger').show().html('Post Verisi Alınamadı. Lütfen Tekrar Deneyiniz..!');
                    setTimeout(function () {
                        $('#result').empty().hide();
                    }, 3000);
                }
                else if (gelen.search('__EMPTY_FIELDS__') > -1) {
                    $('#result').addClass('alert-danger').show().html('Tüm Forumu Doldurmalısınız..!');
                    setTimeout(function () {
                        $('#result').empty().hide();
                    }, 3000);
                }
                else if (gelen.search('__VHOST_VAR__') > -1) {
                    $('#result').addClass('alert-danger').show().html('Bu Server Daha Önceden Oluşturulmuş. Lütfen Server Adını Değiştiriniz.');
                    setTimeout(function () {
                        $('#result').empty().hide();
                    }, 3000);
                }
                else if (gelen.search('__ERROR_FWRITE__') > -1) {
                    $('#result').addClass('alert-danger').show().html('fwrite Hatası Nedeniyle Sanal Alan Dosyası Oluşturulamadı.');
                    setTimeout(function () {
                        $('#result').empty().hide();
                    }, 3000);
                }
                else if (gelen.search('__ERROR_FOPEN__') > -1) {
                    $('#result').addClass('alert-danger').show().html('fopen Hatası Nedeniyle Sanal Alan Dosyası Oluşturulamadı.');
                    setTimeout(function () {
                        $('#result').empty().hide();
                    }, 3000);
                }
                else {
                    $('#result').addClass('alert-success').html(gelen);
                    setTimeout(function () {
                        $('#result').empty().hide();
                        window.location.href = "http://localhost/vhostmanager";
                    }, 3000);


                }
            });

        });

    });

</script>

</body>
</html>
<?php $this->load->view("layout/header_left"); ?>
<script src="<?= base_url('assets/sweetalert2.js') ?>"></script>

<script type='text/javascript'>
    $('#tombolkembali').on('click', function() {
        $('.content').html('<div class="text-center"><span class="fa fa-refresh fa-spin"></span><h1>Please Wait ...</h1></div>');
    });
</script>
<section class="content">
    <div class="row">
        <div class="col-sm-6">
            <?php $this->load->view("iri/data_pasien"); ?>
        </div>
        <div class="col-sm-6">
            <div class="card card-outline-info">
                <div class="card-header text-white" align="center">Pelayanan Pasien</div>
                <div class="card-body p-3">
                    <div class="alert alert-info">
                        <h3 class="text-info"><i class="fa fa-exclamation-circle"></i> Limited Authorization</h3>
                        <p class="text-justify">
                            Dalam rangka upaya peningkatan kualitas pelayanan dan keakuratan data pasien, ruangan/bed pasien, tindakan pasien, billing dan lainnya. <b>Maka diharapkan mengisi tindakan pasien sesuai lantai/gedung pasien dirawat</b>. <br>- Terimakasih. <br><br>
                        </p>
                        <?php
                        echo ($_SERVER['HTTP_HOST'] == 'localhost') ? 'Code Auth : localhost' : 'Code Auth : ' . substr(str_shuffle('!@#$'), 1, 1) . explode('.', $_SERVER['REMOTE_ADDR'])[2] . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, 1) . explode('.', $_SERVER['REMOTE_ADDR'])[3] . '-' . substr(str_shuffle('0123456789'), 1, 2);
                        echo '<br>';
                        echo !empty($ruang[0]['nmruang']) ? 'Ruangan Pasien Saat ini : ' . $ruang[0]['nmruang'] : '';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view("layout/footer_left"); ?>
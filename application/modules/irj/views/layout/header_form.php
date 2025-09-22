<!-- jquery 3.6.0 -->
<script src="<?= base_url('assets/form/') ?>jquery-3.6.0.js" ></script>

<!-- datatables bootstrap 5 -->
<link rel="stylesheet" href="<?= base_url('assets/form/') ?>datatables-bootstrap5-min.css">
<script src="<?= base_url('assets/form/') ?>datatables.js"></script>
<script src="<?= base_url('assets/form/') ?>datatables-bootstrap5.js"></script>
<script src="<?= base_url('assets/form/') ?>dataTables.buttons.min.js"></script>
<script src="<?= base_url('assets/form/') ?>dataTables.select.min.js"></script>
<script src="<?= base_url('assets/form/') ?>dataTables.dateTime.min.js"></script>
<!-- bootstrap -->
<link href="<?= base_url('assets/form/') ?>bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<script src="<?= base_url('assets/form/') ?>bootstrap.bundle.min.js"  crossorigin="anonymous"></script>


<!-- modern css , jquery  -->
<link href="<?= base_url('assets/form/') ?>modern.css" type="text/css" rel="stylesheet" />
<script src="<?= base_url('assets/form/') ?>survey.jquery.min.js"></script>


<!-- select 2 -->
<link href="<?= base_url('assets/form/') ?>select2.min.css" rel="stylesheet" />
<script src="<?= base_url('assets/form/') ?>select2.min.js"></script>

<!-- sweetalert -->
<script src="<?= base_url('assets/form/') ?>sweetalert2@11.js"></script>


<!-- jquery ui -->
<link rel="stylesheet" href="<?= base_url('assets/form/') ?>jquery-ui.css">
<script src="<?= base_url('assets/form/') ?>jquery-ui.js"></script>

<script>
    function closepage(){
        // alert()
        window.top.close();
    }
</script>

<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <img class="navbar-brand" src="<?php echo base_url('assets/images/logo_sjj.png'); ?>" width="200" alt="">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      </ul>
      <div class="d-flex" role="search">
        <?php 
        if(isset($pelayan)):
        if($pelayan == 'PERAWAT'){ ?>
            <a href="<?php echo base_url('irj/rjcpelayanan/pelayanan_tindakan/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Kembali ke Status Pasien</a>
        <?php } else{ ?>
            <a href="<?php echo base_url('irj/rjcpelayananfdokter/pelayanan_tindakan/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Kembali ke Status Pasien</a>
        <?php }
        endif;
        ?>
       
        <!-- <button class="btn btn-outline-primary" onclick="closepage()">Kembali Ke Halaman Sebelumnya</button> -->
        </div>
    </div>
  </div>
</nav>

<?php if(!isset($hide)): ?>
<div class="card m-5">
    <div class="card-header">
        <div class="container-fluid">
            <h5>Data Pasien </h5>
        </div>
    </div>
  <div class="card-body">
    <div class="row mb-3">
        <label for="nama" class="col col-form-label">Nama :</label>
        <div class="col">
            <input type="text" readonly class="form-control" id="nama" value="<?= $data_pasien_daftar_ulang->nama ?>">
        </div>
        <label for="no_medrec" class="col col-form-label">No. Medrec</label>
        <div class="col">
            <input type="text" class="form-control" id="no_medrec" value="<?= $data_pasien_daftar_ulang->no_cm ?>" readonly>
        </div>

        <label for="nama" class="col col-form-label">No. Register</label>
        <div class="col">
            <input type="text" readonly class="form-control" id="nama" value="<?= $data_pasien_daftar_ulang->no_register?>">
        </div>
        <label for="no_medrec" class="col col-form-label">Tgl. Lahir</label>
        <div class="col">
            <input type="text" class="form-control" id="no_medrec" value="<?= date('d-m-Y',strtotime($data_pasien_daftar_ulang->tgl_lahir)) ?>" readonly>
        </div>
    </div>

    <div class="row mb-3">
        <label for="alamat" class="col col-form-label">Alamat :</label>
        <div class="col">
            <input type="text" readonly class="form-control" id="alamat" value="<?= $data_pasien_daftar_ulang->alamat ?>">
        </div>
        <label for="no_medrec" class="col col-form-label">Gol Darah</label>
        <div class="col">
            <input type="text" class="form-control" id="no_medrec" value="<?= $data_pasien_daftar_ulang->goldarah ?>" readonly>
        </div>

        <label for="nama" class="col col-form-label">Tgl. Kunjungan</label>
        <div class="col">
            <input type="text" readonly class="form-control" id="nama" value="<?= date('d-m-Y',strtotime($data_pasien_daftar_ulang->tgl_kunjungan)) ?>">
        </div>
        <label for="no_medrec" class="col col-form-label">Cara Bayar : </label>
        <div class="col">
        <input type="text" class="form-control" id="no_medrec" 
            value="<?php if($data_pasien_daftar_ulang->cara_bayar == 'KERJASAMA' or $data_pasien_daftar_ulang->cara_bayar == 'BPJS') {
                        echo $data_pasien_daftar_ulang->cara_bayar.'('.$data_pasien_daftar_ulang->nmkontraktor.')';
                } else{
                        echo $data_pasien_daftar_ulang->cara_bayar;
                }?>" readonly>
        </div>

    </div>

    <div class="row mb-3">
        <!-- DPJP -->
        <label for="alamat" class="col-lg-2 col-form-label text-end">DPJP :</label>
        <div class="col-lg-4">
            <input type="text" readonly class="form-control" id="alamat" value="<?= $data_pasien_daftar_ulang->dokter ?>">
        </div>

        <!-- Umur -->
        <label for="umur" class="col-lg-2 col-form-label text-end">Umur :</label>
        <div class="col-lg-4">
            <input type="text" class="form-control" id="umur" value="<?php
                // Menghitung selisih antara tanggal sekarang dan tanggal lahir
                $interval = date_diff(date_create(), date_create($data_pasien->tgl_lahir));

                // Menampilkan hasil usia dalam tahun, bulan, dan hari
                echo $interval->y . ' tahun, ' . $interval->m . ' bulan, ' . $interval->d . ' hari';
            ?>" readonly>
        </div>
    </div>
  </div>
</div>
<?php endif; ?>

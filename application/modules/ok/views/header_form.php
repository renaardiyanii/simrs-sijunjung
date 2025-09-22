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
    <img class="navbar-brand" src="<?php echo base_url('assets/images/rsud_sjj2.png'); ?>" width="400" alt="">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      </ul>
      <div class="d-flex" role="search">
        <button class="btn btn-outline-primary" onclick="closepage()">Kembali Ke Halaman Sebelumnya</button>
        </div>
    </div>
  </div>
</nav>

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
            <input type="text" readonly class="form-control" id="nama" value="<?= $data_pasien->nama ?>">
        </div>
        <label for="no_medrec" class="col col-form-label">No. Medrec</label>
        <div class="col">
            <input type="text" class="form-control" id="no_medrec" value="<?= $data_pasien->no_cm ?>" readonly>
        </div>
    </div>
    <div class="row mb-3">
        <label for="nama" class="col col-form-label">No. Register</label>
        <div class="col">
            <input type="text" readonly class="form-control" id="nama" value="<?= $data_pasien->no_register ?>">
        </div>
        <!-- <label for="no_medrec" class="col col-form-label">Tgl. Lahir</label>
        <div class="col">
            <input type="text" class="form-control" id="no_medrec" value="" readonly>
        </div> -->
        <label for="alamat" class="col col-form-label">Alamat :</label>
        <div class="col">
            <input type="text" readonly class="form-control" id="alamat" value="<?= $data_pasien->alamat ?>">
        </div>
    </div>

    <div class="row mb-3">
        <!-- <label for="no_medrec" class="col col-form-label">Gol Darah</label>
        <div class="col">
            <input type="text" class="form-control" id="no_medrec" value="" readonly>
        </div> -->

        <label for="nama" class="col col-form-label">Tgl. Kunjungan</label>
        <div class="col">
            <input type="text" readonly class="form-control" id="nama" value="<?= date('d-m-Y',strtotime($data_pasien->tgl_daftar)) ?>">
        </div>
        <label for="no_medrec" class="col col-form-label">Kelas</label>
        <div class="col">
            <input type="text" class="form-control" id="no_medrec" value="<?= $data_pasien->kelas ?>" readonly>
        </div>
    </div>

    <div class="row mb-3">
        <label for="alamat" class="col col-form-label">DPJP :</label>
        <div class="col">
            <input type="text" readonly class="form-control" id="alamat" value="<?= $data_pasien->nm_dokter ?>">
        </div>
        <label for="no_medrec" class="col col-form-label">Cara Bayar : </label>
        <div class="col">
            <input type="text" class="form-control" id="no_medrec" value="<?= $data_pasien->cara_bayar ?>" readonly>
        </div>

        <!-- <label for="nama" class="col col-form-label"></label>
        <div class="col">
        </div>
        <label for="no_medrec" class="col col-form-label"></label>
        <div class="col">
        </div> -->
    </div>
    
    
   
  </div>
</div>

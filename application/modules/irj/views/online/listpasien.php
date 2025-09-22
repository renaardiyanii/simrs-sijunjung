<?php
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_left");
}
?>
<html>
<!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<script type='text/javascript'>
    $(function() {
        $('#example').DataTable();
        $('#tglKunjugnan').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true,
        });
        getKunjungan();

    });

    function cetak_tracer(no_register) {
        var windowUrl = '<?php echo base_url(); ?>irj/tracer/cetak/' + no_register;
        window.open(windowUrl, 'p');
    }

    function caritgl(date) {
        getKunjungan(date);
    };

    function daftarulang(data) {
        // console.log(data);
        window.location.href = '<?= base_url('') ?>/irj/rjcregistrasi/daftarulangnew/' + data.nocm + `?carabayar=${data.carabayar}&iddokter=${data.iddokter}&idpoli=${data.idpoli}&nokartu=${data.nokartu}&tglkunjungan=${data.tglkunjungan}&online=1&noreservasi=${data.noreservasi}&tiperujukan=${data.tiperujukan}`;
    }

    function getKunjungan(date = null) {
        $.ajax({
            url: "<?= base_url('irj/rjconline/ambilpasienonline/') ?>" + (date ?? ''),
            beforeSend: function() {
                $("#isiKonten").empty().append('<tr><td colspan="8" style="text-align:center;">Silahkan ditunggu..</td></tr>')
            },
            success: (res) => {
                let html = '';
                if (res.metadata.code == 200 && res.response.length > 0) {
                    var i = 1;
                    res.response.map((e) => {
                        let jsonData = JSON.stringify(e);
                        html += `
                        <tr>
                            <td>${i++}</td>
                            <td>
                                <button class="btn btn-primary" onclick='daftarulang(${jsonData})'>Daftar</button>
                            </td>
                            <td>${e.tglkunjungan}</td>
                            <td>${e.nocm}</td>
                            <td>${e.nama}</td>
                            <td>${e.carabayar}</td>
                            <td>${e.namapoli}</td>
                            <td>${e.namadokter}</td>
                            <td>${e.noreservasi}</td>
                            <td>${e.nohp}</td>
                        </tr>
                        `;
                    })
                    $("#isiKonten").empty().append(html)
                    return;
                }
                $("#isiKonten").empty().append('<tr><td colspan="5" style="text-align:center;">Data Tidak Tersedia</td></tr>')



            },
            dataType: 'json'
        });
    }
</script>

<?php
echo $this->session->flashdata('success_msg');
?>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card card-outline-info">
            <div class="card-block">
                <div class="row p-t-0">
                    <div class="col-md-3">
                        <div class="form-group row">
                            <label for="">Tanggal Daftar</label>
                            <div>
                                <input type="date" class="form-control" placeholder="Tanggal Berobat" id="tglDaftar">
                            </div>
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="cariListKunjungan" onclick="caritgl($('#tglDaftar').val())">Cari</button>
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<ul class="nav nav-tabs mb-4" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="irj-tab" data-toggle="tab" href="#irj" role="tab" aria-controls="irj"
            aria-selected="true">Kunjungan Poli Pasien</a>
    </li>
    <li class="nav-item" onclick="handlepasienbaru()">
        <a class="nav-link" id="igd-tab" data-toggle="tab" href="#igd" role="tab"
            aria-controls="igd-tab" aria-selected="true">Pasien Baru</a>
    </li>
    <!-- <li class="nav-item">
        <a class="nav-link " id="iri-tab" data-toggle="tab" href="#iri" role="tab"
            aria-controls="iri-tab" aria-selected   ="true">Instalasi Rawat Inap</a>
    </li> -->
    <!-- <li class="nav-item">
        <a class="nav-link" id="iri-tab" data-toggle="tab" href="#iri" role="tab" aria-controls="iri"
            aria-selected="true">Instalasi Rawat Inap</a>
    </li> -->
</ul>

<div class="tab-content mt-4" id="myTabContent">
    <!-- <div class="tab-pane fade" id="irj" role="tabpanel" aria-labelledby="irj-tab"> -->
    <div class="tab-pane fade show active" id="irj" role="tabpanel" aria-labelledby="irj-tab">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-0">
                    <table class="display nowrap table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Aksi</th>
                                <th>Tgl Daftar</th>
                                <th>No RM</th>
                                <th>Nama</th>
                                <th>Cara Bayar</th>
                                <th>Poliklinik</th>
                                <th>Dokter</th>
                                <th>No. Reservasi</th>
                                <th>No HP</th>
                            </tr>
                        </thead>
                        <tbody id="isiKonten">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="igd" role="tabpanel" aria-labelledby="igd-tab">
        <div class="card mt-2">

            <div class="table-responsive m-t-0 mb-2">

                <!-- example datatable server side -->
                <table class="table table-striped table-bordered" id="table-igd" style="width: 100%">
                    <thead>
                        <tr>    
                            <th width="20%">Pasien</th>
                            <th width="15%">Tgl. Lahir</th>
                            <th width="15%">No Kartu BPJS</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="table-pasienbaru">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>

<script>
    $(document).ready(function() {
        handlepasienbaru();
    });

    function handlepasienbaru()
    {
        $.ajax({
            url: "<?= base_url('irj/rjconline/grabpasienbaru') ?>",
            success: (res) => {
                let html = '';
                res.response.map((e)=>{

                    html+=`
                    <tr>
                        <td>${e.nama} (${e.no_identitas})</td>
                        <td>${e.tgl_lahir}</td>
                        <td>${e.no_kartu_bpjs}</td>
                        <td>
                            <button type="button" class="btn btn-primary" onclick="simpan_pendaftaran('${btoa(JSON.stringify(e))}')">Daftar</button>
                        </td>
                    </tr>
                    `;
                })
                $("#table-pasienbaru").html(html);
            },
            dataType: 'json'
        });
    }

    function simpan_pendaftaran(data)
    {
        $.ajax({
            method:"post",
            url: "<?= base_url('irj/rjconline/insert_pasien_baru') ?>",
            data: {
                data:data
            },
            success: (res) => {
                new swal({
                        title: "Berhasil",
                        text: `Pasien Berhasil Disimpan dengan No Rekam Medis : ${res.norm}`,
                        type: "success"
                    },
                    function() {
                        window.open('<?= base_url() ?>irj/rjcregistrasi/daftarulangnew/'+res.norm);
                        // redirect('' . $no_medrec);
                    }
                );
            },
            dataType: 'json'
        });
    }



    const submit_pendaftaran = (json) => {
        $.ajax({
            type: "POST",
            url: "<?= base_url('irj/rjconline/insert_daftar_ulang/') ?>",
            data: {
                data: json
            },
            success: (res) => {
                new swal({
                        title: "Berhasil",
                        text: "Pasien Berhasil Daftar Ulang!",
                        type: "success"
                    },
                    function() {
                        // window.location.reload();
                    }
                );
            },
            dataType: 'json'
        });
    }
</script>
<?php
if ($role_id == 1) {
    $this->load->view("layout/footer_left");
} else {
    $this->load->view("layout/footer_left");
}
?>
<?php
$this->load->view('layout/header_left.php');
?>
<section>
    <div class="card">
        <div class="card-header">
            <h3>Laporan Pendaftaran Pasien Baru Melalui Anjungan Pendaftaran Mandiri</h3>
        </div>
        <div class="card-body">
            <div class="p-4">

                <!-- Pencarian -->
                <div class="row">
                    <div class="mt-1 ml-4">
                        <span>Pencarian : </span>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <select name="tampil_per" id="tampil_per" class="form-control" onchange="gantiTampilPer(this.value)">
                                <option value="BLN">Bulanan</option>
                                <option value="THN">Tahunan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="month" id="pencarianPer" class="form-control">
                    </div>
                    <div class="col-md-1">
                        <div class="form-actions row">
                            <button class="btn btn-primary" onclick="pencarian()">Cari</button>
                        </div>
                    </div>
                    <div id="downloadExcel" class="col-md-1">
                        <div class="form-actions row">
                            <button class="btn btn-info" onclick="downloadexcel()">Download Excel</button>

                        </div>
                    </div>


                </div>
                <div id="loading" class="text-center">
                    <img src="<?= base_url('assets/loading.gif') ?>" alt="" width="60">
                </div>
                <div id="hasilTahun">
                    <h4 id="tahunPencarian"></h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Bulan</th>
                                <th scope="col">Jumlah Pasien</th>
                            </tr>
                        </thead>
                        <tbody id="datahasilTahun">

                        </tbody>
                    </table>
                </div>
                <div id="hasilBulan">
                    <h4 id="bulanPencarian"></h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Jumlah Pasien</th>
                            </tr>
                        </thead>
                        <tbody id="dataHasilBulan">
                        </tbody>
                    </table>
                </div>





                <div id="hasilTanggal">
                    <!-- Detail data -->
                    <h5 id="judulTglHasil"></h5>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">No. Rekam Medis</th>
                                <th scope="col">Nama Pasien</th>
                                <th scope="col">Tgl Lahir</th>
                            </tr>
                        </thead>
                        <tbody id="dataHasilTanggal">
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Laporan Pendaftaran Poliklinik Melalui Anjungan Pendaftaran Mandiri</h3>
        </div>
        <div class="card-body">
            <div class="p-4">

                <!-- Pencarian -->
                <div class="row">
                    <div class="mt-1 ml-4">
                        <span>Pencarian : </span>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <select name="tampilPerPoli" id="tampilPerPoli" class="form-control" onchange="gantiTampilPerPoli(this.value)">
                                <option value="BLN">Bulanan</option>
                                <option value="THN">Tahunan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="month" id="pencarianPoliPer" class="form-control">
                    </div>
                    <div class="col-md-1">
                        <div class="form-actions row">
                            <button class="btn btn-primary" onclick="pencarianPoli()">Cari</button>
                        </div>
                    </div>
                    <div id="downloadExcelPoli" class="col-md-1">
                        <div class="form-actions row">
                            <button class="btn btn-info" onclick="downloadexcelPoli()">Download Excel</button>

                        </div>
                    </div>


                </div>
                <div id="loadingPoli" class="text-center">
                    <img src="<?= base_url('assets/loading.gif') ?>" alt="" width="60">
                </div>
                <div id="hasilTahunPoli">
                    <h4 id="tahunPencarianPoli"></h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Bulan</th>
                                <th scope="col">Jumlah Pasien</th>
                            </tr>
                        </thead>
                        <tbody id="datahasilTahunPoli">

                        </tbody>
                    </table>
                </div>
                <div id="hasilBulanPoli">
                    <h4 id="bulanPencarianPoli"></h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Jumlah Pasien</th>
                            </tr>
                        </thead>
                        <tbody id="dataHasilBulanPoli">
                        </tbody>
                    </table>
                </div>
                <div id="hasilTanggalPoli">
                    <h5 id="judulTglHasilPoli"></h5>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">No. Rekam Medis</th>
                                <th scope="col">Tgl. Kunjungan</th>
                            </tr>
                        </thead>
                        <tbody id="dataHasilTanggalPoli">
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function(){
        $("#loadingPoli").hide();
        $("#hasilTahunPoli").hide();
        $("#hasilBulanPoli").hide();
        $("#hasilTanggalPoli").hide();
    });
</script>

<script>
    $(document).ready(function() {
        $("#loading").hide();
        $("#hasilBulan").hide();
        $("#hasilTanggal").hide();
        $("#hasilTahun").hide();
        $("#downloadExcel").show();

    });

    function downloadexcel() {
        let bulan = $('#pencarianPer').val();
        if (bulan != '') {
            window.location.href = `<?= base_url('irj/rjclaporan/excel_laporan_apm/') ?>/${bulan}`;
            return;
        }
        swal({
                title: "Peringatan",
                text: "Data Pencarian Harus diisi",
                type: "error",
            },
            function() {});
    }

    function downloadexcelPoli(){
        let bulan = $('#pencarianPoliPer').val();
        if (bulan != '') {
            window.location.href = `<?= base_url('irj/rjclaporan/excel_laporan_apm_poli/') ?>/${bulan}`;
            return;
        }
        swal({
                title: "Peringatan",
                text: "Data Pencarian Harus diisi",
                type: "error",
            },
            function() {});
    }

    function lihatDetail(data) {
        let pencarianPer = $('#tampil_per').val();
    }

    function gantiTampilPer(val) {
        if (val == 'BLN') {
            $("#downloadExcel").show();
            $("#pencarianPer").prop('type', 'month');
            return;
        }
        $("#downloadExcel").hide();
        $("#pencarianPer").prop('type', 'number');
    }
    function gantiTampilPerPoli(val) {
        if (val == 'BLN') {
            $("#downloadExcelPoli").show();
            $("#pencarianPoliPer").prop('type', 'month');
            return;
        }
        $("#downloadExcelPoli").hide();
        $("#pencarianPoliPer").prop('type', 'number');
    }

    function gantiTampilPer(val) {
        if (val == 'BLN') {
            $("#downloadExcel").show();
            $("#pencarianPer").prop('type', 'month');
            return;
        }
        $("#downloadExcel").hide();
        $("#pencarianPer").prop('type', 'number');
    }
    

    function pencarianDetailBulan(bulan) {
        $('#bulanPencarian').html(`Hasil Pencarian Data Berdasarkan Bulan : ${bulan.split('-')[1]}`);
        $.ajax({
            url: `<?= base_url('irj/rjclaporan/laporan_apm_data?pencarian=') ?>BLN&data=${bulan}`,
            beforeSend: function() {
                $('#loading').show();

            },
            success: function(data) {
                $("#hasilBulan").show();
                // $("#hasilTahun").hide();
                let html = '';
                let index = 1;
                if (data.length > 0) {
                    data.map((e) => {
                        html += `
                        <tr>
                            <td>${index}</td>
                            <td>${e.tgl}</td>
                            <td>${e.count}</td>
                            <td>
                            <button class="btn btn-primary" onclick="pencarianDetail('${e.tgl}')"><i class="fa fa-book"></i>Lihat Detail</button>
                            </td>
                        </tr>
                        `;
                        index++;
                    });
                    $("#dataHasilBulan").html(html);
                    return;
                }
                html += `
                    <tr>
                        <td style="text-align:center" colspan="3">Data Tidak ada</td>
                    </tr>
                    `;
                $("#dataHasilBulan").html(html);
                return;

            },
            error: function(xhr) { // if error occured
            },
            complete: function() {
                $('#loading').hide();
            },
        });
    }
    function pencarianDetailBulanPoli(bulan) {
        $('#bulanPencarianPoli').html(`Hasil Pencarian Data Berdasarkan Bulan : ${bulan.split('-')[1]}`);
        $.ajax({
            url: `<?= base_url('irj/rjclaporan/laporan_apm_data_poli?pencarian=') ?>BLN&data=${bulan}`,
            beforeSend: function() {
                $('#loadingPoli').show();

            },
            success: function(data) {
                $("#hasilBulanPoli").show();
                // $("#hasilTahun").hide();
                let html = '';
                let index = 1;
                if (data.length > 0) {
                    data.map((e) => {
                        html += `
                        <tr>
                            <td>${index}</td>
                            <td>${e.tgl}</td>
                            <td>${e.count}</td>
                            <td>
                            <button class="btn btn-primary" onclick="pencarianDetailPoli('${e.tgl}')"><i class="fa fa-book"></i>Lihat Detail</button>
                            </td>
                        </tr>
                        `;
                        index++;
                    });
                    $("#dataHasilBulanPoli").html(html);
                    return;
                }
                html += `
                    <tr>
                        <td style="text-align:center" colspan="3">Data Tidak ada</td>
                    </tr>
                    `;
                $("#dataHasilBulanPoli").html(html);
                return;

            },
            error: function(xhr) { // if error occured
            },
            complete: function() {
                $('#loadingPoli').hide();
            },
        });
    }

    function pencarianDetail(tgl) {
        $.ajax({
            url: `<?= base_url('irj/rjclaporan/laporan_apm_data_detail?data=') ?>${tgl}`,
            beforeSend: function() {
                $('#loading').show();

            },
            success: function(data) {
                // console.log(data);
                let html = '';
                let index = 1;
                $('#judulTglHasil').html(`Hasil Pencarian Data Berdasarkan Tanggal : ${tgl}`);
                if (data.length > 0) {
                    data.map((e) => {
                        html += `
                    <tr>
                        <td>${index}</td>
                        <td>${e.no_cm}</td>
                        <td>${e.nama}</td>
                        <td>${e.tgl_lahir.substring(0,10)}</td>
                    </tr>
                    `;
                        index++;
                    });
                    $("#dataHasilTanggal").html(html);
                    $("#hasilTanggal").show();

                    return;
                }
                html += `
                <tr>
                    <td style="text-align:center" colspan="4">Data Tidak ada</td>
                </tr>
                `;
                $("#dataHasilTanggal").html(html);
                $("#hasilTanggal").show();

            },
            error: function(xhr) { // if error occured
            },
            complete: function() {
                $('#loading').hide();
            },
        });
    }

    function pencarianDetailPoli(tgl) {
        $.ajax({
            url: `<?= base_url('irj/rjclaporan/laporan_apm_data_detail_poli?data=') ?>${tgl}`,
            beforeSend: function() {
                $('#loadingPoli').show();

            },
            success: function(data) {
                // console.log(data);
                let html = '';
                let index = 1;
                $('#judulTglHasilPoli').html(`Hasil Pencarian Data Berdasarkan Tanggal : ${tgl}`);
                if (data.length > 0) {
                    data.map((e) => {
                        html += `
                    <tr>
                        <td>${index}</td>
                        <td>${e.no_medrec}</td>
                        <td>${e.tgl_kunjungan.substring(0,10)}</td>
                    </tr>
                    `;
                        index++;
                    });
                    $("#dataHasilTanggalPoli").html(html);
                    $("#hasilTanggalPoli").show();

                    return;
                }
                html += `
                <tr>
                    <td style="text-align:center" colspan="4">Data Tidak ada</td>
                </tr>
                `;
                $("#dataHasilTanggalPoli").html(html);
                $("#hasilTanggalPoli").show();

            },
            error: function(xhr) { // if error occured
            },
            complete: function() {
                $('#loadingPoli').hide();
            },
        });
    }

    function pencarian() {
        let data = $('#pencarianPer').val();
        let pencarianApa = $('#tampil_per').val();


        $.ajax({
            url: `<?= base_url('irj/rjclaporan/laporan_apm_data?pencarian=') ?>${pencarianApa}&data=${data}`,
            beforeSend: function() {
                $('#loading').show();

            },
            success: function(data) {
                if (pencarianApa == 'BLN') {
                    $('#bulanPencarian').html(`Hasil Pencarian Data Berdasarkan Bulan : ${$('#pencarianPer').val().split('-')[1]}`);

                    $("#hasilBulan").show();
                    $("#hasilTahun").hide();
                    let html = '';
                    let index = 1;
                    if (data.length > 0) {
                        data.map((e) => {
                            html += `
                        <tr>
                            <td>${index}</td>
                            <td>${e.tgl}</td>
                            <td>${e.count}</td>
                            <td>
                            <button class="btn btn-primary" onclick="pencarianDetail('${e.tgl}')"><i class="fa fa-book"></i>Lihat Detail</button>
                            </td>
                        </tr>
                        `;
                            index++;
                        });
                        $("#dataHasilBulan").html(html);
                        return;
                    }
                    html += `
                    <tr>
                        <td style="text-align:center" colspan="3">Data Tidak ada</td>
                    </tr>
                    `;
                    $("#dataHasilBulan").html(html);
                    return;
                }
                $('#tahunPencarian').html(`Hasil Pencarian Data Berdasarkan Tahun : ${$('#pencarianPer').val()}`);

                $("#hasilBulan").hide();
                $("#hasilTahun").show();
                let html = '';
                let index = 1;
                data.map((e) => {
                    html += `
                    <tr>
                        <td>${index}</td>
                        <td>${e.tgl}</td>
                        <td>${e.count}</td>
                        <td>
                        <button class="btn btn-primary" onclick="pencarianDetailBulan('${e.tgl}')"><i class="fa fa-book"></i>Lihat Detail</button>
                        </td>
                    </tr>
                    `;
                    index++;
                });
                $("#datahasilTahun").html(html);

            },
            error: function(xhr) { // if error occured
            },
            complete: function() {
                $('#loading').hide();
            },
        });
    }


    function pencarianPoli()
    {
        let data = $('#pencarianPoliPer').val();
        let pencarianApa = $('#tampilPerPoli').val();


        $.ajax({
            url: `<?= base_url('irj/rjclaporan/laporan_apm_data_poli?pencarian=') ?>${pencarianApa}&data=${data}`,
            beforeSend: function() {
                $('#loadingPoli').show();

            },
            success: function(data) {
                if (pencarianApa == 'BLN') {
                    $('#bulanPencarianPoli').html(`Hasil Pencarian Data Berdasarkan Bulan : ${$('#pencarianPoliPer').val().split('-')[1]}`);

                    $("#hasilBulanPoli").show();
                    $("#hasilTahunPoli").hide();
                    $("#hasilTanggalPoli").hide();
                    let html = '';
                    let index = 1;
                    if (data.length > 0) {
                        data.map((e) => {
                            html += `
                        <tr>
                            <td>${index}</td>
                            <td>${e.tgl}</td>
                            <td>${e.count}</td>
                            <td>
                            <button class="btn btn-primary" onclick="pencarianDetailPoli('${e.tgl}')"><i class="fa fa-book"></i>Lihat Detail</button>
                            </td>
                        </tr>
                        `;
                            index++;
                        });
                        $("#dataHasilBulanPoli").html(html);
                        return;
                    }
                    html += `
                    <tr>
                        <td style="text-align:center" colspan="3">Data Tidak ada</td>
                    </tr>
                    `;
                    $("#dataHasilBulanPoli").html(html);
                    return;
                }
                $('#tahunPencarianPoli').html(`Hasil Pencarian Data Berdasarkan Tahun : ${$('#pencarianPoliPer').val()}`);

                $("#hasilBulanPoli").hide();
                $("#hasilTahunPoli").show();
                $("#hasilTanggalPoli").hide();

                let html = '';
                let index = 1;
                data.map((e) => {
                    html += `
                    <tr>
                        <td>${index}</td>
                        <td>${e.tgl}</td>
                        <td>${e.count}</td>
                        <td>
                        <button class="btn btn-primary" onclick="pencarianDetailBulanPoli('${e.tgl}')"><i class="fa fa-book"></i>Lihat Detail</button>
                        </td>
                    </tr>
                    `;
                    index++;
                });
                $("#datahasilTahunPoli").html(html);

            },
            error: function(xhr) { // if error occured
            },
            complete: function() {
                $('#loadingPoli').hide();
            },
        });
    }
</script>
<?php
$this->load->view('layout/footer_left.php');
?>
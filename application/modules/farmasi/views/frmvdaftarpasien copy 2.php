<?php
	$this->load->view('layout/header_left.php');
?>

<style>
.modal-dialog {
    width: 100%;
    height: 100%;
    padding: 0;
    margin: 5px;
}

.modal-content {
    width: 275%;
    height: 100%;
    border-radius: 0;
    color: #333;
    overflow: auto;
}

.close {
    color: black ! important;
    opacity: 1.0;
}

.flex {
    display: flex;
}

.justify-arround {
    justify-content: space-around;
}

h2 {
    font-weight: bold;
}

.input-group-text i.mdi.mdi-calendar {
    font-size: 18px;
    /* Adjust the size as needed */
    color: #555;
    /* Adjust the color as needed */
}

/* Style for the white background div */
.input-group {
    background-color: white;
    /* Add a border for visual separation */
}

.input-group-test {
    border: 1px solid #ccc;

}



/* Style for the icon */
.input-group-text i.mdi.mdi-calendar {
    font-size: 18px;
    /* Adjust the size as needed */
    color: #555;
    /* Adjust the color as needed */
}

.dataTables_filter {
    display: none;
}

.dataTables_length {
    display: none;
}

.dataTables_info {
    margin-left: 1em;
    margin-bottom: 1em;
}

.paginate_button {
    margin-right: 1em;
    margin-bottom: 1em;
}
</style>

<section class="content-header">
    <?php
		echo $this->session->flashdata('success_msg');
	?>
</section>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <h2>DAFTAR ANTRIAN PASIEN FARMASI</h2>

        <div class="row p-t-0 mt-3 mb-3">
            <div class="col-sm-4">
                <div class="input-group input-group-test d-flex align-items-center">
                    <input type="text" class="form-control" id="datepicker-proses" placeholder="Pilih Tanggal">

                    <div class="input-group-prepend mr-2">
                        <span class="input-group-text">
                            <i class="mdi mdi-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-group input-group-test d-flex align-items-center">
                    <input type="text" class="form-control" id="inputcustom-proses" placeholder="Cari Pasien..">
                </div>
            </div>
            <div class="col-sm-4 row d-flex justify-content-end">
                <!-- <div class="mr-2">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#obatModal">Cek
                                Harga Obat</button>
                        </span>
                    </div>
                </div> -->
                <div class="">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-info" data-toggle="modal"
                                data-target="#myModal">Registrasi
                                Pasien Luar</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-block">
                <div class="table-responsive m-t-0">

                    <!-- example datatable server side -->
                    <table class="table table-striped table-bordered" id="table-artikel">
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>Tanggal Kunjungan</th>
                                <th>No BPJS</th>
                                <th>No RM</th>
                                <th>No Registrasi</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <!-- <th>Kelas</th> -->
                                <th>Ruang</th>
                                <th>Cara Bayar</th>
                            </tr>
                        </thead>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php echo form_open('farmasi/Frmcdaftar/daftar_pasien_luar');?>
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog modal-success">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Registrasi Pasien Luar</h4>
				</div>
				<div class="modal-body">
				<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label" id="lbl_nama">Nama</p>
						<div class="col-sm-7">
							<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
							<input type="text" class="form-control" name="nama" id="nama">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label" id="lbl_alamat">Usia</p>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="usia" id="usia">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label" id="lbl_alamat">Jenis Kelamin</p>
						<div class="col-sm-7">
							<select name="jk" id="jk" class="form-control">
								<option value="L">Laki-laki</option>
								<option value="P">Perempuan</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label" id="lbl_alamat">Alamat</p>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="alamat" id="alamat">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 control-label col-form-label">Tanggal Lahir</p>
						<div class="col-sm-7">
							<input type="date" class="form-control date_picker" data-date-format="dd/mm/yyyy" id="tgl_lahir" maxDate="0" placeholder="dd-mm-yyyy" name="tgl_lahir">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label" id="lbl_dokter">Dokter Perujuk</p>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="dokter" id="dokter" placeholder="Isi Jika Ada">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					<button class="btn btn-primary" type="submit">Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php echo form_close();?>


<script>
var table;
$(document).ready(function() {
    table = $("#table-artikel").DataTable({
        language: {
            emptyTable: 'Belum ada antrian pasien farmasi',
            paginate: {
                previous: 'Sebelumnya',
                next: 'Selanjutnya'
            }
        },
        infoCallback: function(settings, start, end, max, total, pre) {
            return `Menampilkan ${start} sampai ${end} dengan total data ${total}`;
        },
        columns: [
            { data: null, render: function (data, type, row) {
                // console.log(row);
                var button = '';
                if (parseInt(data.jml_resep) && data.wkt_telaah_obat != null) {
                    button = `
                     
                        <button class="btn btn-primary btn-sm" onclick="resep('${data.no_register}')">Resep</button><br>
                        <button class="btn btn-primary btn-sm" onclick="telaah('${data.no_register}')">Telaah Obat</button><br>`;
                } else {
                    button = `
                        <button class="btn btn-primary btn-sm"  onclick="resep('${data.no_register}')">Resep</button><br>
                        <button class="btn btn-danger btn-sm"  onclick="telaah('${data.no_register}')">Telaah Obat</button><br>`;
                }
                return button;
            }},
            { data: "tgl", render: function (data) {
                return moment(data).format("D MMMM YYYY h:mm");
            }},
            { data: "bpjs" },
            { data: "no_cm" },
            { data: "no_register" },
            { data: "nama" },
            { data: "alamat" },
            { data: "bed" },
            { data: "cara_bayar" }
        ]
    });
    $("#datepicker-proses").datepicker({
        beforeShow: function(input, inst) {
            inst.dpDiv.css({
                top: $(input).offset().top + $(input).outerHeight(),
                left: $(input).offset().left
            });
        },
        dateFormat: 'yy-mm-dd'
    });



    $('#inputcustom-proses').keyup(function() {
        table.search($(this).val()).draw();
    })

    $("#datepicker-proses").on('change', function() {
        $.ajax({
            url: `<?php echo site_url('farmasi/Frmcdaftar/get_daftar_resep_pasien/'); ?>/${this.value}`,
            success: function(response) {
                var formattedData = response.map(function(item) {
                return {
                    wkt_telaah_obat:item.wkt_telaah_obat,
                    no_register:item.no_register,
                    jml_resep: item.jml_resep,
                    tgl_kunjungan: moment(item.tgl_kunjungan).format("D MMMM YYYY"),
                    no_sep: item.no_sep,
                    no_cm: item.no_cm,
                    nama: item.nama,
                    alamat: item.alamat,
                    bed: item.bed,
                    cara_bayar: item.cara_bayar,
                    tgl: item.tgl,
                    bpjs: item.no_kartu
                };
            });

            // Clear the DataTable and add the formatted data
            table.clear().rows.add(formattedData).draw();
            }
        });
    });
    $.ajax({
        url: `<?php echo site_url('farmasi/Frmcdaftar/get_daftar_resep_pasien/'.date('Y-m-d')); ?>`,
        success: function(response) {
            // console.log(response);
            var formattedData = response.map(function(item) {
            return {
                wkt_telaah_obat:item.wkt_telaah_obat,
                no_register:item.no_register,
                jml_resep: item.jml_resep,
                tgl_kunjungan: moment(item.tgl_kunjungan).format("D MMMM YYYY"),
                no_sep: item.no_sep,
                no_cm: item.no_cm,
                nama: item.nama,
                alamat: item.alamat,
                bed: item.bed,
                cara_bayar: item.cara_bayar,
                tgl: item.tgl,
                bpjs: item.no_kartu
            };
        });

        // Clear the DataTable and add the formatted data
        table.clear().rows.add(formattedData).draw();
        }
    });
})

function resep(noreg) {
    // ini untuk yg dulu

    // window.open(`<?php //echo base_url('farmasi/frmcdaftar/permintaan_obat/') ?>/${noreg}/PETUGAS`, '_blank');
    // ini untuk yg baru
    window.open(`<?= base_url('farmasi/frmcdaftar/permintaan_obat_petugas?no_register=') ?>${noreg}`, '_blank');
}

function telaah(noreg) {
    window.open(`<?= base_url('farmasi/Frmcdaftar/telaah_obat/') ?>/${noreg}`, '_blank');

}

function selesai(noreg) {
    $.ajax({
        dataType: "json",
        type: 'POST',
        url: `<?php echo site_url('farmasi/Frmcdaftar/force_selesai/'); ?>/${noreg}`,
        success: function(response) {
            if(response.code == 200){
                window.open('<?= base_url() ?>' + '/' + response.cetak)
            }
            swal({
                    title: "Success",
                    text: "Berhasil Simpan Data",
                    type: "success",
                    showConfirmButton: true
                },
                function() {
                    $.ajax({
                        url: `<?php echo site_url('farmasi/Frmcdaftar/get_daftar_resep_pasien/'.date('Y-m-d')); ?>`,
                        success: function(response) {
                            // console.log(response);
                            var formattedData = response.map(function(item) {
                            return {
                                wkt_telaah_obat:item.wkt_telaah_obat,
                                no_register:item.no_register,
                                jml_resep: item.jml_resep,
                                tgl_kunjungan: moment(item.tgl_kunjungan).format("D MMMM YYYY"),
                                no_sep: item.no_sep,
                                no_cm: item.no_cm,
                                nama: item.nama,
                                alamat: item.alamat,
                                bed: item.bed,
                                cara_bayar: item.cara_bayar,
                                tgl: item.tgl
                            };
                        });

                        // Clear the DataTable and add the formatted data
                        table.clear().rows.add(formattedData).draw();
                        }
                    });
                });
        }
    });
}
// <button class="btn btn-primary btn-sm" onclick="selesai('${data.no_register}')">Selesai</button>
</script>
<script src="<?= base_url() ?>asset/js/jquery-ui.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.dataTables1.13.min.js"></script>

<?php
	$this->load->view('layout/footer_left.php');
?>
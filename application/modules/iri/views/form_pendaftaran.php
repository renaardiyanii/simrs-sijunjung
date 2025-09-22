<?php if ($role_id == 1) {
	$this->load->view("layout/header_left");
} else {
	$this->load->view("layout/header_left");
} ?>
<?php
if (isset($pasien_iri)) {
	$data_pasien_iri = isset($pasien_iri[0]) ? $pasien_iri[0] : '';
}

// var_dump($selisih_tarif);die();

?>

<!-- dua ini nanti pindahkan ke local @aldi -->
<link href="<?= base_url('assets/survey/') ?>modern.css" type="text/css" rel="stylesheet" />
<script src="<?= base_url('assets/survey/') ?>survey.jquery.min.js"></script>
<!-- ini pr ya sampe sini -->

<style type="text/css">
	.title {
		font-size: 12pt;
		font-weight: bold;
	}

	.subtitle {
		font-size: 9pt;
		font-weight: light;
	}

	.hr {
		background-color: gray;
		height: 1px;
		width: 22%;
		margin-left: 4em;
		margin-right: 4em;
		margin-bottom: 2em;
	}

	.list-group-item {
		display: flex;
		flex-direction: column;
		align-items: flex-start;
	}

	.js-example-basic-single {
		z-index: 9999;
	}

	/* flex justify-start align-center */
</style>

<script type='text/javascript'>
	$(document).ready(function() {

		var alreadyPasien = 0;
		var penanggungJawab = 0;
		var general_consent = 0;
		var suratPersetujuan = 0;
		<?php
		if (count($pasien_iri)) {
		?>
			alreadyPasien = 1;

		<?php } ?>

		<?php
		if (isset($pasien_iri[0]->nmpjawabri) && $pasien_iri[0]->nmpjawabri) {
		?>
			penanggungJawab = 1;
		<?php } ?>

		<?php
		if (isset($pasien_iri[0]->nmpjawabri) && $pasien_iri[0]->nmpjawabri && count($general_consent)) {
		?>
			general_consent = 1;
		<?php
		}
		?>

		if (alreadyPasien === 1 && penanggungJawab === 0 && general_consent === 0) {
			$("#collapseOne").collapse('hide');
			$('#collapseTwo').collapse('show');

		}

		if (alreadyPasien === 1 && penanggungJawab === 1 && general_consent === 0) {
			$("#collapseOne").collapse('hide');
			$('#collapseTwo').collapse('hide');
			$('#collapseThree').collapse('show');

		}



		if (alreadyPasien === 1 && penanggungJawab === 1 && general_consent === 1) {
			$("#collapseOne").collapse('hide');
			$('#collapseTwo').collapse('hide');
			$('#collapseThree').collapse('hide');
			$('#collapseFour').collapse('show');
		}


		$("#ruang").prop('required', true);
		$('#div_rujukan').hide();
		$('#loading-rujukan').hide();
		$('.showbayi').hide();

		if ($('#barulahir').prop('checked') == true) {

			$('#input_regibu').show();
			$('.hidebayi').hide();
			$("#ruang").prop('required', false);
			// $('.showbayi').show();

			// $('.show-for-bayi').show();


		} else {
			$('#input_regibu').hide();

		}

		$('#barulahir').change(function() {
			if ($(this).prop('checked') == true) {
				$('#input_regibu').show();
				$('.hidebayi').hide();
				$('.showbayi').show();
				$("#ruang").prop('required', false);



			} else {
				$('#input_regibu').hide();
				$('.hidebayi').show();
				$('.showbayi').hide();
			}
		});

		$(document).on("click", ".select-kode-dpjp", function() {
			$("#dpjp_skdp_sep").val($(this).data('kodedpjp'));
			$('#modal-search-kode').modal('hide');
		});
		$(document).on("click", "#btn-cari-dpjp", function() {
			var button = $(this);
			button.html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('bpjs/referensi/dokter_dpjp/1/none'); ?>",
				dataType: "JSON",
				success: function(result) {
					$('#modal-search-kode').modal('show');
					$('#table-dpjp > tbody').empty();
					button.html('<i class="fa fa-search"></i> Cari Kode');
					if (result != '' || result != null) {
						if (result.metaData.code == '200') {
							$.each(result.response.list, function(i, item) {
								$('#table-dpjp > tbody:last-child').append(
									'<tr>' +
									'<td class="text-center">' + item.kode + '</td>' +
									'<td class="text-center">' + item.nama + '</td>' +
									'<td class="text-center"><button class="btn btn-danger select-kode-dpjp" data-kodedpjp="' + item.kode + '"><i class="fa fa-check"></i> Pilih</button></td>' +
									'</tr>'
								);
							});
						} else {
							$('#table-dpjp > tbody:last-child').append(
								'<tr>' +
								'<td colspan="3" class="text-center">' + result.metaData.message + '</td>' +
								'</tr>'
							);
						}
					} else {
						swal("Error", "Gagal load data dokter dpjp.", "error");
					}
				},
				error: function(event, textStatus, errorThrown) {
					button.html('<i class="fa fa-search"></i> Cari Kode');
					swal("Error", formatErrorMessage(event, errorThrown), "error");
					console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
				}
			});
		});
		$(document).on("click", "#btn-cek-kartu", function() {
			var button = $(this);
			var no_bpjs = $("#no_bpjs").val();
			button.html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
			if (no_bpjs == '') {
				button.html('Cek Kartu BPJS');
				swal("No. Kartu Kosong", "Harap masukan nomor kartu BPJS.", "warning");
			} else {
				$.ajax({
					url: "<?php echo site_url('bpjs/peserta/cari_peserta?pencarian=nokartu&nomor='); ?>" + no_bpjs,
					dataType: "JSON",
					success: function(result) {
						// console.log(result);
						if (result) {
							button.html('Cek Kartu BPJS');
							if (result.metaData.code == '200') {
								data = result.response.peserta;

								$('.modal_nobpjs').modal('show');
								if (data.jenisPeserta.kode === "22") {
									idReplace = 3;
								} else if (data.jenisPeserta.kode === '14') {
									idReplace = 17;
								} else {
									idReplace = 60;
								}
								$('#nmkontraktorbpjs').val(idReplace).trigger('change');

								document.getElementById("bpjs_noka").innerHTML = data.noKartu;
								document.getElementById("bpjs_nik").innerHTML = data.nik;
								document.getElementById("bpjs_nama").innerHTML = data.nama;
								document.getElementById("bpjs_gender").innerHTML = data.sex;
								document.getElementById("bpjs_tgl_lahir").innerHTML = data.tglLahir;
								document.getElementById("bpjs_no_telepon").innerHTML = data.mr.noTelepon;
								document.getElementById("bpjs_kdprovider").innerHTML = data.provUmum.kdProvider;
								document.getElementById("bpjs_nmprovider").innerHTML = data.provUmum.nmProvider;
								document.getElementById("bpjs_jnspeserta").innerHTML = data.jenisPeserta.keterangan;
								document.getElementById("bpjs_nmkelas").innerHTML = data.hakKelas.keterangan;
								document.getElementById("bpjs_status_keterangan").innerHTML = data.statusPeserta.keterangan;
								document.getElementById("bpjs_cob_nama").innerHTML = data.cob.nmAsuransi;
								document.getElementById("bpjs_cob_nomor").innerHTML = data.cob.noAsuransi;
								document.getElementById("bpjs_cob_tat").innerHTML = data.cob.tglTAT;
								document.getElementById("bpjs_cob_tmt").innerHTML = data.cob.tglTMT;
								document.getElementById("bpjs_informasi_dinsos").innerHTML = data.informasi.dinsos;
								document.getElementById("bpjs_informasi_sktm").innerHTML = data.informasi.noSKTM;
								document.getElementById("bpjs_informasi_prb").innerHTML = data.informasi.prolanisPRB;
							} else {
								swal("Gagal Cek Kartu BPJS.", result.metaData.message, "error");
							}
						} else {
							button.html('Cek Kartu BPJS');
							swal("Error", "Gagal Cek Kartu BPJS.", "error");
						}
					},
					error: function(event, textStatus, errorThrown) {
						button.html('Cek Kartu BPJS');
						swal("Error", "Gagal Cek Kartu BPJS.", "error");
						console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
					}
				});
			}
		});

		var kls_bpjs = "<?php echo $kls_bpjs; ?>";
		//alert(kls_bpjs);
		if (kls_bpjs != '' || kls_bpjs != null) {
			$('#jatahkls').val(kls_bpjs).change();
		}
		var cara_bayar = '<?= isset($pasien_iri[0]->carabayar) ? $pasien_iri[0]->carabayar : $data_pasien[0]['cara_bayar'] ?>';
		$('#cara_bayar').val(cara_bayar);
		if (cara_bayar == "BPJS") {
			$('.form_bpjs').show();
			$('#div_rujukan').show();
			$('.form_perusahaan').hide();
			document.getElementById("nmkontraktorbpjs").required = false;
			document.getElementById("no_bpjs").required = true;

		} else if (cara_bayar == "KERJASAMA") {
			$('.form_bpjs').hide();
			$('#div_rujukan').hide();
			$('.form_perusahaan').show();
			document.getElementById("nmkontraktorbpjs").required = false;
			document.getElementById("no_bpjs").required = false;
		} else {
			$('.form_bpjs').hide();
			$('#div_rujukan').hide();
			$('.form_perusahaan').hide();
			document.getElementById("nmkontraktorbpjs").required = false;
			document.getElementById("no_bpjs").required = false;
		}

	});








	$(function() {
		<?php if ($data_pasien[0]['sex'] == 'L') { ?>
			$('#laki_laki').attr('selected', 'selected');
			$('#perempuan').removeAttr('selected', 'selected');
		<?php } else { ?>
			$('#laki_laki').removeAttr('selected', 'selected');
			$('#perempuan').attr('selected', 'selected');
		<?php } ?>
	});

	var site = "<?php echo site_url(); ?>";
	$(function() {
		$('.auto_ruang').autocomplete({
			serviceUrl: site + '/iri/ricpendaftaran/data_ruang',
			onSelect: function(suggestion) {
				$('#ruang').val('' + suggestion.idrg);
				$('#nm_ruang').val('' + suggestion.nmruang);
				$('#kelas').val('' + suggestion.kelas);
			}
		});
	});


	function get_bed_ibu(val) {
		$('#bed')
			.find('option')
			.remove()
			.end();
		$("#bed").append("<option value=''>Loading...</option>");
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>iri/ricmutasi/get_empty_bed_select_ibu/",
			data: {
				val: val
			},
		}).done(function(msg) {
			$('#bed')
				.find('option')
				.remove()
				.end();
			$("#bed").append(msg);
		});
	}

	function get_bed(val) {
		$('#bed')
			.find('option')
			.remove()
			.end();
		$("#bed").append("<option value=''>Loading...</option>");
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>iri/ricmutasi/get_empty_bed_select/",
			data: {
				val: val
			},
		}).done(function(msg) {
			$('#bed')
				.find('option')
				.remove()
				.end();
			$("#bed").append(msg);
		});
	}

	var site = "<?php echo site_url(); ?>";
	$(function() {
		$('.auto_no_register_dokter').autocomplete({
			serviceUrl: site + '/iri/ricpendaftaran/data_dokter_autocompwithoutpoli',
			onSelect: function(suggestion) {
				$('#id_dokter').val('' + suggestion.id_dokter);
				$('#nmdokter').val('' + suggestion.nm_dokter);
			}
		});
	});

	// buat pendaftaran ibu
	var site = "<?php echo site_url(); ?>";
	$(function() {
		$('.auto_no_ipd_pasien').autocomplete({
			// serviceUrl: site+'/iri/ricreservasi/data_pasien_irj',
			serviceUrl: site + '/iri/ricpasien/data_pasien_auto',
			onSelect: function(suggestion) {
				$('#ipdnama').val('' + suggestion.no_ipd + ' - ' + suggestion.nama);
				$('#noipdibu').val('' + suggestion.no_ipd);
			}
		});
	});

	function cek_kartu_bpjs() {
		var no_bpjs = $('#no_bpjs').val();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>iri/ricstatus/cek_kartu_bpjs/",
			data: {
				no_bpjs: no_bpjs
			},
		}).done(function(msg) {
			if (msg == "") {
				document.getElementById("data_validasi").innerHTML = "Data Tidak Ditemukan";
			} else {
				document.getElementById("data_validasi").innerHTML = msg;
			}
			$('#modal_validasi').modal('show');
		});
	}

	var site = "<?php echo site_url(); ?>";
	$(function() {
		$('.auto_diagnosa_pasien').autocomplete({
			serviceUrl: site + 'iri/ricstatus/data_icd_1',
			onSelect: function(suggestion) {
				$('#diagnosa').val(suggestion.id_icd + ' - ' + suggestion.nm_diagnosa);
				$('#diagnosa_id').val('' + suggestion.id_icd);
			}
		});
	});

	function update_form_bpjs(cara_bayar) {

		if (cara_bayar == "BPJS") {
			$('.form_bpjs').show();
			$('#div_rujukan').show();
			$('.form_perusahaan').hide();
			//nmkontraktorbpjs
			document.getElementById("nmkontraktorbpjs").required = true;
			document.getElementById("no_bpjs").required = true;
		} else if (cara_bayar == "KERJASAMA") {
			$('.form_bpjs').hide();
			$('#div_rujukan').hide();
			$('.form_perusahaan').show();
			document.getElementById("nmkontraktorbpjs").required = true;
			document.getElementById("no_bpjs").required = false;
		} else {
			$('#div_rujukan').hide();
			$('.form_bpjs').hide();
			$('.form_perusahaan').hide();
			document.getElementById("nmkontraktorbpjs").required = false;
			document.getElementById("no_bpjs").required = false;
		}
	}
	var ajaxku;

	function buatajax() {
		if (window.XMLHttpRequest) {
			return new XMLHttpRequest();
		}
		if (window.ActiveXObject) {
			return new ActiveXObject("Microsoft.XMLHTTP");
		}
		return null;
	}

	function search_dpjp() {
		var input, filter, table, tr, td, i;
		input = document.getElementById("search_dpjp");
		filter = input.value.toUpperCase();
		table = document.getElementById("table-dpjp");
		tr = table.getElementsByTagName("tr");
		for (i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td")[1];
			if (td) {
				if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
					tr[i].style.display = "";
				} else {
					tr[i].style.display = "none";
				}
			}
		}
	}
</script>


<!-- Accordion -->
<div id="accordion">
	<div class="card mt-2 mb-2 ">
		<div class="list-group list-group-flush">
			<div class="list-group-item">
				<div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					<div class="row">
						<div class="img mr-3 ml-3 mt-2">
							<img width="30px" src="<?= base_url('assets/icons/') ?><?= ($pasien_iri) ? 'check.png' : 'uncheck.png' ?>" alt="">
						</div>
						<div>
							<a>
								<span class="title" style="font-weight:medium;font-size:12pt">Pendaftaran Pasien Rawat Inap</span>
							</a><br>
							<span class="subtitle"><?= ($pasien_iri) ? 'Pengisian Formulir Sudah Selesai' : 'Pengisian Formulir Belum Selesai' ?></span>
						</div>

					</div>

				</div>



				<div id="collapseOne" class="collapse show ml-2 mr-2 mt-4" aria-labelledby="headingOne" data-parent="#accordion">
					<?php include('form/formpendaftaraniri.php') ?>

				</div>
			</div>

			<div class="list-group-item">
				<div class="card-header " data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" id="headingTwo">
					<div class="row">
						<div class="img mr-3 ml-3 mt-2">
							<img width="30px" src="<?= base_url('assets/icons/') ?><?= isset($pasien_iri[0]->nmpjawabri) && $pasien_iri[0]->nmpjawabri ? 'check.png' : 'uncheck.png' ?>" alt="">
						</div>
						<div>
							<a>
								<span class="title" style="font-weight:medium;font-size:12pt">Penanggung Jawab Pasien Rawat Inap</span>
							</a><br>
							<span class="subtitle"><?= isset($pasien_iri[0]->nmpjawabri) && $pasien_iri[0]->nmpjawabri ? 'Pengisian Formulir Penanggung Jawab Sudah Selesai' : 'Pengisian Formulir Penanggung Jawab Belum Selesai' ?></span>
						</div>

					</div>

				</div>

				<div id="collapseTwo" class="collapse ml-2 mr-2 mt-4" aria-labelledby="headingTwo" data-parent="#accordion">
					<?php include('form/formpenanggungjawab.php') ?>

				</div>
			</div>
			<div class="list-group-item">
				<div class="card-header " data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree" id="headingThree">
					<div class="row">
						<div class="img mr-3 ml-3 mt-2">
							<img width="30px" src="<?= base_url('assets/icons/') ?><?= isset($leaflet_hak->formjson) && $leaflet_hak->formjson ? 'check.png' : 'uncheck.png' ?>" alt="">
						</div>
						<div>
							<a>
								<span class="title" style="font-weight:medium;font-size:12pt">Tanda Terima Leaflet Hak & Kewajiban Pasien</span>
							</a><br>
							<span class="subtitle"><?= isset($leaflet_hak->formjson) && $leaflet_hak->formjson ? 'Pengisian Formulir Tanda Terima Leaflet Hak & Kewajiban Pasien Sudah Selesai' : 'Pengisian Formulir get_pengkajian_medis Belum Selesai' ?></span>
						</div>

					</div>

				</div>

				<div id="collapseThree" class="collapse ml-2 mr-2 mt-4" aria-labelledby="headingThree" data-parent="#accordion">
					<?php include('emr/leaflet_hak/tanda_terima_leaflet_hak.php') ?>

				</div>
			</div>

			<div class="img mr-3 ml-3 mt-2 mb-3">
				<div class="row ml-3">
					<a href="<?= base_url('iri/ricdaftar/index/1') ?>" class="btn btn-primary"> Kembali </a>&nbsp;&nbsp;&nbsp;&nbsp;
					<?php 
					if(isset($pasien_iri[0]->noregasal)){ ?>
						<a href="<?= base_url('iri/Ricpendaftaran/update_irna_antrian/' . $pasien_iri[0]->noregasal) ?>" class="btn btn-primary"> Selesai </a>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="<?= base_url('iri/Ricpendaftaran/cetak_gelang/' . $pasien_iri[0]->no_medrec) ?>" class="btn btn-primary" target="_blank"> Cetak Label </a>
					<?php }else{ ?>

					<?php }
					?>
					
				</div>
			</div>

			
			

		</div>


	</div>
</div>
<!-- Accordion -->
<script>
	$('#calendar-tgl-daftar').datepicker({
		format: 'yyyy-mm-dd'
	});
	$('#calendar-tgl-lahir').datepicker({
		format: 'yyyy-mm-dd'
	});
</script>

<div class="modal fade modal_nobpjs" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<img class="pull-left" src="<?php echo site_url('assets/images/logos/logo_bpjs.png'); ?>" width="120"></img>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<h4 class="text-center text-bold">DATA PESERTA BPJS</h4>
				<div class="table-responsive m-t-30" style="clear: both;">
					<table class="table-xs table-hover" width="100%">
						<tbody>
							<tr>
								<td style="width: 25%;">No. Kartu BPJS</td>
								<td style="width: 3%;">:</td>
								<td id="bpjs_noka"></td>
							</tr>
							<tr>
								<td style="width: 25%;">NIK</td>
								<td style="width: 3%;">:</td>
								<td id="bpjs_nik"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Nama</td>
								<td style="width: 3%;">:</td>
								<td id="bpjs_nama"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Jenis Kelamin</td>
								<td style="width: 3%;">:</td>
								<td id="bpjs_gender"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Tanggal Lahir</td>
								<td style="width: 3%;">:</td>
								<td id="bpjs_tgl_lahir"></td>
							</tr>
							<tr>
								<td style="width: 25%;">No. Telepon</td>
								<td style="width: 3%;">:</td>
								<td id="bpjs_no_telepon"></td>
							</tr>
						</tbody>
					</table>
					<hr>
					<h5 class="text-bold" style="font-size: 15px;color: ededed;font-weight: 600;">Provider Umum</h5>
					<table class="table-xs table-hover" width="100%">
						<tbody>
							<tr>
								<td style="width: 25%;">Kode Provider</td>
								<td style="width: 3%;">:</td>
								<td id="bpjs_kdprovider"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Nama Provider</td>
								<td style="width: 3%;">:</td>
								<td id="bpjs_nmprovider"></td>
							</tr>
						</tbody>
					</table>
					<hr>
					<h5 class="text-bold" style="font-size: 15px;color: ededed;font-weight: 600;">Jenis Peserta</h5>
					<table class="table-xs table-hover" width="100%">
						<tbody>
							<tr>
								<td style="width: 25%;">Jenis Peserta</td>
								<td style="width: 3%;">:</td>
								<td id="bpjs_jnspeserta"></td>
							</tr>
						</tbody>
					</table>
					<hr>
					<h5 class="text-bold" style="font-size: 15px;color: ededed;font-weight: 600;">Hak Kelas</h5>
					<table class="table-xs table-hover" width="100%">
						<tbody>
							<tr>
								<td style="width: 25%;">Nama Kelas</td>
								<td style="width: 3%;">:</td>
								<td id="bpjs_nmkelas"></td>
							</tr>
						</tbody>
					</table>
					<hr>
					<h5 class="text-bold" style="font-size: 15px;color: ededed;font-weight: 600;">Status Peserta</h5>
					<table class="table-xs table-hover" width="100%">
						<tbody>
							<tr>
								<td style="width: 25%;">Keterangan</td>
								<td style="width: 3%;">:</td>
								<td id="bpjs_status_keterangan"></td>
							</tr>
						</tbody>
					</table>
					<hr>
					<h5 class="text-bold" style="font-size: 15px;color: ededed;font-weight: 600;">COB</h5>
					<table class="table-xs table-hover" width="100%">
						<tbody>
							<tr>
								<td style="width: 25%;">Nama Asuransi</td>
								<td style="width: 3%;">:</td>
								<td id="bpjs_cob_nama"></td>
							</tr>
							<tr>
								<td style="width: 25%;">No. Asuransi</td>
								<td style="width: 3%;">:</td>
								<td id="bpjs_cob_nomor"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Tanggal TAT</td>
								<td style="width: 3%;">:</td>
								<td id="bpjs_cob_tat"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Tanggal TMT</td>
								<td style="width: 3%;">:</td>
								<td id="bpjs_cob_tmt"></td>
							</tr>
						</tbody>
					</table>
					<hr>
					<h5 class="text-bold" style="font-size: 15px;color: ededed;font-weight: 600;">Informasi</h5>
					<table class="table-xs table-hover" width="100%">
						<tbody>
							<tr>
								<td style="width: 25%;">Dinsos</td>
								<td style="width: 3%;">:</td>
								<td id="bpjs_informasi_dinsos"></td>
							</tr>
							<tr>
								<td style="width: 25%;">No. SKTM</td>
								<td style="width: 3%;">:</td>
								<td id="bpjs_informasi_sktm"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Prolanis PRB</td>
								<td style="width: 3%;">:</td>
								<td id="bpjs_informasi_prb"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
</div>
<div id="modal-search-kode" class="modal modal-search-kode fade" role="dialog" aria-labelledby="modal-search-kode" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-success">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="modal-search-kode">Cari Kode DPJP (BPJS)</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group row">
							<div class="col-sm-12">
								<div class="input-group">
									<span class="input-group-btn">
										<button class="btn btn-info" type="button"><i class="fa fa-search"></i></button>
									</span>
									<input type="text" class="form-control" id="search_dpjp" onkeyup="search_dpjp()" placeholder="Ketikan Nama Dokter DPJP..">
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="table-wrapper-scroll-y">
							<table width="100%" class="table table-bordered table-condensed" id="table-dpjp">
								<thead>
									<tr>
										<th class="text-center" width="22%"><b>Kode DPJP</b></th>
										<th class="text-center" width="63%"><b>Nama Dokter</b></th>
										<th class="text-center" width="15%"><b>Aksi</b></th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>


<!-- Modal General Consent -->
<!-- Modal -->


<script>
	$(document).ready(function() {
		$('#formInsertPasien').on('submit', function(e) {
			e.preventDefault();
			// $('#simpan-pendaftaran')
			document.getElementById("simpan-pendaftaran").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
			document.getElementById("simpan-pendaftaran").disabled = true;
			$.ajax({
				url: "<?php echo base_url('iri/ricpendaftaran/insert_pendaftaran') ?>",
				type: "POST",
				data: $('#formInsertPasien').serialize(),
				dataType: "JSON",
				success: function(data) {

					console.log(data.code);
					new swal({
							title: data.code === 1 ? "Selesai" : 'Gagal',
							text: data.code === 1 ? "Data berhasil disimpan" : data.message,
							type: data.code === 1 ? "success" : 'error',
							showCancelButton: false,
							closeOnConfirm: true,

						},
						function() {
							data.code === 1 ? window.location.reload() : null;
						});

				},
				error: function(jqXHR, textStatus, errorThrown) {
					// window.location.reload();
					// alert(errorThrown);
				}
			});
		});

	});
</script>


<?php $this->load->view("layout/footer_left"); ?>
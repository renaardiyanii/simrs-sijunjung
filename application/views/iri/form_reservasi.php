<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
?>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>

<script>
var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_no_register_rawatjalan').autocomplete({
		serviceUrl: site+'/iri/ricreservasi/data_pasien_irj',
		onSelect: function (suggestion) {
			//$('#no_cm').val(''+suggestion.no_cm);
			$('#no_cm').val(''+suggestion.no_cm_real);
			$('#no_cm_h').val(''+suggestion.no_cm);
			$('#nama').val(''+suggestion.nama);
			$('.tanggal_lahir').val(''+suggestion.tanggal_lahir);
			if(suggestion.jenis_kelamin=='L'){
				$('#laki_laki').attr('selected', 'selected');
				$('#perempuan').removeAttr('selected', 'selected');
			}else{
				$('#laki_laki').removeAttr('selected', 'selected');
				$('#perempuan').attr('selected', 'selected');
			}
			$('#telp').val(''+suggestion.telp);
			$('#hp').val(''+suggestion.hp);
			$('#id_poli').val(''+suggestion.id_poli);
			$('#poliasal').val(''+suggestion.poliasal);
			$('#id_dokter').val(''+suggestion.id_dokter);
			$('#dokter').val(''+suggestion.dokter);
			$('#diagnosa').val(suggestion.diagnosa_id+' - '+suggestion.diagnosa);
			$('#diagnosa_id').val(''+suggestion.diagnosa_id);
		}
	});
});

function cek_rujukan(){
	$('#loading-rujukan').show();
	var no_rujukan = document.getElementById("nosjp").value;
	var e = document.getElementById("id_smf");
	var get_cara_kunjungan = e.options[e.selectedIndex].value;
	if (get_cara_kunjungan == 'RUJUKAN RS') {
		var cara_kunjungan = 'RS';
	}
	else {
		var cara_kunjungan = 'PCare';
	}
	if (no_rujukan.length == 0) {
	$('#loading-rujukan').hide();		
	swal("Cek Nomor Rujukan", "Silahkan masukkan nomor rujukan", "error");
	}
	else {
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcwebservice/check_no_rujukan'); ?>";
    url=url+"/"+no_rujukan+"/"+cara_kunjungan;
    ajaxku.onreadystatechange=stateChangedValidasiRujukan;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
    }
}

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_no_register_ruangrawat').autocomplete({
		serviceUrl: site+'/iri/ricreservasi/data_pasien_iri',
		onSelect: function (suggestion) {
			$('#no_cm').val(''+suggestion.no_cm);
			$('#no_cm_h').val(''+suggestion.no_cm);
			$('#nama').val(''+suggestion.nama);
			$('.tanggal_lahir').val(''+suggestion.tanggal_lahir);
			if(suggestion.jenis_kelamin=='L'){
				$('#laki_laki').attr('selected', 'selected');
				$('#perempuan').removeAttr('selected', 'selected');
			}else{
				$('#laki_laki').removeAttr('selected', 'selected');
				$('#perempuan').attr('selected', 'selected');
			}
			$('#telp').val(''+suggestion.telp);
			$('#hp').val(''+suggestion.hp);
			$('#id_poli').val(''+suggestion.id_poli);
			$('#poliasal').val(''+suggestion.poliasal);
			$('#id_dokter').val(''+suggestion.id_dokter);
			$('#dokter').val(''+suggestion.dokter);
			$('#diagnosa').val(suggestion.diagnosa_id+' - '+suggestion.diagnosa);
			$('#diagnosa_id').val(''+suggestion.diagnosa_id);
		}
	});
});

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_no_register_rawatdarurat').autocomplete({
		serviceUrl: site+'/iri/ricreservasi/data_pasien_ird',
		onSelect: function (suggestion) {
			//$('#no_cm').val(''+suggestion.no_cm);
			$('#no_cm').val(''+suggestion.no_cm_real);
			$('#no_cm_h').val(''+suggestion.no_cm);
			$('#nama').val(''+suggestion.nama);
			$('.tanggal_lahir').val(''+suggestion.tanggal_lahir);
			if(suggestion.jenis_kelamin=='L'){
				$('#laki_laki').attr('selected', 'selected');
				$('#perempuan').removeAttr('selected', 'selected');
			}else{
				$('#laki_laki').removeAttr('selected', 'selected');
				$('#perempuan').attr('selected', 'selected');
			}
			$('#telp').val(''+suggestion.telp);
			$('#hp').val(''+suggestion.hp);
			$('#id_poli').val(''+suggestion.id_poli);
			$('#poliasal').val(''+suggestion.poliasal);
			$('#id_dokter').val(''+suggestion.id_dokter);
			$('#dokter').val(''+suggestion.dokter);
			$('#diagnosa').val(suggestion.diagnosa_id+' - '+suggestion.diagnosa);
			$('#diagnosa_id').val(''+suggestion.diagnosa_id);
		}
	});
});

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_ruang').autocomplete({
		serviceUrl: site+'/iri/ricreservasi/data_ruang',
		onSelect: function (suggestion) {
			$('#ruang').val(''+suggestion.idrg);
			$('#nm_ruang').val(''+suggestion.nmruang);
			//$('#kelas').val(''+suggestion.kelas);
		}
	});
});

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_no_register_dokter').autocomplete({
		serviceUrl: site+'/iri/ricpendaftaran/data_dokter_autocomp',
		onSelect: function (suggestion) {
			$('#id_dokter').val(''+suggestion.id_dokter);
			$('#nmdokter').val(''+suggestion.nm_dokter);
		}
	});
});

var table=null;
$(document).ready(function() {

	$('#calendar-tgl-lahir').datepicker({
		format: 'yyyy-mm-dd',
		minDate: 0
	});
	$('#calendar-tgl-sp-rawat').datepicker({
		format: 'yyyy-mm-dd',
		minDate: 0
	});
	$('#calendar-tgl-rencana-masuk').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true,
		minDate: '0'
	});

	$('.tgl_jadwal_ok').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true,
		minDate: '0'
	});
	$("#calendar-tgl-rencana-masuk").datepicker("setDate", new Date());
	
	// $("#form_reservasi").validate({ 
	// 	rules: { 
	// 		noreservasi: "required",
	// 		no_cm: "required",
	// 		nama: "required",
	// 		tgllahir: "required",
	// 		telp: "required",
	// 		poliasal: "required",
	// 		dokter: "required",
	// 		diagnosa: "required",
			
	// 		tglrencanamasuk: "required",
	// 		tglsprawat: "required",
	// 		nm_ruang: "required",
	// 		kelas: "required",
	// 		keterangan: "required"
	// 	}
	// }); 
	
	$('#pilihan_prioritas').change(function(){
		var kasus = $('#pilihan_prioritas').val();
		if(kasus=='-'){
			$('#normal').attr('selected', 'selected');
			$('#high').removeAttr('selected', 'selected');
		}else{
			$('#normal').removeAttr('selected', 'selected');
			$('#high').attr('selected', 'selected');
		}
	});
	
	<?php
	if($data_pasien == ''){ ?>
		$(function(){
			$('#no_register_rawatjalan').show();
			$('#no_register_ruangrawat').hide();
			$('#no_register_rawatdarurat').hide();
			document.getElementById("no_register_rawatjalan").required = true;
			document.getElementById("no_register_ruangrawat").required = false;
			document.getElementById("no_register_rawatdarurat").required = false;
		});
	<?php
	}
	?>
	
	$('#tppri').change(function(){
			var tppri = $('#tppri').val();
			if(tppri=='rawatjalan'){
				document.getElementById("no_register_rawatjalan").required = true;
				document.getElementById("no_register_ruangrawat").required = false;
				document.getElementById("no_register_rawatdarurat").required = false;
				$('#no_register_rawatjalan').show();
				$('#no_register_ruangrawat').hide();
				$('#no_register_rawatdarurat').hide();
			}else if(tppri=='ruangrawat'){
				document.getElementById("no_register_rawatjalan").required = false;
				document.getElementById("no_register_ruangrawat").required = true;
				document.getElementById("no_register_rawatdarurat").required = false;
				$('#no_register_rawatjalan').hide();
				$('#no_register_ruangrawat').show();
				$('#no_register_rawatdarurat').hide();
			}else{
				document.getElementById("no_register_rawatjalan").required = false;
				document.getElementById("no_register_ruangrawat").required = false;
				document.getElementById("no_register_rawatdarurat").required = true;
				$('#no_register_rawatjalan').hide();
				$('#no_register_ruangrawat').hide();
				$('#no_register_rawatdarurat').show();
			}
		});

	/*<th>No Reservasi</th>
								<th>Asal</th>
								<th>No MR</th>
								<th>Nama</th>								
								<th>Cara Bayar</th>
								<th>Prioritas</th>
								<th>Dokter</th>
								<th>Ket</th>
								<th>Tanggal</th>
								<th>Waktu</th>*/
	tablejadwalok('');
	tablejadwalinap('');

	var v00 = $("#formsearchok").validate({
      rules: {
        tglok: {
          required: true
        }
      },
    highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },
     errorElement: "span",
     errorClass: "help-block help-block-error",
     submitHandler: function(form) {
     		var jadwal = document.getElementById('tglok').value;
             tablejadwalok(jadwal);
        }
    });

    var v00 = $("#formsearchbed").validate({
      rules: {
        tglbed: {
          required: true
        }
      },
    highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },
     errorElement: "span",
     errorClass: "help-block help-block-error",
     submitHandler: function(form) {
     		var jadwal = document.getElementById('tglbed').value;
             tablejadwalinap(jadwal);
        }
    });
});

function tablejadwalok(tgl_jadwal){
	table = $('#operasi').DataTable({
		ajax: "<?php echo site_url();?>iri/ricreservasi/show_schedule/"+tgl_jadwal,
		columns: [
			{ data: "no_reservasi" },
			{ data: "no_reservasi" },
			{ data: "type_rawat" },
			{ data: "no_cm" },
			{ data: "nama" },
			{ data: "cara_bayar" },
			{ data: "prioritas" },
			{ data: "nm_dokter" },
			{ data: "ket" },
			{ data: "tgl_jadwal_ok" },
			{ data: "waktu_ok"}
		],
		columnDefs: [
			{ targets: [ 0 ], visible: false }
		],
		bFilter: true,
		bPaginate: true,
		destroy: true,
		order:  [[ 2, "asc" ],[ 1, "asc" ]]
	});
}
/*<th>No Reservasi</th>
									<th>No Reservasi</th>
									<th>Asal</th>
									<th>No MR</th>
									<th>Nama</th>								
									<th>Cara Bayar</th>
									<th>Ruang</th>
									<th>Kelas</th>
									<th>Bed</th>
									<th>Dokter yg Merujuk</th>
									<th>Ket</th>
									<th>Tgl Masuk</th>*/
var ajaxku;
function buatajax(){
    if (window.XMLHttpRequest){
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}

function stateChangedRoom(){
    var data;
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("ruang").innerHTML = data;
		}
    }
}

function stateChangedBed(){
    var data;
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("bed").innerHTML = data;
		}
    }
}

function getemptyroom(tgl){
	//alert(tgl);
		if(tgl!='' && tgl!=null){
			ajaxku = buatajax();
		    var url="<?php echo site_url('iri/ricreservasi/emptyroom_date'); ?>";
		    url=url+"/"+tgl;
		    url=url+"/"+Math.random();
		    ajaxku.onreadystatechange=stateChangedRoom;
		    ajaxku.open("GET",url,true);
		    ajaxku.send(null);
		}		
}

function getemptybed(room){
	if(room!='' && room!=null){
		var roomray = room.split("-");
		//alert(roomray[2]);
		var tglrsv = document.getElementById("calendar-tgl-rencana-masuk").value;
		ajaxku = buatajax();
		var url="<?php echo site_url('iri/ricreservasi/emptybed_date');?>"+'/'+roomray[0]+'/'+roomray[2];
		url=url+"/"+tglrsv;
		url=url+"/"+Math.random();
		ajaxku.onreadystatechange=stateChangedBed;
		ajaxku.open("GET",url,true);
		ajaxku.send(null);
	}
}

function tablejadwalinap(tgl_jadwal){
	table = $('#roombed').DataTable({
		ajax: "<?php echo site_url();?>iri/ricreservasi/show_reservation/"+tgl_jadwal,
		columns: [
			{ data: "no_reservasi" },
			{ data: "no_reservasi" },
			{ data: "asal" },
			{ data: "no_cm" },
			{ data: "nama" },
			{ data: "cara_bayar" },
			{ data: "nmruang" },
			{ data: "kelas" },
			{ data: "bed" },
			{ data: "nm_dokter" },
			{ data: "ket" },
			{ data: "tglrencanamasuk" }
		],
		columnDefs: [
			{ targets: [ 0 ], visible: false }
		],
		bFilter: true,
		bPaginate: true,
		destroy: true,
		order:  [[ 2, "asc" ],[ 1, "asc" ]]
	});
}

function iricase(caseiri){
	if(caseiri=='OPERASI'){
		$('#divok').show();
	}else{
		$('#divok').hide();
	}
}

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_diagnosa_pasien').autocomplete({
		serviceUrl: site+'iri/ricstatus/data_icd_1',
		onSelect: function (suggestion) {
			$('#diagnosa').val(suggestion.id_icd+' - '+suggestion.nm_diagnosa);
			$('#diagnosa_id').val(''+suggestion.id_icd);
			
		}
	});
});
</script>
<div class="row">			
	<div class="col-md-12">
		<?php echo $this->session->flashdata('pesan');
		if($pesan!=''){
			echo $pesan;
		} ?>
		<div class="card card-outline-info">
			<div class="card-header">
                <h5 class="m-b-0 text-white text-center">RESERVASI ANTRIAN PASIEN RAWAT INAP</h5>
            </div>
            <div class="card-block">
            	<br>
				<!-- Reservasi -->
				<form class="form-horizontal" action="<?php echo site_url('iri/ricreservasi/insert_reservasi'); ?>" method="POST" id="form_reservasi">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group row">
								<label for="tppri" class="col-md-3 col-form-label">Asal</label>
								<div class="col-md-7">
									<select class="form-control input-sm" id="tppri" name="tppri">
										<?php
										if(isset($data_pasien[0]['no_register'])){
											$kode = substr($data_pasien[0]['no_register'], 0,2);
											switch ($kode) {
												case 'RJ':
													echo '<option value="rawatjalan">Rawat Jalan</option>';
													break;
												case 'RD':
													echo '<option value="rawatdarurat">Rawat Darurat</option>';
													break;
												case 'RI':
													echo '<option value="ruangrawat">Ruang Rawat</option>';
													break;
												default:
												# code...
													break;
											}
										} else { ?>
											<option value="ruangrawat">Ruang Rawat</option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 col-form-label">Rujukan</label>
								<div class="col-md-7">
									<select class="form-control input-sm" name="rujukan">
										<option value="regional">Regional</option>
										<option value="nasional">Nasional</option>
										<option value="rslain">RS Lain</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 col-form-label">Reg. Asal *</label>
								<div class="col-sm-7">
									<?php
									if(isset($data_pasien[0]['no_register'])){
										$kode = substr($data_pasien[0]['no_register'], 0,2);
										switch ($kode) {
											case 'RJ':
												echo '<input type="text" class="form-control input-sm auto_no_register_rawatjalan" name="no_register_rawatjalan" id="no_register_rawatjalan" value="'.$data_pasien[0]['no_register'].'">';
												break;
											case 'RD':
												echo '<input type="text" class="form-control input-sm auto_no_register_rawatdarurat" name="no_register_rawatdarurat" id="no_register_rawatdarurat" value="'.$data_pasien[0]['no_register'].'" >';
												break;
											case 'RI':
												echo '<input type="text" class="form-control input-sm auto_no_register_ruangrawat" name="no_register_ruangrawat" id="no_register_ruangrawat" value="'.$data_pasien[0]['no_ipd'].'">';
												break;
											default:
												# code...
												break;
										}
									} else { ?>
										<input type="text" class="form-control input-sm auto_no_register_ruangrawat" name="no_register_ruangrawat" id="no_register_ruangrawat" value="<?php echo $data_pasien[0]['no_ipd'] ;?>">
									<?php } ?>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 col-form-label">Nama</label>
								<div class="col-sm-7">
									<?php
									if($data_pasien == ''){ ?>
										<input type="text" class="form-control input-sm" name="nama" id="nama" readonly>
									<?php } else { ?>
										<input type="text" class="form-control input-sm" name="nama" id="nama" readonly value="<?php echo $data_pasien[0]['nama'] ;?>">
									<?php } ?>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 col-form-label">No. Medrec</label>
								<div class="col-md-7">
									<span class="label-form-validation"></span>
									<?php
									if($data_pasien == ''){ ?>
										<input type="text" class="form-control input-sm" name="no_cm" id="no_cm" disabled="true">
										<input type="hidden" class="form-control input-sm" name="no_cm_h" id="no_cm_h">
										<input type="hidden" class="form-control input-sm" name="no_cm_real" id="no_cm_real" value="<?php echo $data_pasien[0]['no_cm'] ;?>">
									<?php } else { ?>
										<input type="text" class="form-control input-sm" name="no_cm" id="no_cm" disabled="true" value="<?php echo $data_pasien[0]['no_cm'] ;?>">
										<input type="hidden" class="form-control input-sm" name="no_cm_h" id="no_cm_h" value="<?php echo $data_pasien[0]['no_medrec'] ;?>">
										<input type="hidden" class="form-control input-sm" name="no_cm_real" id="no_cm_real" value="<?php echo $data_pasien[0]['no_cm'] ;?>">
									<?php } ?>	
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 col-form-label">Jenis Kelamin</label>
								<div class="col-md-7">
									<select class="form-control input-sm" name="sex" disabled="true">
										<?php if($data_pasien == '') { ?>
										<option id="laki-laki" value="L">Laki-Laki</option>
										<option id="perempuan" value="P">Perempuan</option>
										<?php } else { 
										if($data_pasien[0]['sex'] == 'P'){ ?>
										<option id="laki-laki" value="L">Laki-Laki</option>
										<option id="perempuan" value="P" selected="true">Perempuan</option>
										<?php } else { ?>
										<option id="laki-laki" value="L" selected="true">Laki-Laki</option>
										<option id="perempuan" value="P">Perempuan</option>
										<?php } 
											} ?>
															
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 col-form-label">Tanggal Lahir</label>
								<div class="col-md-7">
									<span class="label-form-validation"></span>
									<?php 
									if($data_pasien == '') { ?>
										<input type="text" class="form-control input-sm tanggal_lahir" id="calendar-tgl-lahir" name="tgllahir" disabled="true">
									<?php } else { ?>
										<input type="text" class="form-control input-sm tanggal_lahir" id="calendar-tgl-lahir" name="tgllahir" disabled="true" value="<?php echo date('d F Y',strtotime($data_pasien[0]['tgl_lahir'] ));?>">
									<?php } ?>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 col-form-label">Pekerjaan</label>
								<div class="col-md-7">
									<span class="label-form-validation"></span>
									<?php
									if($data_pasien == ''){ ?>
										<input type="text" class="form-control input-sm" name="pekerjaan" id="pekerjaan">
									<?php } else { ?>
										<input type="text" class="form-control input-sm" name="pekerjaan" id="pekerjaan" value="<?php echo $data_pasien[0]['pekerjaan'] ;?>">
									<?php } ?>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 col-form-label">Telp.</label>
								<div class="col-md-7">
									<span class="label-form-validation"></span>
									<?php
									if($data_pasien == ''){ ?>
										<input type="text" class="form-control input-sm" name="telp" id="telp">
									<?php } else { ?>
										<input type="text" class="form-control input-sm" name="telp" id="telp" value="<?php echo $data_pasien[0]['no_telp'] ;?>">
									<?php } ?>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 col-form-label">No. HP</label>
								<div class="col-md-7">
									<span class="label-form-validation"></span>
									<?php
									if($data_pasien == ''){ ?>
										<input type="text" class="form-control input-sm" name="hp" id="hp">
									<?php } else { ?>
										<input type="text" class="form-control input-sm" name="hp" id="hp" value="<?php echo $data_pasien[0]['no_hp'] ;?>">
									<?php } ?>
								</div>
							</div>
						</div>																
						<div class="col-sm-6">
							<h4 class="card-title">RENCANA MASUK</h4>
							<hr>
							<div class="form-group row">
								<label class="col-md-3 col-form-label">Rencana Masuk *</label>
								<div class="col-md-7">
									<span class="label-form-validation"></span>
									<input type="text" class="form-control input-sm" id="calendar-tgl-rencana-masuk" name="tglrencanamasuk" onchange="getemptyroom(this.value)" required>
								</div>
							</div>
							 <div class="form-group row">
								<label class="col-md-3 col-form-label">Cara Bayar *</label>
								<div class="col-md-7">
									<span class="label-form-validation"></span>
									<select class="form-control input-sm" id="carabayar" name="carabayar" required>
										<option value="">--Pilih Cara Bayar--</option>
										<option value="BPJS" >BPJS</option>
										<option value="UMUM" >UMUM</option>
										<option value="KERJASAMA">KERJASAMA</option>											
									</select>
									
								</div>
							</div> 
							
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Dikirim Oleh</label>
									<div class="col-sm-7">
										<select class="form-control input-sm" id="dikirim_oleh" name="dikirim_oleh" >
											<option value="dokter" >Dokter </option>
											<option value="bp_satkes" >BP/Satkes </option>
											<option value="puskesmas" >Puskesmas </option>
											<option value="rs_lainnya" >RS Lain </option>
											<option value="instansi_lainnya" >Instansi Lain </option>
											<option value="kasus" >Kasus Polisi </option>
											<option value="sendiri" >Datang Sendiri </option>
										</select>
									</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 col-form-label"></label>
								<div class="col-md-7">
									<span class="label-form-validation"></span>
									<input type="text" class="form-control input-sm" name="dikirim_oleh_text" id="dikirim_oleh_text" placeholder="nama pengirim">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 col-form-label">Pilih Ruangan *</label>
								<div class="col-md-7">
									<span class="label-form-validation"></span>
									<select class="form-control input-sm" id="ruang" name="ruang" onchange="getemptybed(this.value)" required>
										<option value="">-Pilih Ruangan-</option>
									</select>	
								</div>
							</div> 
								   
							
							<!-- <div class="form-group row">
								<label class="col-md-3 col-form-label">Pilih Bed *</label>
								<div class="col-md-7">
									<span class="label-form-validation"></span>						
									<select class="form-control input-sm" id="bed" name="bed"  required>
										<option value="">-Pilih Bed-</option>
									</select>	
								</div>
							</div> -->
							
							<div class="form-group row">
								<label class="col-md-3 col-form-label">Kasus</label>
								<div class="col-md-7">
									<select class="form-control input-sm" id="pilihan_prioritas" name="pilihan_prioritas" onchange="iricase(this.value)">
										<option value="-">-</option>
										<option value="IRD">Emergency</option>
										<option value="HBSAG">HBSAG+</option>
										<option value="KEMO">Kemoterapi</option>
										<option value="HEMO">Hemodialisa</option>
										<option value="OPERASI">Operasi Terjadwal</option>
										<option value="TALA">Talamesia</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 col-form-label">Prioritas</label>
								<div class="col-md-3">
									<select class="form-control input-sm" name="prioritas">
										<option id="normal" value="normal">Normal</option>
										<option id="high" value="high">High</option>
									</select>
								</div>
								<div class="col-md-6">
									<input type="checkbox" class="filled-in" value="Y" name="infeksi" id="check_infeksi"/>
                                    <label for="check_infeksi">Infeksi</label>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 col-form-label">Keterangan</label>
								<div class="col-md-7">
									<span class="label-form-validation"></span>
									<input type="text" class="form-control input-sm" name="keterangan" id="keterangan">
								</div>
							</div>

												<!-- <div class="form-group">
													<div class="col-sm-3 control-label">Ruang Pilih *</div>
													<div class="col-sm-9">
														<span class="label-form-validation"></span>
														<input type="text" class="form-control input-sm auto_ruang" id="ruang" name="ruang">
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label"></div>
													<div class="col-sm-9">
														<span class="label-form-validation"></span>
														<div class="col-sm-8 input-left"><input type="text" class="form-control input-sm" id="nm_ruang" name="nm_ruang" disabled="true"></div>
														<div class="col-sm-4 input-right">
															<select class="form-control input-sm" id="kelas" name="kelas">
																<?php
																//foreach ($kelas as $r) { ?>
																<option value="<?php //echo $r['kelas'] ;?>"><?php //echo $r['kelas'] ;?></option>
																<?php
																//}
																?>
															</select>
														</div>

													</div>
												</div> -->
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<h4 class="card-title">ASAL PASIEN</h4>
							<hr>
							<div class="form-group row">
								<label class="col-md-3 col-form-label">Poli/Ruang Asal</label>
									<span class="label-form-validation"></span>
									<?php
									if(isset($data_pasien[0]['no_register'])) {
										$kode = substr($data_pasien[0]['no_register'], 0,2);
										switch ($kode) {
											case 'RJ':
												echo '<div class="col-md-3 input-left">
														<input type="text" class="form-control input-sm" name="id_poli" id="id_poli" disabled="true" value="'.$data_pasien[0]['id_poli'].'" >
														</div>
														<div class="col-md-5 input-right"><input type="text" class="form-control input-sm" name="poliasal" id="poliasal" disabled="true" value="'.$data_pasien[0]['nm_poli'].'"  ></div>';
												break;
											case 'RD':
												echo '<div class="col-md-3 input-left"><input type="text" class="form-control input-sm" name="id_poli" id="id_poli" disabled="true" value="BB99" ></div>
														<div class="col-md-5 input-right"><input type="text" class="form-control input-sm" name="poliasal" id="poliasal" disabled="true" value="POLI UGD"  ></div>';
												break;
											case 'RI':
												echo '<div class="col-md-3 input-left"><input type="text" class="form-control input-sm" name="id_poli" id="id_poli" disabled="true" value="'.$data_pasien[0]['idrg'].'" ></div>
														<div class="col-md-5 input-right"><input type="text" class="form-control input-sm" name="poliasal" id="poliasal" disabled="true" value="'.$data_pasien[0]['nmruang'].'"  ></div>';
												break;
											default:
												# code...
												break;
										}
									} else { ?>
									<div class="col-md-3 input-left">
										<input type="text" class="form-control input-sm" name="id_poli" id="id_poli" disabled="true" value="<?php echo $data_pasien[0]['idrg']; ?>" >
									</div>
									<div class="col-md-5 input-right">
										<input type="text" class="form-control input-sm" name="poliasal" id="poliasal" disabled="true" value="<?php echo $data_pasien[0]['nmruang'];?>"  >
									</div>
									<?php } ?>
							</div>

							<div class="form-group row">
												<label class="col-sm-3 col-form-label">Dokter PJP</label>
												<div class="col-sm-9">
													<input type="hidden" class="form-control input-sm" name="id_dokter" id="id_dokter" value="<?php if(isset($data_pasien[0]['id_dokter'])){echo $data_pasien[0]['id_dokter'];}?>">
													<input type="text" class="form-control auto_no_register_dokter" name="nmdokter" value="<?php if(isset($data_pasien[0]['nm_dokter'])){echo $data_pasien[0]['nm_dokter'];}?>" required>
												</div>
											</div>
							<!-- <div class="form-group row">
								<label class="col-md-3 col-form-label">Dokter PJP</label>
								<div class="col-md-7">
									<span class="label-form-validation"></span>
									<?php
									//if(isset($data_pasien[0]['no_register'])){
										// $kode = substr($data_pasien[0]['no_register'], 0,2);
										// switch ($kode) {
										// 	case 'RJ':
										// 		echo '<input type="hidden" name="id_dokter" id="id_dokter">
										// 				<input type="text" class="form-control input-sm" name="dokter" id="dokter" value="'.$data_pasien[0]['nama_dokter'].'">';
										// 		break;
										// 	case 'RD':
										// 		echo '<input type="hidden" name="id_dokter" id="id_dokter">
										// 				<input type="text" class="form-control input-sm" name="dokter" id="dokter" value="'.$data_pasien[0]['nm_dokter'].'">';
										// 		break;
										// 	case 'RI':
										// 		echo '<input type="hidden" name="id_dokter" id="id_dokter">
										// 				<input type="text" class="form-control input-sm" name="dokter" id="dokter" value="'.$data_pasien[0]['dokter'].'">';
										// 		break;
										// 	default:
										// 		# code...
										// 		break;
									//	}
									//} else { ?>
										<input type="hidden" name="id_dokter" id="id_dokter">
										<input type="text" class="form-control auto_no_register_dokter" name="nmdokter" value="<?php //if(isset($data_pasien[0]['nm_dokter'])){//echo $data_pasien[0]['nm_dokter'];}?>" required>
									<?php //} ?>
								</div>
							</div> -->



							<div class="form-group row">
								<label class="col-md-3 col-form-label">Diagnosa</label>
								<div class="col-md-7">
									<span class="label-form-validation"></span>
									<?php
									if(isset($data_pasien[0]['no_register'])){
										$kode = substr($data_pasien[0]['no_register'], 0,2);
										switch ($kode) {
											case 'RJ':
												echo '<input type="text" class="form-control input-sm auto_diagnosa_pasien" name="diagnosa" id="diagnosa" value="'.$data_pasien[0]['diagnosa_utama'].'" ><div id="loading_diagnosa"></div>
																		<input type="hidden" name="diagnosa_id" id="diagnosa_id" value="'.$data_pasien[0]['id_diagnosa'].'" >';
												break;
											case 'RD':
												echo '<input type="text" class="form-control input-sm auto_diagnosa_pasien" name="diagnosa" id="diagnosa" value="'.$data_pasien[0]['diagnosa_utama'].'" ><div id="loading_diagnosa"></div>
																		<input type="hidden" name="diagnosa_id" id="diagnosa_id" value="'.$data_pasien[0]['id_diagnosa'].'" >';
												break;
											case 'RI':
												echo '<input type="text" class="form-control input-sm auto_diagnosa_pasien" name="diagnosa" id="diagnosa" value="'.$data_pasien[0]['nm_diagnosa'].'" ><div id="loading_diagnosa"></div>
																		<input type="hidden" name="diagnosa_id" id="diagnosa_id" value="'.$data_pasien[0]['diagmasuk'].'" >';
												break;
											default:
												# code...
												break;
										}
									} else { ?>
										<input type="text" class="form-control input-sm auto_diagnosa_pasien" name="diagnosa" id="diagnosa" value="<?php echo $data_pasien[0]['nm_diagnosa'];?>" ><div id="loading_diagnosa"></div>
										<input type="hidden" name="diagnosa_id" id="diagnosa_id" value="<?php echo $data_pasien[0]['diagmasuk'];?>" >
									<?php } ?>
								</div>
							</div>
						</div> <!-- col-md-12 -->
					</div> <!-- row -->
					<div class="form-actions">
                       	<div class="button-reservasi">
                       		<a class="btn btn-danger" href="<?php echo site_url('iri/ricreservasi'); ?>"><i class="fa fa-remove"></i> Batal</a>
							<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
						</div>	
                    </div>
								

								
									<!-- Modal -->
									<div class="modal fade bs-example-modal-sm" id="modal-reservasi" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													<h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
												</div>
												<div class="modal-body">
													Apakah kamu yakin dengan data tersebut?
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-remove"></i> Tidak</button>
													<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Ya</button>
												</div>
											</div>
										</div>
									</div>
									<!-- /Modal -->
									
				</form>
				<!-- /Reservasi -->
			</div>
			<!--- card-block -->
		</div>
		<!--- card -->
	</div>
</div><!--- row -->

		<div class="row">			
			<div class="col-md-12">				
				<div class="card card-outline-info">
					<div class="card-header" align="center" ><h4 class="text-white">Jadwal</h4></div>
					<div class="card-block">
						<form class="form-horizontal" method="POST" id="formsearchok">
							<div class="form-group row">
								<h4 class="col-md-3 col-form-label">Jadwal Operasi : </h4>
								<div class="col-md-4">
									<div class="input-group ">
									<input type="text" id="tglok" class="form-control tgl_jadwal_ok" placeholder="Tanggal Jadwal OK" name="tglok" required>
									<span class="input-group-btn">
										<button class="btn btn-primary" type="submit">Cari</button>
									</span>
								</div><!-- /input-group -->
								</div>
							</div>							
						</form>
						<br>
						<div class="table-responsive">
						<table class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%" id="operasi">
							<thead>
								<tr>
									<th>No Reservasi</th>
									<th>No Reg/No Reserv</th>
									<th>Asal</th>
									<th>No MR</th>
									<th>Nama</th>								
									<th>Cara Bayar</th>
									<th>Prioritas</th>
									<th>Dokter</th>
									<th>Ket</th>
									<th>Tanggal</th>
									<th>Waktu</th>
								</tr>
							</thead>							
						</table>
						</div>
						<br>
						<hr>
						<form class="form-horizontal" method="POST" id="formsearchbed">
							<div class="form-group row">
								<h4 class="col-md-4 col-form-label">Reservasi Kamar dan Bed : </h4>
								<div class="col-md-4">
									<div class="input-group ">
									<input type="text" id="tglbed" class="form-control tgl_jadwal_ok" placeholder="Tanggal Reservasi" name="tglbed" required>
									<span class="input-group-btn">
										<button class="btn btn-primary" type="submit">Cari</button>
									</span>
									</div><!-- /input-group -->
								</div>
							</div>								
						</form>
						<br>
						<div class="table-responsive">
						<table class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%" id="roombed">
							<thead>
								<tr>
									<th>No Reservasi</th>
									<th>No Reservasi</th>
									<th>Asal</th>
									<th>No MR</th>
									<th>Nama</th>								
									<th>Cara Bayar</th>
									<th>Ruang</th>
									<th>Kelas</th>
									<th>Bed</th>
									<th>Dokter yg Merujuk</th>
									<th>Ket</th>
									<th>Tgl Masuk</th>
								</tr>
							</thead>							
						</table>
						</div>
					</div>
				</div>
			</div>
		</div>

    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 

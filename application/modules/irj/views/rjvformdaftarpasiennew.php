<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        } ?>
	<script type='text/javascript'>

		function cekNoKartu(val){
			if (val == '') {
				swal("No. Kartu Kosong", "Harap masukan nomor kartu BPJS.", "warning");
				return;
			}
			$.ajax({
                url: "<?php echo site_url('bpjs/peserta/cari_peserta?pencarian=nokartu&nomor='); ?>" + val,
                dataType: "JSON",
                success: function(result) {
                    var idReplace;
                    if (result) {
                        if (result.metaData.code == '200') {
                            data = result.response.peserta;
                            if (data.jenisPeserta.kode === "22") {
                                idReplace = 3;
                            } else if (data.jenisPeserta.kode === '14') {
                                idReplace = 17;
                            } else {
                                idReplace = 60;
                            }
                            $('#id_kontraktor').val(idReplace).trigger('change');

                            $('.modal_nobpjs').modal('show');
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
                            $('#prb').val(data.informasi.prolanisPRB);
                        } else {
                            swal("Gagal Data Peserta.", result.metaData.message, "error");
                        }
                    } else {
                        button.html('Data Peserta');
                        swal("Error", "Gagal Data Peserta.", "error");
                    }
                },
                error: function(event, textStatus, errorThrown) {
                    button.html('Data Peserta');
                    swal("Error", formatErrorMessage(event, errorThrown), "error");
                    console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
                }
            });
		}

		function cekNik(val){
			if (val == '') {
				swal("No. NIK Kosong", "Harap masukan nomor NIK.", "warning");
				return;
			}
			$.ajax({
                url: "<?php echo site_url('bpjs/peserta/cari_peserta?pencarian=nik&nomor='); ?>" + val,
                dataType: "JSON",
                success: function(result) {
                    var idReplace;
                    if (result) {
                        if (result.metaData.code == '200') {
                            data = result.response.peserta;
                            if (data.jenisPeserta.kode === "22") {
                                idReplace = 3;
                            } else if (data.jenisPeserta.kode === '14') {
                                idReplace = 17;
                            } else {
                                idReplace = 60;
                            }
                            $('#id_kontraktor').val(idReplace).trigger('change');

                            $('.modal_nobpjs').modal('show');
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
                            $('#prb').val(data.informasi.prolanisPRB);
                        } else {
                            swal("Gagal Data Peserta.", result.metaData.message, "error");
                        }
                    } else {
                        button.html('Data Peserta');
                        swal("Error", "Gagal Data Peserta.", "error");
                    }
                },
                error: function(event, textStatus, errorThrown) {
                    button.html('Data Peserta');
                    swal("Error", formatErrorMessage(event, errorThrown), "error");
                    console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
                }
            });
		}


	$(document).on("click", "#btn-bpjs-daful", function() {
        var button = $(this);
        var no_bpjs = $("#no_bpjs").val();
        button.html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
        if (no_bpjs == '') {
            button.html('Cek No BPJS');
            swal("No. Kartu Kosong", "Harap masukan nomor kartu BPJS.", "warning");
        } else {
            $.ajax({
                url: "<?php echo site_url('bpjs/peserta/cari_peserta?pencarian=nokartu&nomor='); ?>" + no_bpjs,
                dataType: "JSON",
                success: function(result) {
                    var idReplace;

                    if (result) {
						alert(no_bpjs);
                        button.html('Cek No BPJS');
                        if (result.metaData.code == '200') {
                            data = result.response.peserta;
                            if (data.jenisPeserta.kode === "22") {
                                idReplace = 3;
                            } else if (data.jenisPeserta.kode === '14') {
                                idReplace = 17;
                            } else {
                                idReplace = 60;
                            }
                            $('#id_kontraktor').val(idReplace).trigger('change');

                            $('.modal_nobpjs').modal('show');
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
                            $('#prb').val(data.informasi.prolanisPRB);
                        } else {
                            swal("Gagal Data Peserta.", result.metaData.message, "error");
                        }
                    } else {
                        button.html('Data Peserta');
                        swal("Error", "Gagal Data Peserta.", "error");
                    }
                },
                error: function(event, textStatus, errorThrown) {
                    button.html('Data Peserta');
                    swal("Error", formatErrorMessage(event, errorThrown), "error");
                    console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
                }
            });
        }
    });






var site = "<?php echo site_url();?>";
$(function(){	
	$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({      	
      	radioClass: 'iradio_flat-green'
    	});

	$(".select2").select2();
	$("#btnBIo").click(function(){
		alert("hi");
		$("p").show();
	});
	$("#tableCari").dataTable({"iDisplayLength": 100});
	$("#duplikat_id").hide();
	$("#duplikat_kartu").hide();

	
	
	$('.auto_search_by_nocm').autocomplete({
		// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
		serviceUrl: site+'/ird/IrDRegistrasi/data_pasien',
		// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
		onSelect: function (suggestion) {
			$('#cari_no_medrec').val(''+suggestion.no_cm);
			$('#no_medrec_baru').val(''+suggestion.no_medrec);
		}
		
	});

	

	$('.auto_search_poli').autocomplete({
		// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
		serviceUrl: site+'/ird/IrDRegistrasi/data_poli',
		// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
		onSelect: function (suggestion) {
			$('#id_poli').val(''+suggestion.id_poli);
			$('#kd_ruang').val(''+suggestion.kd_ruang);
		}
	});
	$('.auto_search_by_nokartu').autocomplete({
		// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
		serviceUrl: site+'/ird/IrDRegistrasi/data_pasien_by_nokartu',
		// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
		onSelect: function (suggestion) {
			$('#cari_no_kartu').val(''+suggestion.no_kartu);
			$('#no_cmkartu').val(''+suggestion.no_medrec);
		}
	});
	$('.auto_search_by_noidentitas').autocomplete({
		// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
		serviceUrl: site+'/ird/IrDRegistrasi/data_pasien_by_noidentitas',
		// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
		onSelect: function (suggestion) {
			$('#cari_no_identitas').val(''+suggestion.no_identitas);
			$('#no_cmident').val(''+suggestion.no_medrec);
		}
	});

	$('#date_picker').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});  

	$('#tgl_daftar').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});  
});


</script>
<?php echo $this->session->flashdata('message'); ?>		

	<section class="content">
		<div class="row">			
			
			<div class="card card-outline-info">
					<div class="card-header">
						<center><h4 class="text-white"> Daftar Pasien</h4></div>
					<div class="card-block">
						
						<table id="tableCari"  class="display table table-hover table-bordered table-striped" cellspacing="0" width="100%">
							<thead>
								<tr>
								 
								  <th>No</th>
								  <th>No Medrec</th>
								  <th>Nama</th>
								  <th>No Identitas</th>
								  <th>No BPJS</th>
								  <!-- <th>Aksi</th> -->
								  
								</tr>
							  </thead>
							  <tbody><?php //if($search_per=='nama' || $search_per=='alamat') { ?>
								<?php if ($daftar_pasien!=''){
								// print_r($pasien_daftar);
								$i=1;
									foreach($daftar_pasien as $row){
										// var_dump($row->no_kartu);die();
									
								?>
									<tr>
										
										<td><?php echo $i++ ; ?></td>
										<td><?php echo $row->no_cm; ?></td>										
										<td><?php echo $row->nama; ?></td>
										<td><?php echo $row->no_identitas; ?></td>										
										<td> <?php // echo $row->no_kartu ?>
											<div class="col-sm-10">
													<div class="input-group col-sm-8">
														<input type="text" class="form-control" name="no_bpjs" id="no_bpjs" value="<?= $row->no_kartu ?>">
														<span class="input-group-btn">
															<button class="btn btn-info" type="button" onclick="cekNoKartu('<?= $row->no_kartu ?>')"><i class="fa fa-eye"></i>Cek No Kartu</button>
															<button class="btn btn-primary" type="button" onclick="cekNik('<?= $row->no_identitas ?>')"><i class="fa fa-eye"></i>Cek NIK</button>
														</span>
													</div>
												</div>
										</td>
																													
										
									</tr>
								<?php
									}}
								?><?php
		//}
	?>
							  </tbody>
						</table>
									
				</div>	
	</div>
		
	</div><!--- end row -->
</section>


<div class="modal fade modal_nobpjs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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


<div class="modal fade modal_suratkontrol" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<img class="pull-left" src="<?php echo site_url('assets/images/logos/logo_bpjs.png'); ?>" width="120"></img>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<h4 class="text-center text-bold">PEMBUATAN SURAT KONTROL</h4>
				<table class="table-xs table-hover" width="100%" border="1" id="listsep">
					<tr>
						<td>No.</td>
						<td>No SEP</td>
						<td>Tgl Kunjungan</td>
						<td>Tujuan Poli</td>
						<td>Aksi</td>
					</tr>
					<!-- <tr>
						<td>1.</td>
						<td>03.4123123123</td>
						<td>SAR</td>
						<td>
							<button class="btn btn-primary">Pilih SEP</button>
						</td>
					</tr> -->
				</table>
				<br>

				<div class="formbuatsurkon">
					<div class="form-group row">
						<label class="col-sm-3 control-label col-form-label">No.SEP</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="no_sep_surat_bikin">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-3 control-label col-form-label">Tgl Rencana Kontrol</label>
						<div class="col-sm-8">
							<input type="date" class="form-control" id="tgl_surat_bikin" onchange="ambilpolikontrol(this.value)">

						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-3 control-label col-form-label">Poli Kontrol</label>
						<div class="col-sm-8">
							<div class="form-inline" style="width:100%;">
								<select id="poli_suratkontrol_bikin" class="form-control select2" style="width: 100%"  onchange="ambildoktersuratkontrol(this.value)">
									<option value="">-- Pilih Poliklinik --</option>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-3 control-label col-form-label">Dokter Surat Kontrol</label>
						<div class="col-sm-8">
							<div class="form-inline" style="width:100%;">
								<select id="dpjp_suratkontrol_bikin" class="form-control select2" style="width: 100%" name="dpjp_suratkontrol_bikin" >
									<option value="">-- Pilih Dokter --</option>
								</select>
							</div>
						</div>
					</div>


				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary waves-effect text-left" onclick="buatsuratkontrol()" >Buat Surat Kontrol</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
</div>


<div class="modal fade modal_list_rujukan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<img class="pull-left" src="<?php echo site_url('assets/images/logos/logo_bpjs.png'); ?>" width="120"></img>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<h4 class="text-center text-bold">Daftar Rujukan</h4>
				<ul class="nav nav-tabs customtab" role="tablist">
					<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#fk1" role="tab" onclick="lihatlistrujukan($('#no_bpjs').val(),1,'fk1')"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Rujukan Faskes 1</span></a> </li>
					<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#fk2" role="tab" onclick="lihatlistrujukan($('#no_bpjs').val(),2,'fk2')"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Rujukan Faskes 2</span></a> </li>
					<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#fk3" role="tab" onclick="lihatlistrujukan($('#no_bpjs').val(),3,'fk3')"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Rujukan Pasca Ranap</span></a> </li>
				</ul>
				<div class="tab-content">
					<div id="fk1" class="tab-pane active" role="tabpanel"></div>
					<div id="fk2" class="tab-pane" role="tabpanel"></div>
					<div id="fk3" class="tab-pane" role="tabpanel"></div>
				</div>

			</div>

		</div>
		<!-- /.modal-content -->
	</div>
</div>

<div class="modal fade modal_norujukan" tabindex="-1" role="dialog" aria-hidden="true">
	  	<div class="modal-dialog modal-lg">
	      	<div class="modal-content">
	          	<div class="modal-header text-center">
	              	<img class="pull-left" src="<?php echo site_url('assets/images/logos/logo_bpjs.png'); ?>" width="120"></img>
	              	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	          	</div>
	          	<div class="modal-body">
		  			<h4 class="text-center" style="font-weight: 600;">DATA RUJUKAN</h4>
		            <div class="table-responsive" style="clear: both;margin-top: 25px;">
						<table class="table-xs table-hover" width="100%">
						  <tbody>
						  	<tr>
								<td style="width: 25%;">No. Rujukan</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_nomor"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Tanggal Rujukan</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_tgl"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Faskes Perujuk</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_faskes"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Poli</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_poli"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Nama</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_nama"></td>
							</tr>
							<tr>
								<td style="width: 25%;">No. Kartu BPJS</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_noka"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Diagnosa</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_diagnosa"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Jenis Kelamin</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_gender"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Jenis Rawat</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_jenis_rawat"></td>
							</tr>
						  </tbody>
						</table>
					</div>
		        </div>
		      	<div class="modal-footer">
		      		<button type="button" class="btn btn-primary waves-effect text-left" data-dismiss="modal" onclick="terapkan_data_rujukan()"><i class="fa fa-check"></i> Gunakan Rujukan</button>
		          	<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
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

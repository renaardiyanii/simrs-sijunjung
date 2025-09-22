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


<!-- feat : added modal untuk pilih surat kontrol -->

<div class="modal fade modal_pilihsuratkontrol" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<img class="pull-left" src="<?php echo site_url('assets/images/logos/logo_bpjs.png'); ?>" width="120"></img>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<h4 class="text-center text-bold">PILIH SURAT KONTROL</h4>
				<table class="table-xs table-hover" width="100%" border="1">
					<tr>
						<td>No. Surat</td>
						<td>Tgl. Kontrol</td>
						<td>No. Sep Asal</td>
						<td>Nama Dokter</td>
						<td>Status</td>
						<td>Aksi</td>
					</tr>
					<tbody  id="listsuratkontrol"></tbody>
				</table>
				<br>

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
<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?> 
<script type="text/javascript" charset="utf-8">
$(function() {
	$('#table_diagnosa').dataTable({});
});
</script>
 <section class="content">
		<div class="row">
			<div class="col-md-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h5 class="m-b-0 text-white text-center">Data Pasien</h5></div>
                    <div class="card-block">
					
						<div class="row">
						
						<div class="col-sm-12 text-center"><img height="90px" class="img-rounded" src="<?php 
							if($pasien_umc->foto==''){
								echo site_url("upload/photo/unknown.png");
							}else{
								echo site_url("upload/photo/".$pasien_umc->foto);
							}
							?>"></div>
							<div class="table-responsive m-t-10" style="clear: both;">
						<table class="table-xs table-striped" width="100%">
						  <tbody>
							<tr>
								<td style="width: 38%;">No. MR</td>
								<td style="width: 5%;">:</td>
								<td><?php echo $pasien_umc->no_cm;?></td>
							</tr>
							<tr>
								<td style="width: 38%;">Nama</td>
								<td style="width: 5%;">:</td>
								<td><?php echo strtoupper($pasien_umc->nama).' '.$pasien_umc->sex;?></td>
							</tr>
							<tr>
								<td style="width: 38%;">Tgl. lahir</td>
								<td style="width: 5%;">:</td>
								<td><?php echo date('d-m-Y',strtotime($pasien_umc->tgl_lahir));?></td>
							</tr>
							<tr>
								<td style="width: 38%;">Umur</td>
								<td style="width: 5%;">:</td>
								<td><?php $interval = date_diff(date_create(), date_create($pasien_umc->tgl_lahir));
                                    echo $interval->format("%Y Tahun, %M Bulan, %d Hari");?></td>
							</tr>
							<tr>
								<td style="width: 38%;">Gol Darah</td>
								<td style="width: 5%;">:</td>
								<td><?php echo $pasien_umc->goldarah;?></td>
							</tr>																							
							<?php if($pasien_umc->no_nrp!=''){?>
							<tr>
								<td style="width: 38%;">NRP</td>
								<td style="width: 5%;">:</td>
								<td><u><?php echo $pasien_umc->no_nrp;?></u></td>
							</tr>
							<?php } ?>	
						  </tbody>
						</table>
						</div>
											<br/>
					<!-- <span class="input-group-btn"> -->
						<a class="btn btn-primary pull-right" href="<?php echo site_url('medrec/el_record/pasien/'.$pasien_umc->no_medrec); ?>" target="_blank"><i class="fa fa-binoculars">&nbsp; Rekam Medik</i> </a>
					<!-- </span> -->
			</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- form -->
   <div class="card card-outline-info">
      <div class="card-header">
           <h5 class="m-b-0 text-white text-center">Form Input Uang Muka/Cicilan/Deposito</h5></div>
            <div class="card-block">
			<form class="form" id="form_add_umc">
			<div class="form-group row">
                <label for="no_reg_umc" class="col-3 col-form-label">No Register</label>
                <div class="col-9">
                    <input type="text" class="form-control" value="<?php echo $last_daful->no_register;?>" name="no_reg_umc" id="no_reg_umc" >
                </div>
            </div>
            <div class="form-group row">
                <label for="nom_kredit" class="col-3 col-form-label">Nominal Total Kredit</label>
                <div class="input-group col-9">
						<span class="input-group-addon">Rp</span>
						<input type="text" class="form-control" name="nom_kredit" id="nom_kredit" placeholder="Nominal Total Kredit" >
					</div>
            </div>
            <div class="form-group row">
                <label for="jenis_bayar" class="col-3 col-form-label">Jenis Pembayaran</label>
                <div class="col-9">
                    	<select id="jenis_bayar" class="form-control" name="jenis_bayar" required>
									<option value="">-Pilih Jenis Pembayaran-</option>
									<option value="0" >Tunai</option>';
									<option value="1">Kredit</option>';
								</select>	
                </div>
            </div>

            <div class="form-group row">
                <label for="nom_kredit" class="col-3 col-form-label">Nominal Input</label>
                <div class="input-group col-9">
						<span class="input-group-addon">Rp</span>
						<input type="text" class="form-control" name="nom_kredit" id="nom_kredit" placeholder="Nominal Yang Disetor" >
					</div>
            </div>	
            <div class="form-group row">
                <label for="nom_kredit" class="col-3 col-form-label">Nominal Sisa</label>
                <div class="input-group col-9">
						<span class="input-group-addon">Rp</span>
						<input type="text" class="form-control" name="nom_kredit" id="nom_kredit" placeholder="Nominal Sisa" >
					</div>
            </div>
            <div class="form-group row">
                <label for="nom_diskon" class="col-3 col-form-label">Nominal Diskon</label>
                <div class="input-group col-9">
						<span class="input-group-addon">Rp</span>
						<input type="text" class="form-control" name="nom_diskon" id="nom_diskon" placeholder="Nominal Diskon" >
					</div>
            </div>		
			<div class="form-group row">
                <label for="note_umc" class="col-3 col-form-label">Catatan</label>
                <div class="col-9">
                    	<textarea class="form-control" name="note_umc" id="note_umc" cols="30" rows="5" style="resize:vertical"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="prop" class="col-3 col-form-label">Cicilan Ke</label>
                <div class="col-9">
                    	<select id="prop" class="form-control" name="klasifikasi_diagnosa" required>
									<option value="<?php echo $detail_cicilan;?>"><?php echo $detail_cicilan;?></option>';
								</select>	
                </div>
            </div>
            <div class="form-group row">
                <label for="penyetor_umc" class="col-3 col-form-label">Sudah Terima Dari</label>
                <div class="col-9">
                    	<input type="text" class="form-control"  name="penyetor_umc" id="penyetor_umc" >
                </div>
            </div>
			<div class="form-group row">
				<div class="offset-sm-3 col-sm-9">									
							<input type="hidden" class="form-control" value="<?php echo $pasien_umc->no_medrec;?>" name="no_medrec" id="no_medrec">
								<button type="reset" class="btn btn-danger"><i class="fa fa-eraser"></i> Reset</button>
								<button type="submit" class="btn btn-primary" id="btn-diagnosa"><i class="fa fa-floppy-o"></i> Simpan</button>
				</div>
			</div>										
			</form>
								
		<!-- table -->
		<br>
		<div class="table-responsive">
			<table id="table_umc" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>No</th>
						<th>No Register</th>
						<th>No Kwitansi</th>
						<th colspan="2">Nominal</th>
						<th >Penyetor</th>
						<th >Penerima</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
			
				</tbody>
			</table>
		</div> <!-- table-responsive -->
	</div>
</div>
<?php 
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?> 

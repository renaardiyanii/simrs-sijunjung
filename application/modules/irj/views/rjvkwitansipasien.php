<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
    ?> 

<script type='text/javascript'>
	$(function() {
		$('#date_picker').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		});  
	});
</script>

	<div class="container-fluid">
		<section class="content-header">
		</section>
		<section class="content">
			<div class="row">
			
			<?php echo validation_errors(); ?>

				<div class="card card-outline-info">
					<div class="card-header text-white" align="center">Rekap Biaya</div>
					<div class="card-block">
						<br/>
						<div style="display:block;overflow:auto;">
							<table class="table">
							  <tbody>
								<tr>
									<th>No CM</th>
									<td>:</td>
									<td><?php echo $data_pasien->no_cm;?></td>
									<th>Tanggal Kunjungan</th>
									<td>:</td>
									<td><?php echo date("d-m-Y | H:i", strtotime($data_pasien->tgl_kunjungan)); ?></td>
								</tr>
								<tr>
									<th>No. Register</th>
									<td>:</td>
									<td><?php echo $data_pasien->no_register;?></td>
									<th>Kelas Pasien</th>
									<td>:</td>
									<td><?php echo $data_pasien->kelas_pasien;?></td>
								</tr>
								<tr>
									<th>Nama Pasien</th>
									<td>:</td>
									<td><?php echo strtoupper($data_pasien->nama);?></td>
									<th>Poli</th>
									<td>:</td>
									<td><?php echo $data_pasien->nm_poli.' ('.$data_pasien->id_poli.')';?></td>
								</tr>

								

					
			</tr>
			<tr id="penghambat">
				<th><p style="padding-top:3px;">Pilih Metode Pembayaran</p></th>
					<td><p style="padding-top:3px;">:</p></td>
					<td><select class="form-control" name="jenis_bayar" id="jenis_bayar" style="border: 2px solid  #7DBE64;" onchange="jenis_bayar(this.value)" required>
							<option value="">-Pilih Pembayaran-</option>
							<option value="1">TUNAI </option>
							<option value="0">KREDIT</option>
						</select></td>
				<?php if($data_pasien->cara_bayar=='KERJASAMA' || $data_pasien->cara_bayar=='BPJS'){?>
					<th>Dijamin Oleh</th>
					<td>:</td>
					<td><?php if($kontraktor!=''){echo $kontraktor->nmkontraktor;}?></td>
				<?php }?>
				
			</tr>
			<tr>
				<th><p style="padding-top:3px;">Pilih Jenis Pembayaran</p></th>
					<td><p style="padding-top:3px;">:</p></td>
					<td><select class="form-control" name="pembayaran" id="pembayaran" style="border: 2px solid  #7DBE64;" onchange="bayar(this.value)" required>
							<option value="">-Pilih Pembayaran-</option>
							<option value="TUNAI">TUNAI </option>
							<option value="BANK">BANK</option>
							<option value="VA">Virtual Account</option>
							<!-- <option value="split">Split Payment</option>
                            <option value="PIUTANG/IKS">Piutang/Cicilan</option> -->
						</select></td>
				
				
			</tr>
			<?php if($data_pasien->catatan_plg!=''){?>
			<tr>
					
					<th>Cara Bayar</th>
					<td>:</td>
					<td><?php echo $data_pasien->cara_bayar;$cara_bayar=$data_pasien->cara_bayar;?></td>
					<tr>
									<th style="color:green !important">Catatan</th>
									<td>:</td>
									<td style="color:green !important" colspan="2"><u><?php echo strtoupper($data_pasien->catatan_plg);?></u></td>									
								</tr>
			<?php }?>
							  </tbody>
							</table>
							<hr>
							<table class="table table-hover table-striped table-bordered">
							  <thead>
								<tr>
								  <th>No</th>
								  <th>Pemeriksaan</th>
								  <td>Diskon</td>
								  <th>Biaya</th>
								</tr>
							  </thead>
							  <tbody>
								
								<?php
								$jumlah_vtot=0;								
								?>
									<?php if($data_tindakan!=''){ 
									$vtotind=0;
									foreach($data_tindakan as $row){
										$vtotind=$vtotind+$row->vtot; ?>
									<tr>
									  <td></td>
									  <td>- <?php echo $row->nmtindakan; //if($row->bpjs!='1'){ echo ' | * NON-COVER';}?></td>
									  <td>
										<!-- <form id="diskon_form" method="POST"> -->
											<div class="form-inline">
												<!-- <input type="hidden" id="id_tindakan" name="id_tindakan" value="<?php //echo $row->idtindakan;?>"> -->
												<!-- <input type="hidden" class="form-control" name="noreg" id="noreg" value="<?php //echo $no_register ?>"> -->
												<input type="text" class="form form-control" name="diskon_item" id="diskon-<?= $row->idtindakan ?>" onchange="diskontindakan('<?= $row->idtindakan ?>',this.value)" style="margin-right: 5px;">
												<button  id="btn-diskon-<?= $row->idtindakan ?>" class="btn btn-primary" onclick="simpanDiskon('<?= $row->idtindakan ?>','diskon-<?= $row->idtindakan ?>')">Input</button>
											</div>
										<!-- </form> -->
									  </td>
									  <td>Rp <div class="pull-right" id="biaya-<?= $row->idtindakan ?>"><?php echo number_format( $row->vtot );?></div></td>
									  <td></td>
									</tr>
									<?php
									 }
								    } 
								 ?>

									
									
										<?php if($data_pasien->cara_bayar!='UMUM' || $data_pasien->cara_bayar!='BPJS' || $data_pasien->cara_bayar!='KERJASAMA'){
											//$jumlah_vtot=$vtotind+$vtot->vtot_lab+$vtot->vtot_rad+$vtot->vtot_obat+$vtot->vtot_ok;
											$jumlah_vtot=$vtotind;
										} else{
											//$jumlah_vtot=$vtotind+$vtot->vtot_ok;
											$jumlah_vtot=$vtotind;
											//$jumlah_vtot=$vtotind+$vtot->vtot_lab+$vtot->vtot_rad+$vtot->vtot_ok;
											}?>
								
									<tr>
									  <th colspan="3" >Total</th>
									  <th>Rp <div class="pull-right" id="totalVtot"><?php echo number_format( $jumlah_vtot);?></div></th>
									</tr>
								</tbody>
							</table>
						<!-- </div>style overflow -->
						
						<?php
						//echo $this->session->flashdata('message_no_tindakan'); 
						
						if($this->session->flashdata('message_no_tindakan')=='tindakan_kosong' and $jumlah_vtot==0){
						?>
							<div class="form-inline" align="right">
								<div class="form-group">
							
									<a href="<?php echo site_url('irj/rjckwitansi/st_selesai_kwitansi_kt/'.$no_register);?>"><input type="button" class="btn btn-primary btn-sm" id="btn_selesai" value="Selesai"></a>
								</div>
							</div>
						<?php
							
						}else{?>
						<!--<p>*) Input biaya TUNAI pasien BPJS untuk tindakan yang <b>tidak dicover/Non-cover oleh BPJS</b></p>-->
						<table class="table table-responsive" >		  
		<tbody>
			<!--<tr id="uangmuka0" name="uangmuka0">
				<th style="width:20%;">Uang Muka Pasien</th>
				<td>:</td>
				<td style="width:40%;">
					<div class="input-group" >
						<span class="input-group-addon" ><b>Rp</b></span>
						<input type="text" class="form-control" name="uangMuka" id="uangMuka" placeholder="0" disabled value="<?php //echo $row->uang_muka;?>" style="border: 2px solid  #7DBE64;">
						<span class="input-group-btn">
							<button type="btn" class="btn btn-primary" onclick="selisihUangMuka()" >Input</button>
						</span>
					</div>
				</td>
				<td style="width:40%;">
				<div class="input-group" >
						<span class="input-group-addon" ><b>Rp</b></span>
						<input type="text" class="form-control" name="selisih" id="selisih" placeholder="Sisa"   style="border: 2px solid  #7DBE64;">
						
					</div>
				</td>
			</tr>-->
			<tr>
				<th style="width:20%;">Total</th>
				<td>:</td>
				<td style="width:40%;">
					<div class="input-group">
						<span class="input-group-addon">Rp</span>
						<input type="text" class="form-control" name="biaya_t" id="biaya_t" placeholder="Nominal Tunai" required>
					</div>
				</td>
				<td style="width:40%;"></td>
			</tr>
			<!-- <tr>
				<th>Dibayar Kartu Kredit/Debit</th>
				<td>:</td>
				<td><input type="text" class="form-control" name="no_kartuk" id="no_kartuk" placeholder="Nomor Kartu"></td>
				<td><div class="input-group">
						<span class="input-group-addon">Rp</span>
						<input type="text" class="form-control" name="biaya_k" id="biaya_k" placeholder="Nominal KK/Debit"></td>
				   </div>		
			</tr>
			<tr>
				<th>Charge *)</th>
				<td>:</td>
				
				<td><div class="input-group"><span class="input-group-addon">%</span>								
				<input type="number" class="form-control" step="0.01" name="cashRate" id="cashRate" min=0>	
				<input type="hidden" class="form-control" name="cashFee" id="cashFee">

				<span class="input-group-btn">
					<button type="btn" class="btn btn-primary" onclick="setCash()" >Input</button>
				</span>
				</div></td>
				<td><div class="input-group">
						<span class="input-group-addon">Rp</span>
							<input type="text" class="form-control" name="kartuk" id="kartuk" placeholder="Nominal Akhir KK/Debit" disabled>
				   </div>
				</td>
			</tr>
			<tr id="kredit0" name="kredit0">
				<th>Pengurangan/Diskon</th>
				<td>:</td>
				<td><div class="input-group"><span class="input-group-addon">Rp</span>						
					<input type="text" class="form-control" name="diskon" id="diskon" placeholder="Nominal Pengurangan" >				
					</div>	
				</td>
				<td>
					
				</td>
			</tr> -->
			<!-- <tr>
				<th style="width:20%;">Catatan Pengurangan/Diskon</th>
				<td>:</td>
				<td colspan="2">
					<input type="text" class="form-control" name="note_diskon" id="note_diskon" placeholder="Catatan Diskon/Pengurangan" required>
					
				</td>
				
			</tr> -->
			<!-- <tr>
				<th>Total Akhir</th>
				<td>:</td>
				<td><div class="input-group">
						<span class="input-group-addon">Rp</span>
							<input type="text" class="form-control" placeholder="0" name="totfinal" id="totfinal" disabled>							 -->
						<!-- <span class="input-group-btn">
						<button type="btn" class="btn btn-primary" onclick="setTotal()">Hitung</button>
					</span> -->
					<!-- </div>
				</td>
			</tr> -->
			<!--<tr>
				<th>Total Akhir</th>
				<td>:</td>
				<td><div class="input-group">
						<span class="input-group-addon">Rp</span>
							<input type="text" class="form-control" placeholder="0" name="kembalian" id="kembalian" disabled>							
						<span class="input-group-btn">
						<button type="btn" class="btn btn-primary" onclick="setTotal()">Hitung</button>
					</span>
					</div>
				</td>
			</tr>-->
		</tbody>
	</table>
	<!--<p style=" margin-left:10px; padding-top:3px;">*) Sesuai dengan kebijakan kartu kredit</p>-->
	<table class="table table-responsive" id="splitPayment">
		<tbody>
		<tr>
				<th style="width:20%;">Tunai</th>
				<td>:</td>
				<td style="width:40%;">
					<div class="input-group">
						<span class="input-group-addon">Rp</span>
						<input type="text" class="form-control" name="biaya_tunai" id="biaya_tunai" placeholder="Nominal Tunai" required onchange="biaya_tunaiDetail(this.value)">
					</div>
				</td>
				<td style="width:40%;"></td>
			</tr>

			<tr>
				<th style="width:20%;">Non-tunai</th>
				<td>:</td>
				<td style="width:40%;">
					<div class="input-group">
						<span class="input-group-addon">Rp</span>
						<input type="text" class="form-control" name="biaya_non_tunai" id="biaya_non_tunai" placeholder="Nominal Non-Tunai" required onchange="biaya_NontunaiDetail(this.value)">
					</div>
				</td>
				<td style="width:40%;"></td>
			</tr>		
			
		</tbody>
	</table>
	<hr>
	<table style="margin-left:10px;">
		<tbody>
			<tr>
				<th style="width:40%;"><p >Sudah Terima Dari</p></th>
				<td style="width:10%;"><p>:</p></td>
				<td style="width:40%;">
					<input type="text" class="form-control" name="penyetor" id="penyetor" onchange="penyetorDetail(this.value)" >
				</td>
			</tr>			
			
		</tbody>
	</table>
	<p style=" margin-left:10px; padding-top:3px;">*) Klik cetak apabila pasien sudah benar-benar membayar tindakan</p>
	<br>
		<div class="form-inline row" align="left" style="margin-left:10px;">
			<div class="input-group">				
			<?php //echo form_open('irj/rjckwitansi/st_cetak_kwitansi_kt',array('target'=>'_blank'));?>
			<form id="cetakKwitansi">
					<input type="hidden" class="form-control" name="penyetor_hide" id="penyetor_hide">
					<input type="hidden" class="form-control" name="notedisc_hide" id="notedisc_hide">
					<input type="hidden" class="form-control" name="pilih" value="0" >
					<input type="hidden" class="form-control" name="no_register" id="no_register" value="<?php echo $no_register ?>">
					<input type="hidden" class="form-control" name="penyetor" id="penyetor_hide_1">
					<input type="hidden" class="form-control" name="jenis_bayar_hide" id="jenis_bayar_hide_1">
					<input type="hidden" class="form-control" name="bayar" id="bayar">
					<input type="hidden" class="form-control" name="diskon_hide" id="diskon_hide_1">
					<input type="hidden" class="form-control" name="totakhir_hide" id="totakhir_hide" >
					<input type="hidden" class="form-control" name="charge_rate" id="charge_rate_1" >
					<input type="hidden" class="form-control" name="totakhir_hide" id="totakhir_hide" >
					<input type="hidden" class="form-control" name="charge_fee" id="charge_fee_1" >
					<input type="hidden" class="form-control" name="no_kk" id="no_kk_hide" >
					<input type="hidden" class="form-control" name="nilai_kk" id="nilai_kk_1" >
					<input type="hidden" class="form-control" name="nilai_tunai" id="nilai_tunai_1" >
					<input type="hidden" class="form-control" name="totfinal_hide" id="totfinal_hide_1">
					<input type="hidden" id="pembayaran_hide" name="pembayaran_hide">
					<input type="hidden" class="form-control" name="biaya_tunai_hide" id="biaya_tunai_hide">
					<input type="hidden" class="form-control" name="biaya_non_tunai_hide" id="biaya_non_tunai_hide">
					<input type="hidden" id="id_poli" name="id_poli" value="<?php echo $data_pasien->id_poli ?>">
					<span>
						<button type="button" id="btn-cetak" class="btn btn-primary" onclick="submitPembayaran()">Cetak</button>
					</span>									
			<?php //echo form_close();?>
			</form>
			</div>
			<!--<div class="input-group">			
			<?php //echo form_open('irj/rjckwitansi/st_cetak_kwitansi_kt');?>
					
					<input type="hidden" class="form-control" name="pilih" value="detail" >
					<input type="hidden" class="form-control" name="penyetor_hide" id="penyetor_hide">
					<input type="hidden" class="form-control" name="jenis_bayar_hide" id="jenis_bayar_hide_2">
					<input type="hidden" class="form-control" name="no_register" value="<?php echo $no_register ?>">
					<input type="hidden" class="form-control" name="diskon_hide" id="diskon_hide_2">
					<input type="hidden" class="form-control" name="totakhir_hide" id="totakhir_hide" >
					<input type="hidden" class="form-control" name="totakhir_hide" id="totakhir_hide" >
					<input type="hidden" class="form-control" name="charge_rate" id="charge_rate_2" >
					<input type="hidden" class="form-control" name="charge_fee" id="charge_fee_2" >
					<input type="hidden" class="form-control" name="nilai_kk" id="nilai_kk_2" >
					<input type="hidden" class="form-control" name="nilai_tunai" id="nilai_tunai_2" >
					<input type="hidden" class="form-control" name="totfinal_hide" id="totfinal_hide_2">
					<span>
						<button type="submit" id="btn-cetak-detail" class="btn btn-primary" value="" >Cetak Detail</button>
					</span>
			<?php //echo form_close();?>
				</div>-->
			<?php }?>
		</div><!-- end panel body-->
		</div><!--- end panel -->
			</div><!--- end panel -->
		</section>
	</div><!--- end container -->

<script type='text/javascript'>

function submitPembayaran()
{
	
	if($('#pembayaran').val()==''){
		alert('anda harus pilih pembayaran');
		return;
	}
	let data = $("#cetakKwitansi").serialize();
	$.ajax({  
		url:"<?= base_url() ?>/irj/rjckwitansi/st_cetak_kwitansi_kt",                         
		method:"POST",  
		data:data,   
		success: function(data)  
		{ 
			swal({
				title: "Selesai",
				text: "Data berhasil disimpan",
				type: "success",
				showCancelButton: false,
				closeOnConfirm: true,
				showLoaderOnConfirm: true
			},
			function () {
				
				window.open('<?php echo base_url() ?>'+'irj/rjckwitansi/cetak_faktur_kt/'+'<?= $no_register ?>','_blank');
				// window.location.href = '<?php echo base_url() ?>'+"irj/rjckwitansi/kwitansi";
				window.location.href = '<?php echo base_url() ?>'+"irj/rjckwitansi/kwitansi";
			}); 
		},
		error:function(event, textStatus, errorThrown) {
			//$('#ulangModal').modal('hide');
			swal("Error","Data gagal diperbaharui.", "error"); 
			console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		}  
	}); 
}

var site = "<?php echo site_url();?>";
$(document).ready(function() {	
	$('#splitPayment').hide();    	
	$('#penghambat').hide();
	var cara_bayar = "<?php echo $data_pasien->cara_bayar;?>"; 
	//alert(cara_bayar);

	var total = "<?php echo $jumlah_vtot; ?>";
	
	document.getElementById("jenis_bayar").disabled = true;
	$("#biaya_t").val(total);
	$('#nilai_tunai_1').val(total);		

});


function penyetorDetail(){
	var num = $('#penyetor').val(); 
	$('#penyetor_hide').val(num); 
	$('#penyetor_hide_1').val(num); 
}

function biaya_tunaiDetail(){
	var num = $('#biaya_tunai').val(); 
	$('#biaya_tunai_hide').val(num); 
}

function biaya_NontunaiDetail(){
	var num = $('#biaya_non_tunai').val(); 
	$('#biaya_non_tunai_hide').val(num); 
}

function cetak(){
	var no_register = $('#no_register').val(); 
	var penyetor = $('#penyetor').val(); 
	var jenis_bayar = $('#jenis_bayar_hide_1').val(); 
	
	var myWindow = window.location.assign("<?php echo base_url('irj/rjckwitansi/kwitansi')?>");
	// myWindow.focus();
}

// function setCash(){
// 	var num0 = $('#cashRate').val();
// 	var num1 = $('#biaya_k').val(); 
// 	var nokartuk1 = $('no_kartuk').val();
	
// 	if(num0!=''){
// 		var charge = (parseInt(num0)/100)*parseInt(num1);
// 		$('#cashFee').val(charge);
// 		$('#charge_rate_1').val(num0); 
// 		$('#charge_rate_2').val(num0); 
// 		$('#charge_fee_1').val(charge); 
// 		$('#charge_fee_2').val(charge);
// 		$('#no_kk_hide').val(nokartuk1);
// 		var result = parseInt(charge)+parseInt(num1);
// 		$('#kartuk').val(result); 
// 		$('#nilai_kk_1').val(num1); 
// 		$('#nilai_kk_2').val(num1); 
// 	}
	
// }

function selisihUangMuka(){
	var total = "<?php echo $jumlah_vtot; ?>";
	var num = $('#uangMuka').val(); 
	
//	alert(result);
	//$('#penyetor_hide').val(num); 
}
function jenis_bayar(bayar){
	$('#jenis_bayar_hide_1').val(bayar); 
	$('#jenis_bayar_hide_2').val(bayar); 
	//alert($('#jenis_bayar_hide_1').val() );
}
function bayar(bayars){
	$('#pembayaran_hide').val(bayars); 
	//alert($('#jenis_bayar_hide_1').val() );
	if(bayars == 'split'){
		$('#splitPayment').show();
	}else{
		$('#splitPayment').hide();
	}
}
function setTotal(){
	var total = "<?php echo $jumlah_vtot; ?>";
	console.log(total);
	var cara_bayar = "<?php echo $data_pasien->cara_bayar;?>"; 
	// var potong=$('#diskon').val();
	// $('#diskon_hide_1').val(potong);
	// $('#diskon_hide_2').val(potong);
	var tunai = $('#biaya_t').val();
	//var kartuk = $('#kartuk').val(); 
	// var tunaikk = $('#biaya_k').val();
	//var charge = $('#cashFee').val();
	//alert("kartuk "+kartuk);alert("potong "+potong);alert("tunai "+tunai);alert("tunai kk "+tunaikk);alert("charge "+charge);
	if(potong==''){
		potong='0';
	}
	if(tunai==''){
		tunai='0';
	}	
	// if(tunaikk==''){
	// 	tunaikk='0';
	// }		
	//if(kartuk==''){
		//kartuk='0';
		var totalfix = parseInt(total);
		console.log(totalfix);
		if(totalfix!='0'){
			//if(cara_bayar!='BPJS'){
				
				//if(totalfix=='0'){
					//$('#totfinal').val(totalfix);
					//$('#totfinal_hide_1').val(totalfix); 
					//$('#totfinal_hide_2').val(totalfix);
					//document.getElementById("btn-cetak").disabled = false;
					//document.getElementById("btn-cetak-detail").disabled =false;
				// }else{
				// 	alert("Jumlah pembayaran tidak sesuai : "+ totalfix);
				// 	$('#totfinal').val(totalfix);
				// 	$('#totfinal_hide_1').val(totalfix); 
				// 	$('#totfinal_hide_2').val(totalfix);
				// 	document.getElementById("btn-cetak").disabled = true;
				// 	//document.getElementById("btn-cetak-detail").disabled =true;
				// }
			// }else {
			// 	//alert("Jumlah "+ totalfix);
			// 	alert("Jumlah pembayaran tidak sesuai : "+ totalfix);
			// 	document.getElementById("btn-cetak").disabled = true;
			// 	//document.getElementById("btn-cetak-detail").disabled =true;
			// }
			
		}else{
			//$('#totfinal').val(total); 
			//$('#totfinal_hide_1').val(total); 
			//$('#totfinal_hide_2').val(total);
			// $('#nilai_tunai_1').val($('#biaya_t').val());
			//$('#nilai_tunai_2').val($('#biaya_t').val());
			//document.getElementById("btn-cetak").disabled = false;
			//document.getElementById("btn-cetak-detail").disabled =false;
		}
	// }else{
	// 	var totalfix = parseInt(total)-parseInt(kartuk)-parseInt(tunai)-parseInt(potong);
	// 	//alert(totalfix+" kartuk!=0");
	// 	if(totalfix=='0'){
	// 		$('#totfinal').val(parseInt(total)); 
	// 		$('#totfinal_hide_1').val(parseInt(total)); 
	// 		$('#totfinal_hide_2').val(parseInt(total));
		
	// 		document.getElementById("btn-cetak").disabled = false;
	// 		//document.getElementById("btn-cetak-detail").disabled =false;
	// 	}else{
	// 		alert("Jumlah pembayaran tidak sesuai : "+ totalfix);
	// 		$('#totfinal').val(totalfix); 
	// 		document.getElementById("btn-cetak").disabled = true;
	// 		//document.getElementById("btn-cetak-detail").disabled =true;
	// 	}
	// }
	//alert("hhahah "+ charge);
	// if(charge==''){
	// 	$('#charge_rate_1').val('0'); 
	// 	$('#charge_rate_2').val('0');
	
	// 	$('#nilai_kk_1').val(tunaikk); 
	// 	$('#nilai_kk_2').val(tunaikk);
	// 	//alert("hahahahahahha"); 
	// }
	//alert( total+" + "+tunaikk +" - "+ tunai +" - "+ potong +" = "+ totalfix);
	//$('#totfinal').val(total); 
	// $('#nilai_tunai_1').val($('#biaya_t').val());
	// $('#nilai_tunai_2').val($('#biaya_t').val());
	
	// $('#nilai_kk_1').val(tunaikk); 
	// $('#nilai_kk_2').val(tunaikk);

	// var notedisc = $('#note_diskon').val();
	//$('#notedisc_hide').val(notedisc);
	 
}

function showswal() {
	var base = "<?php echo base_url(); ?>";
	new swal({
		title: "",
		text: "MOHON KEMBALI KE HALAMAN SEBELUMNYA",
		type: "info",
		showConfirmButton: true,
		showCancelButton: false,
		closeOnConfirm: false,
		showLoaderOnConfirm: true
	},
	function () {
		window.location.href = base+"irj/rjckwitansi/kwitansi_detail";
	});
}
function diskontindakan(idtindakan,diskon)
{
	// console.log(idtindakan);
	// console.log(diskon);
	// console.log();
	let hargaSebelumnya = parseInt($('#biaya-'+idtindakan).html().replace(",", ""));
	if(hargaSebelumnya <= diskon) {
		$('#biaya-'+idtindakan).html(0);
		let totalVtot =  parseInt($("#totalVtot").html().replace(",", ""));
		//$("#biaya_t").val(0);
		$("#totfinal").val(0);
		$("#totfinal_hide_1").val(0);
		if(totalVtot <= diskon) {
			$("#totalVtot").html(0);
			$("#biaya_t").val(0);
		} else {
			$("#totalVtot").html(totalVtot - parseInt(diskon));
			$("#biaya_t").val(totalVtot - parseInt(diskon));
		}
	} else {
		$('#biaya-'+idtindakan).html(hargaSebelumnya - parseInt(diskon));
		let totalVtot = parseInt($("#totalVtot").html().replace(",", ""));
		$("#biaya_t").val(totalVtot - parseInt(diskon));
		$("#totfinal").val(totalVtot - parseInt(diskon));
		$("#totfinal_hide_1").val(totalVtot - parseInt(diskon));
		$("#totalVtot").html(totalVtot - parseInt(diskon));
	}	
	$('#nilai_tunai_1').val($('#biaya_t').val());
	$('#diskon_hide_1').val(diskon);
	$('#idtindakan').val(idtindakan);
	console.log(idtindakan);
}

function simpanDiskon(idtindakan,diskon)
{
	document.getElementById(diskon).innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
	$.ajax({  
		url:"<?php echo base_url(); ?>irj/rjckwitansi/update_diskon_poli",                         
		method:"POST",  
		data:{
			noreg:'<?php echo $no_register ?>',
			id_tindakan:idtindakan,
			diskon_item:$('#'+diskon).val()
		},   
		success: function(data)  
		{ 
		document.getElementById(diskon).innerHTML = 'Input';
		// $('#ulangModal').modal('hide'); 
		// document.getElementById("ulang_form").reset();
		swal({
								title: "Selesai",
								text: "Data berhasil disimpan",
								type: "success",
								showCancelButton: false,
								closeOnConfirm: true,
								showLoaderOnConfirm: true
							},
							function () {
								//location.href = '<?php echo base_url().'rad/radcdaftar/pemeriksaan_rad/' ?>'+no_register;
							}); 
		},
		error:function(event, textStatus, errorThrown) {
		document.getElementById(diskon).innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
		//$('#ulangModal').modal('hide');
		swal("Error","Data gagal diperbaharui.", "error"); 
		console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		}  
	});  
}

</script>
<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>
]
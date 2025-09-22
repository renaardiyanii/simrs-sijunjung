<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
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

function factur(){
	window.open("<?php echo site_url('urikes/Cukwitansi/cetak_faktur_kw5_kt/').'/'.$data_pasien->nomor_kode;?>", "_blank");
	window.focus();
}
</script>

	<div class="container-fluid">
		<section class="content-header">
		</section>
		<section class="content">
			<div class="row">
				<div class="card card-outline-success">
					<div class="card-header" align="center">Detail Biaya Pemeriksaan</div>
					<div class="card-block">
						<br/>
						<div style="display:block;overflow:auto;">
							<table class="table">
							  <tbody>
								<tr>
									<th>No. Register</th>
									<td>:</td>
									<td><?php echo $data_pasien->nomor_kode;?></td>
									<th>Tanggal Kunjungan</th>
									<td>:</td>
									<td><?php echo date("d-m-Y", strtotime($data_pasien->tgl_daftar)); ?></td>
								</tr>
								<tr>
									<th>Nama Pasien</th>
									<td>:</td>
									<td><?php echo strtoupper($data_pasien->nama);?></td>
									<th>NRP/NIP</th>
									<td>:</td>
									<td><?php echo $data_pasien->nip;?></td>
								</tr>
								<tr>
					
					 <th>Keterangan Status</th>
					<td>:</td>
					<td><?php echo $data_pasien->status;?></td>
			<!--		
			</tr>
			<tr>
				<th><p style="padding-top:3px;">Pilih Jenis Pembayaran</p></th>
					<td><p style="padding-top:3px;">:</p></td>
					<td><select class="form-control" name="jenis_bayar" id="jenis_bayar" style="border: 2px solid  #7DBE64;" onchange="jenis_bayar(this.value)" required>
							<option value="">-Pilih Jenis Pembayaran-</option>
							<option value="1">TUNAI </option>
							<option value="0">KREDIT</option>
						</select></td>
				
					<th>Dijamin Oleh</th>
					<td>:</td>
					<td>
				
			</tr> -->
							  </tbody>
							</table>
							<hr>
							<table class="table table-hover table-striped table-bordered">
							  <thead>
								<tr>
								  <th>No</th>
								  <th>Pemeriksaan</th>
								  <th>Biaya</th>
								</tr>
							  </thead>
							  <tbody>
								
								<?php
								$jumlah=$data_pasien->total_tarif;
								// foreach($data_tindakan as $row){
								// 	if($row->bpjs==0){
								// 	$jumlah_vtot=$jumlah_vtot+$row->vtot;
								// 	}
								// }
								//echo $jumlah_vtot;
								?>
									<tr>
									  <td>1</td>
									  <td><?php echo $data_pasien->jenis; ?></td>
									  <td>Rp <div class="pull-right"><?php echo number_format( $data_pasien->total_tarif, 2 , ',' , '.' );?></div></td>
									</tr>
									<tr>
									  <th colspan="2" >Total</th>
									  <th>Rp <div class="pull-right"><?php echo number_format( $data_pasien->total_tarif, 2 , ',' , '.' );?></div></th>
									</tr>
								</tbody>
							</table>
						</div><!-- style overflow -->
						
						<?php
						//echo $this->session->flashdata('message_no_tindakan'); 
						if($this->session->flashdata('message_no_tindakan')=='tindakan_kosong'){
						?>
							<div class="form-inline" align="right">
								<div class="form-group">
							
									<a href="<?php echo site_url('urikes/Cukwitansi/st_selesai_kwitansi_detail_kt/'.$data_pasien->idurikes.'/'.$data_pasien->nomor_kode);?>"><input type="button" class="btn btn-primary btn-sm" id="btn_selesai" value="Selesai"></a>
								</div>
							</div>
						<?php
							
						}else{?>
						<table class="table table-responsive" >		  
		<tbody>
			<!-- <tr id="uangmuka0" name="uangmuka0">
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
			</tr> -->
			
			<tr>
				<th>Dibayar Kartu Kredit/Debit</th>
				<td>:</td>
				<td><input type="text" class="form-control" name="no_kartuk" id="no_kartuk" placeholder="Nomor Kartu"></td>
				<td><div class="input-group">
						<span class="input-group-addon">Rp</span>
						<input type="text" class="form-control" name="biaya_k" id="biaya_k" placeholder="Nominal KK/Debit"></td>
				   </div>		
			</tr>
			<!--<tr>
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
			</tr>-->
			<tr id="kredit0" name="kredit0">
				<th>Pengurangan/Diskon</th>
				<td>:</td>
				<td><div class="input-group"><span class="input-group-addon">Rp</span>						
					<input type="text" class="form-control" name="diskon" id="diskon" placeholder="Nominal Pengurangan" >				
					</div>	
				</td>
				<td>
					
				</td>
			</tr>
			<tr>
				<th style="width:20%;">Catatan Pengurangan/Diskon</th>
				<td>:</td>
				<td style="width:40%;">
					<input type="text" class="form-control" name="note_diskon" id="note_diskon" placeholder="Catatan Diskon/Pengurangan" required>
					
				</td>
				
			</tr>
						
			<tr>
				<th style="width:20%;">Dibayar Tunai</th>
				<td>:</td>
				<td style="width:40%;">
					<div class="input-group">
						<span class="input-group-addon">Rp</span>
						<input type="text" class="form-control" name="biaya_t" id="biaya_t" placeholder="Nominal Tunai" >
					</div>
				</td>
				<td style="width:40%;"></td>
			</tr>
			<tr>
				<th>Total Akhir</th>
				<td>:</td>
				<td><div class="input-group">
						<span class="input-group-addon">Rp</span>
							<input type="text" class="form-control" placeholder="0" name="totfinal" id="totfinal" disabled>							
						<span class="input-group-btn">
						<button type="btn" class="btn btn-primary" onclick="setTotal()">Hitung</button>
					</span>
					</div>
				</td>
			</tr>
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
			<?php echo form_open('urikes/cukwitansi/st_cetak_kwitansi_detail_kt');?>
					<input type="hidden" class="form-control" name="penyetor_hide" id="penyetor_hide">
					<input type="hidden" class="form-control" name="notedisc_hide" id="notedisc_hide">
					<input type="hidden" class="form-control" name="pilih" value="0" >
					<input type="hidden" class="form-control" name="no_register" value="<?php echo $data_pasien->nomor_kode ?>">
					<input type="hidden" class="form-control" name="idurikes" value="<?php echo $data_pasien->idurikes ?>">
					<input type="hidden" class="form-control" name="penyetor" id="penyetor_hide_1">
					<input type="hidden" class="form-control" name="jenis_bayar_hide" id="jenis_bayar_hide_1">
					<input type="hidden" class="form-control" name="diskon_hide" id="diskon_hide_1">
					<input type="hidden" class="form-control" name="totakhir_hide" id="totakhir_hide" >
					<input type="hidden" class="form-control" name="charge_rate" id="charge_rate_1" >
					<input type="hidden" class="form-control" name="totakhir_hide" id="totakhir_hide" >
					<input type="hidden" class="form-control" name="charge_fee" id="charge_fee_1" >
					<input type="hidden" class="form-control" name="no_kk" id="no_kk_hide" >
					<input type="hidden" class="form-control" name="nilai_kk" id="nilai_kk_1" >
					<input type="hidden" class="form-control" name="nilai_tunai" id="nilai_tunai_1" >
					<input type="hidden" class="form-control" name="totfinal_hide" id="totfinal_hide_1">
					<span>
						<button type="submit" id="btn-cetak" class="btn btn-primary">Cetak</button>
					</span>									
			<?php echo form_close();?>
			</div>
			<button class="btn" onclick="factur()">Faktur</button>
			<!---<div class="input-group">			
			<?php //echo form_open('irj/rjckwitansi/st_cetak_kwitansi_kt');?>
					
					<input type="hidden" class="form-control" name="pilih" value="detail" >
					<input type="hidden" class="form-control" name="penyetor_hide" id="penyetor_hide">
					<input type="hidden" class="form-control" name="jenis_bayar_hide" id="jenis_bayar_hide_2">
					<input type="hidden" class="form-control" name="no_register" value="<?php //echo $no_register ?>">
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
		</div><!--- end panel body -->
		</div><!--- end panel -->
			</div><!--- end panel -->
		</section>
	</div><!--- end container -->

<script type='text/javascript'>	
var site = "<?php echo site_url();?>";
$(document).ready(function() {	    	
	
	//alert(cara_bayar);

	var total = "<?php echo $data_pasien->total_tarif; ?>";
	
	// document.getElementById("jenis_bayar").disabled = true;
	if(total!='0'){
		// if(cara_bayar=='BPJS'){
		// //$("#biaya_t").val(total);
		// //$("#diskon").val(total);
		// //setTotal();
		// $("#jenis_bayar").val('0').change();
		// }else if(cara_bayar=='DIJAMIN')
		// {
		// 	$("#jenis_bayar").val('0').change();
		// 	$("#biaya_t").val(total);
		// }else if (cara_bayar=='UMUM'){
		// 	$("#jenis_bayar").val('1').change();
		// 	//$("#biaya_t").val(total);
		}
		else alert('ERROR!');

	document.getElementById("btn-cetak").disabled = true;
	//document.getElementById("btn-cetak-detail").disabled =true;
	

    });



function setTotal(){
	var total = "<?php echo $data_pasien->total_tarif; ?>";
	var potong=$('#diskon').val();
	$('#diskon_hide_1').val(potong);
	$('#diskon_hide_2').val(potong);
	var tunai = $('#biaya_t').val();
	var kartuk = $('#kartuk').val(); 
	var tunaikk = $('#biaya_k').val();
	//var charge = $('#cashFee').val();
	//alert("total "+total);alert("kartuk "+kartuk);alert("potong "+potong);alert("tunai "+tunai);alert("tunai kk "+tunaikk);alert("charge "+charge);
	if(potong==''){
		potong='0';
	}
	if(tunai==''){
		tunai='0';
	}	
	if(tunaikk==''){
		tunaikk='0';
	}	
	/*if(charge==''){
		charge='0';
	}*/		
	if(kartuk==''){
		kartuk='0';
		var totalfix = parseInt(total)-parseInt(tunaikk)-parseInt(tunai)-parseInt(potong);
		if(totalfix!='0'){
			// if(cara_bayar!='BPJS'){
				if(totalfix=='0'){
					$('#totfinal').val(totalfix);
					$('#totfinal_hide_1').val(totalfix); 
					$('#totfinal_hide_2').val(totalfix);
					document.getElementById("btn-cetak").disabled = false;
					//document.getElementById("btn-cetak-detail").disabled =false;
				}else{
					alert("Jumlah pembayaran tidak sesuai : "+ totalfix);
					$('#totfinal').val(totalfix);
					$('#totfinal_hide_1').val(totalfix); 
					$('#totfinal_hide_2').val(totalfix);
					document.getElementById("btn-cetak").disabled = true;
					//document.getElementById("btn-cetak-detail").disabled =true;
				}
			// } else {
			// 	//alert("Jumlah "+ totalfix);
			// 	alert("Jumlah pembayaran tidak sesuai : "+ totalfix);
			// 	document.getElementById("btn-cetak").disabled = true;
			// 	//document.getElementById("btn-cetak-detail").disabled =true;
			// }
			
		}else{
			$('#totfinal').val(total); 
			$('#totfinal_hide_1').val(total); 
			$('#totfinal_hide_2').val(total);
			$('#nilai_tunai_1').val($('#biaya_t').val());
			$('#nilai_tunai_2').val($('#biaya_t').val());
			document.getElementById("btn-cetak").disabled = false;
			//document.getElementById("btn-cetak-detail").disabled =false;
		}
	}else{
		var totalfix = parseInt(total)-parseInt(tunaikk)-parseInt(tunai)-parseInt(potong);
		//alert(totalfix+" kartuk!=0");
		if(totalfix=='0'){
			$('#totfinal').val(parseInt(total));//+parseInt(charge)); 
			$('#totfinal_hide_1').val(parseInt(total));//+parseInt(charge)); 
			$('#totfinal_hide_2').val(parseInt(total));//+parseInt(charge));
		
			document.getElementById("btn-cetak").disabled = false;
			//document.getElementById("btn-cetak-detail").disabled =false;
		}else{
			alert("Jumlah pembayaran tidak sesuai : "+ totalfix);
			$('#totfinal').val(totalfix); 
			document.getElementById("btn-cetak").disabled = true;
			//document.getElementById("btn-cetak-detail").disabled =true;
		}
	}
	//alert("hhahah "+ charge);
	//if(nilaikk==''){
		//$('#charge_rate_1').val('0'); 
		//$('#charge_rate_2').val('0');
	
		//$('#nilai_kk_1').val(tunaikk); 
		//$('#nilai_kk_2').val(tunaikk);
		//alert("hahahahahahha"); 
	//}
	//alert( total+" + "+tunaikk +" - "+ tunai +" - "+ potong +" = "+ totalfix);
	//$('#totfinal').val(total); 
	$('#nilai_tunai_1').val($('#biaya_t').val());
	$('#nilai_tunai_2').val($('#biaya_t').val());
	
	$('#nilai_kk_1').val(tunaikk); 
	$('#nilai_kk_2').val(tunaikk);

	var notedisc = $('#note_diskon').val();
	$('#notedisc_hide').val(notedisc);
	
	 
}


// function penyetorDetail(){
// 	var num = $('#penyetor').val(); 
// 	$('#penyetor_hide').val(num); 
// 	$('#penyetor_hide_1').val(num); 
// }

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

// function selisihUangMuka(){
// 	var total = "";
// 	var num = $('#uangMuka').val(); 
	
// //	alert(result);
// 	//$('#penyetor_hide').val(num); 
// }
// function jenis_bayar(bayar){
// 	$('#jenis_bayar_hide_1').val(bayar); 
// 	$('#jenis_bayar_hide_2').val(bayar); 
// 	//alert($('#jenis_bayar_hide_1').val() );
// }

</script>
<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>

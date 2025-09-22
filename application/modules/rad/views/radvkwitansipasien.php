<?php
	if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?>

<div class="row">
    <div class="col-md-12">
        <div class="card card-block printableArea">
            <h3><b>INVOICE</b> <span class="pull-right">#<?php echo $no_rad; ?></span></h3>
            <hr>
            <div class="row">
                <div class="col-md-12">
					<div class="table-responsive">
						<table class="table">
						  	<tbody>
								<tr>
									<td>No CM</td>
									<td>:</td>
									<td><?php echo $data_pasien->no_cm;?></td>
									<td>Tanggal Kunjungan</td>
									<td>:</td>
									<td><?php echo date("d-m-Y", strtotime($data_pasien->tgl) );?></td>
								</tr>
								<tr>
									<td>No. Register</td>
									<td>:</td>
									<td><?php echo $data_pasien->no_register;?></td>
									<td>Kelas Pasien</td>
									<td>:</td>
									<td><?php echo $data_pasien->kelas;?></td>
								</tr>
								<tr>
									<td>Nama Pasien</td>
									<td>:</td>
									<td><?php echo $data_pasien->nama;?></td>
									<td>Asal</td>
									<td>:</td>
									<td><?php echo $data_pasien->asal;?></td>
								</tr>
						  	</tbody>
						</table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive m-t-40" style="clear: both;">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Deskripsi</th>
                                    <th class="text-right">Banyak</th>
                                    <th class="text-right">Biaya</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
									$i=1;
									$jumlah_vtot=0;
									foreach($data_pemeriksaan as $row){
								?>
									<tr>
	                                    <td class="text-center"><?php echo $i++;?></td>
	                                    <td><?php echo $row->jenis_tindakan; ?></td>
	                                    <td class="text-right"><?php echo $row->qty;?> </td>
	                                    <td class="text-right"> <?php echo number_format( $row->biaya_rad, 2 , ',' , '.' ); ?> </td>
	                                    <td class="text-right"> Rp <?php echo number_format( $row->vtot, 2 , ',' , '.' );
									  			$jumlah_vtot=$jumlah_vtot+$row->vtot?> </td>
									</tr>
								<?php
									}
								?>
								<?php if(substr($data_pasien->no_register,0,2) == 'PL'){?>
									<tr>
										<td class="text-center"></td>
	                                    <td><?php echo $data_adm->nmtindakan; ?></td>
	                                    <td class="text-right"></td>
	                                    <td class="text-right"> <?php echo number_format($data_adm->total_tarif, 2, ',', '.'); ?> </td>
	                                    <td class="text-right"> Rp <?php echo number_format($data_adm->total_tarif, 2, ',', '.');
												$jumlah_vtot += $data_adm->total_tarif ?> </td>
									</tr>
									<?php
									}
								?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="pull-right m-t-30 text-right">
                        <!-- <p>Sub - Total amount: $13,848</p>
                        <p>vat (10%) : $138 </p>
                        <hr> -->
                        <h3><b>Total :</b> RP <?php echo number_format( $jumlah_vtot, 2 , ',' , '.' );?></h3>
                    </div>
                    <div class="clearfix"></div>
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
                    <!-- <div class="text-right">
						<div class="input-group"><span class="input-group-addon">Rp</span>								
							<input type="text" class="form-control" placeholder="Diskon" name="diskon" id="diskon">				
							<span class="input-group-btn">
								<button type="btn" class="btn btn-primary" onclick="setTotakhir()">Input</button>
							</span>
						</div>		
                    </div><br> -->
					<div class="text-right">
						<div class="col-sm-12 pull-right" style="width:29%;">
						<p class="form-control-label" align="right" style="margin-top:7px;">Jenis Pembayaran</p>
							<div class="input-group">
							<select class="form-control" name="pembayaran" id="pembayaran" style="border: 2px solid  #7DBE64;" onchange="bayar(this.value)" required>
								<option value="">-Pilih Pembayaran-</option>
								<option value="TUNAI">TUNAI </option>
								<option value="BANK">BANK</option>
								<option value="VA">Virtual Account</option>
								<!-- <option value="split">Split Payment</option>
                                <option value="PIUTANG/IKS">Piutang/Cicilan</option> -->
							</select>
							</div>
						</div>	
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <div class="text-right">
						<div class="col-sm-12 pull-right" style="width:29%;">
						<p class="form-control-label" align="right" style="margin-top:7px;">Total Biaya setelah diskon : </p>
							<div class="input-group">
								<span class="input-group-addon">Rp</span>
									<input type="text" class="form-control" placeholder="0" name="totakhir" id="totakhir" disabled>
								</span>
							</div>
						</div>	
                    </div>
                    <div class="clearfix"></div>
                    <hr>
					<?php
						//echo form_open('rad/radckwitansi/st_cetak_kwitansi_kt',array('target'=>'_blank'));
					?>
					<form id="cetakKwitansi">
                    <div class="text-right">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Sudah Terima Dari" name="penyetor" id="penyetor" value="<?php echo $data_pasien->nama;?>">
							<!--<a href="<?php //echo site_url('irj/rjckwitansi/st_cetak_kwitansi_kt/'.$no_lab);?>"><input type="button" class="btn btn-primary btn-sm" id="btn_simpan" value="Cetak"></a>-->
							<span class="input-group-btn">
								<button type="button" class="btn btn-primary" id="btn-kwitansi" onclick="submitPembayaran();">Cetak</button>
							</span>
						</div>
                    </div>
					<!-- added @aldi , untuk keperluan pacs -->
					<input type="hidden" class="form-control" name="pembayaran_hide" id="pembayaran_hide">
					<input type="hidden" name="list_tindakan" value='<?php echo json_encode($data_pemeriksaan); ?>'>
					<input type="hidden" class="form-control" name="no_rad" id="no_rad" value="<?php echo $no_rad ?>">
					<input type="hidden" class="form-control" name="jumlah_vtot" value="<?php echo $jumlah_vtot ?>">
					<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
					<input type="hidden" class="form-control" placeholder="" name="diskon_hide" id="diskon_hide">
					<input type="hidden" class="form-control" name="biaya_tunai_hide" id="biaya_tunai_hide">
					<input type="hidden" class="form-control" name="biaya_non_tunai_hide" id="biaya_non_tunai_hide">
					<?php 
						//echo form_close();
					?>
					</form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type='text/javascript'>

function submitPembayaran()
{
	
	if($('#pembayaran').val()==''){
		alert('anda harus pilih pembayaran');
		return;
	}
	let data = $("#cetakKwitansi").serialize();
	$.ajax({  
		url:"<?= base_url() ?>/rad/radckwitansi/st_cetak_kwitansi_kt",                         
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
				window.open('<?php echo base_url() ?>'+'rad/radckwitansi/cetak_kwitansi_kt/'+'<?= $no_rad ?>','_blank');
				window.location.href = '<?php echo base_url() ?>'+"rad/radckwitansi/kwitansi";
				// window.location.href = '<?php echo base_url() ?>'+"irj/rjckwitansi/kwitansi_all_rj";
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
		var total = "<?php echo $jumlah_vtot; ?>";	
		// $("#totakhir").maskMoney({thousands:',', decimal:'.', affixesStay: true});
		$('#totakhir').val(total);
		$('#splitPayment').hide();
    	// $("#btn-kwitansi").prop('disabled',true);
	});

	function setTotakhir(){
		// var num = $('#diskon').maskMoney('unmasked')[0]; 
		var num = $('#diskon').val(); 
		$('#diskon_hide').val(num);		
		var total = "<?php echo $jumlah_vtot; ?>";	
    	$("#btn-kwitansi").prop('disabled',false);
		if(total-num>=0){
			$('#totakhir').val(total-num);
			$("#totakhir").maskMoney('mask');
			$('#totakhir_hide').val(total-num);
		}
		else
			alert("Diskon melebihi biaya total !");
	}

	function penyetorDetail(){
		var num = $('#penyetor').val(); 
		$('#penyetor_hide').val(num); 
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
		var no_rad = $('#no_rad').val(); 
		var penyetor = $('#penyetor').val(); 
		
		var myWindow = window.open("<?php echo base_url('rad/radckwitansi/cetak_kwitansi_kt')?>/"+no_rad+"/"+penyetor+"/", "", "width=200,height=100");
		myWindow.focus();
	}

	function showswal() {
		var base = "<?php echo base_url(); ?>";
		new swal({
			title: "",
			text: "MOHON REFRESH HALAMAN",
			type: "info",
			showConfirmButton: true,
			showCancelButton: false,
			closeOnConfirm: false,
			showLoaderOnConfirm: true
		},
		function () {
			window.location.href = base+"rad/radckwitansi/kwitansi";
		});
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
</script>
	
<?php
	if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>
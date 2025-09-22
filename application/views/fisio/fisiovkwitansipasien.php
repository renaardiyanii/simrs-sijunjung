<?php
	$this->load->view('layout/header_left.php');
?>


<div class="row">
    <div class="col-md-12">
        <div class="card card-block printableArea">
            <h3><b>INVOICE</b> <span class="pull-right">#<?php echo $no_lab; ?></span></h3>
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
									<td><?php echo $data_pasien->ruang;?></td>
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
	                                    <td class="text-right"> <?php echo number_format( $row->biaya_lab, 2 , ',' , '.' ); ?> </td>
	                                    <td class="text-right"> Rp <?php echo number_format( $row->vtot, 2 , ',' , '.' );
									  			$jumlah_vtot=$jumlah_vtot+$row->vtot?> </td>
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
                    <hr>
                    <div class="text-right">
						<div class="input-group"><span class="input-group-addon">Rp</span>								
							<input type="text" class="form-control" placeholder="Diskon" name="diskon" id="diskon">				
							<span class="input-group-btn">
								<button type="btn" class="btn btn-primary" onclick="setTotakhir()">Input</button>
							</span>
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
						echo form_open('lab/labckwitansi/st_cetak_kwitansi_kt');
					?>
                    <div class="text-right">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Sudah Terima Dari" name="penyetor">
							<!--<a href="<?php //echo site_url('irj/rjckwitansi/st_cetak_kwitansi_kt/'.$no_lab);?>"><input type="button" class="btn btn-primary btn-sm" id="btn_simpan" value="Cetak"></a>-->
							<span class="input-group-btn">
								<button type="submit" class="btn btn-primary">Cetak</button>
							</span>
						</div>
                    </div>
					<input type="hidden" class="form-control" name="no_lab" value="<?php echo $no_lab ?>">
					<input type="hidden" class="form-control" name="jumlah_vtot" value="<?php echo $jumlah_vtot ?>">
					<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
					<input type="hidden" class="form-control" placeholder="" name="diskon_hide" id="diskon_hide">
					<?php 
						echo form_close();
					?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type='text/javascript'>
	var site = "<?php echo site_url();?>";

	$(document).ready(function() {
		$("#totakhir").maskMoney({thousands:'.', decimal:',', affixesStay: true, precision: 0});
	});

	function setTotakhir(){
		// var num = $('#diskon').maskMoney('unmasked')[0]; 
		var num = $('#diskon').val(); 
		$('#diskon_hide').val(num);		
		var total = "<?php echo $jumlah_vtot; ?>";	
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
</script>
<?php
	$this->load->view('layout/footer_left.php');
?>

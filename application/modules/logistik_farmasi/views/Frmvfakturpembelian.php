<?php
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_horizontal");
}
?>

<?php echo $this->session->flashdata('message_no_tindakan'); ?>


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

	<div class="card card-outline-info">
		<!-- <section class="content-header">
		</section> -->
		<section class="card-block">
			<div class="row">
				 <div class="col-sm-12">
					<div class="ribbon-wrapper card">
			            <div class="ribbon ribbon-info">Rekap Transaksi</div>
					<div class="panel-body">
						<br/>
						<div style="display:block;overflow:auto;">
							<table class="table">
							  <tbody>
								<tr>
									<th>No Faktur</th>
									<td>:</td>
									<td><?php echo $no_faktur;?></td>
									<th>Tanggal Verifikasi</th>
									<td>:</td>
									<td><?php echo $receiving_time;?></td>
								</tr>
								<tr>
									<th>Receiving Id</th>
									<td>:</td>
									<td><?php echo $id_receiving;?></td>
									<th>Tanggal Terima Barang</th>
									<td>:</td>
									<td><?php echo $diterima_barang;?></td>
								</tr>
								<tr>
									<th>Nama Produsen/Prinsipal</th>
									<td>:</td>
									<td><?php echo $supplier_id?></td>
									<th>PBF</th>
									<td>:</td>
									<td><?php echo $pbf;?></td>
									<th></th>
									<td></td>
									<td></td>
								</tr>
								
							  </tbody>
							</table>
						
							<table class="table table-hover table-striped table-bordered">
							  <thead>
								<tr>
								  <th>No</th>
								  <th>Nama Obat</th>
								  <th>Harga</th>
								  <th>Banyak</th>
								  <th>PPN</th>
								  <th>Diskon Item</th>
								  <th>Total</th>
								</tr>
							  </thead>
							  <tbody>
									<?php
										$i=1;
										$jumlah_vtot=0;
										foreach($receiving_item as $row){
									?>
										<tr>
										  <td><?php echo $i++;?></td>
										  <td><?php echo $row->description; ?></td>
										  <td><?php echo ($row->item_cost_price/$row->quantity_purchased); ?></td>
										  <td><?php echo $row->quantity_purchased;?></td>
										  <td><?php echo $row->ppn_percent."%";?></td>
										  <td><?php echo $row->discount_percent."%";?></td>
										  <td>Rp <div class="pull-right"><?php echo number_format( $row->item_cost_price, 2 , ',' , '.' );
										  			$jumlah_vtot=$jumlah_vtot+$row->item_cost_price?>
										  	</div>
										  </td>
										</tr>
									<?php
										}
									?>
								
									<tr>
									  <th colspan="4">Total</th>
									  <th>Rp <div class="pull-right"><?php echo number_format( $jumlah_vtot, 2 , ',' , '.' );?></div></th>
									</tr>
								</tbody>
							</table>
							
						</div><!-- style overflow -->
						
						
				<div class="form-inline pull-right" style="margin-right:10px;">
						
				<div class="input-group"><span class="input-group-addon">Rp</span>								
					<input type="text" class="form-control" placeholder="Biaya Tambahan" name="b_tambahan" id="b_tambahan">				
					
					<span class="input-group-btn">
						<button type="btn" class="btn btn-primary" onclick="setTotakhir()">Input</button>
					</span>
				
				</div>	
					
				</div><br><br>

				<div class="form-inline pull-right" style="margin-right:10px;">
						

						<div class="input-group"><span class="input-group-addon">Pembulatan</span>								
							<input type="text" class="form-control" placeholder="0" name="pembulatan" id="pembulatan">				
							
							<span class="input-group-btn">
								<button type="btn" class="btn btn-primary" onclick="setTotakhir()">Input</button>
							</span>
						
						</div>	
						
					</div><br><br>
	
				<div class="form-group row">
					<p class="col-sm-8 form-control-label pull-right" align="right" style="margin-top:7px;">Total Biaya : </p>
					<div class="col-sm-4" style="width:10%;">
						<div class="input-group">
						<span class="input-group-addon">Rp</span>
							<input type="text" class="form-control" placeholder="0" name="totakhir" id="totakhir" disabled>
						</span>
						</div>
					</div>
				</div><br>


			<?php echo form_open('logistik_farmasi/Frmcpembelian/cetak_faktur');?>
		
		<div class="form-group row pull-right" align="right" style="margin-right:10px;">
					
			<div class="input-group">			
				
				<input type="hidden" class="form-control" name="pilih" value="0" >
				<input type="hidden" class="form-control" name="totakhir_hide" id="totakhir_hide" >
				<input type="hidden" class="form-control" name="totakhir" value="<?php //echo $totakhir ?>">
				<input type="hidden" class="form-control" name="diskon" value="<?php //echo $diskon ?>">
				<input type="hidden" class="form-control" name="pilih" value="detail" >
				<input type="hidden" class="form-control" name="penyetor_hide" id="penyetor_hide">
				<input type="hidden" class="form-control" name="faktur_hidden" id="faktur_hidden" value="<?php echo $no_faktur ?>">
				<input type="hidden" class="form-control" name="id_hidden" id="id_hidden" value="<?php echo $id_receiving ?>">
				<input type="hidden" class="form-control" name="jumlah_vtot" value="<?php echo $jumlah_vtot ?>">
				<input type="hidden" class="form-control" name="b_tambahan_hide" id="b_tambahan_hide">
				<input type="hidden" class="form-control" name="pembulatan_hide" id="pembulatan_hide">
				<input type="hidden" class="form-control" name="totdis" id="totdis">
				
				<span class="input-group-btn">

				<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">	
				<input type="hidden" class="form-control" name="diskon_hide" id="diskon_hide">
				<button type="submit" class="btn btn-primary">Cetak</button></span>
					
			</div>			
		</div>
		<br>
		<?php echo form_close();?>
	</div>
	
	
										
						
					
					</div>
				</div>
			</div>
		</section>
	</div>

<script type='text/javascript'>	
var site = "<?php echo site_url();?>";
$(document).ready(function() {
	$("#totakhir").maskMoney({thousands:',', decimal:'.', affixesStay: true});
    $("#diskon").maskMoney({thousands:',', decimal:'.', affixesStay: true});
    });

function setTotakhir(){
	var num = parseInt($('#b_tambahan').val()) || 0; 
	var bulat = parseFloat($('#pembulatan').val()) || 0;
	console.log(bulat);

	$('#b_tambahan_hide').val(num);
	$('#pembulatan_hide').val(bulat);
	var total = parseFloat(<?php echo $jumlah_vtot; ?>);	
	var hasul_pembulatan = total + (bulat) + num;
	
		$('#totakhir').val(hasul_pembulatan);
	
		$('#totakhir_hide').val(hasul_pembulatan);
}

function penyetorDetail(){ 
	var num = $('#penyetor').val(); 
	$('#penyetor_hide').val(num); 
}
</script>

<?php
	$this->load->view('layout/footer.php');
?>
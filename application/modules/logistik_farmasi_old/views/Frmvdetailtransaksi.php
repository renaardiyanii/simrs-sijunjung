<?php

    $this->load->view("layout/header_left");

?>
<html>

<script type="text/javascript">
$(document).ready(function() {
  $(".js-example-basic-single").select2({
            placeholder: "Select an option"
        });
});

$(function() {
  $('#date_picker').datepicker({
      format: "yyyy-mm-dd",
      
      autoclose: true,
      todayHighlight: true,
    });  
  	
  });
  
</script>
<script type="text/javascript">

//-----------------------------------------------Data Table
$(document).ready(function() {
    $('#tabel_receiving').DataTable();
    $('#dis').on("keypress keyup blur", function (event) {
		if ($(this).val() > 100) {
			$(this).val(0);
			swal('Perhatian!', 'Nilai diskon maksimal 100%.', 'warning');
		}
	});

} );
//---------------------------------------------------------

var site = "<?php echo site_url();?>";

function pilih_tindakan(idobat) {
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('logistik_farmasi/Frmcpembelian/get_biaya_obat')?>",
		data: {
			idobat: idobat
		},
		success: function(data){
			// alert(data);
			// $('#biaya_obat').val(data[0].hargabeli);
			// $('#biaya_obat_hide').val(data[0].hargabeli);
			$('#qty').val('1');
			// $('#faktor_satuan').val(data[0].faktorsatuan);
			$('#satuank').val(data.satuan);
			// $('#satuanb').val(data[0].satuanb);
			set_total() ;
		},
		error: function(){
			alert("error");
		}
    });
}

function set_total() {
	var biaya_besar = $('input[name=biaya_besar]').val();
	var ppn = $('input[name=ppn]:checked').val()/100;
	var faktor = $('input[name=faktor_satuan]').val();
	var margin = $('input[name=margin]').val();
	var dis = $('input[name=dis]').val();
	var qty_obat = $('input[name=qty]').val();
	var qty_obat_besar = $('input[name=qtyb]').val();
	var totdis = dis/100;

	var biaya_obat =biaya_besar/faktor;
	var biaya_total_sblm_diskon_ppn = biaya_besar * qty_obat_besar;


	var biaya_obat_dis = parseInt(biaya_obat) * totdis;
	var harga_stlh_diskon = biaya_obat - biaya_obat_dis;

	
	var biaya_obat_ppn = parseInt(harga_stlh_diskon) * ppn;
	var harga_beli = harga_stlh_diskon + biaya_obat_ppn;
	
	

	var harga_diskon_besar = parseInt(biaya_besar) * totdis;
	var harga_besar_stlh_diskon = biaya_besar - harga_diskon_besar;
	var harga_besar_ppn = parseInt(harga_besar_stlh_diskon) * ppn;
	var harga_besar_stlh_diskon_ppn = harga_besar_stlh_diskon + harga_besar_ppn;

	$('#biaya_besar2').val(harga_besar_stlh_diskon_ppn);
	$('#hargabeli').val(harga_beli);
	$('#hargabeli_hide').val(harga_beli);
	$('#biaya_obat_sblm_margin').val(harga_beli);
	$('#biaya_kecil').val(biaya_obat);
	$('#biaya_total').val(biaya_total_sblm_diskon_ppn);

	
	var biaya_obat_plus = (margin/100*harga_beli) + harga_beli;
	
	//hrga jual--------------
	$('#biaya_obat').val(biaya_obat_plus);
	$('#biaya_obat_hide').val(biaya_obat_plus);
    // --------------------

	
	var ttl = harga_beli * qty_obat;
	// totalllll
	$('#vtot_x').val(ttl);
	$('#vtot_x_hide').val(ttl);
}

function set_kecil() {
	var qtyb = $('input[name=qtyb]').val();
	//var biaya_obat = $('input[name=biaya_obat]').val();
	var faktor = $('input[name=faktor_satuan]').val();
	var qtyk =qtyb*faktor;

	$('#qty_hide').val(qtyk);
	$('#qty').val(qtyk);
}

function reset() {
	document.getElementById("insert").reset();
	$('#idobat').select2('data', '').change();
	$('#idobat').select2('val','').change();
	$('#idobat').empty().trigger('change');

}

function setTotakhir(){
	var num = parseInt($('#b_tambahan').val()) || 0; 
	var bulat = parseFloat($('#pembulatan').val()) || 0;
	console.log(bulat);

	$('#b_tambahan_hide').val(num);
	$('#pembulatan_hide').val(bulat);
	var total =  parseFloat($('#total_price_awal').val())	
	var hasul_pembulatan = total + (bulat) + num;
	
		$('#total_price').val(hasul_pembulatan);
	
}



</script>
<section class="content-header">
	<?php echo $this->session->flashdata('success_msg');?>
</section>
<?php
include('Frmvdetailpembelian.php');
?>
<section class="content" style="width:97%;margin:0 auto">
 <div class="row">
 <div class="col-lg-12 col-md-12">
  <div class="card">
   <!--  <div class="panel panel-info"> -->

   <?php //if ($role_id == '1026' || $role_id == '1'){?>
     <div class="card-block">
     		<?php echo form_open('logistik_farmasi/Frmcpembelian/insert_pembelian'); ?>
			 					<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_satuan">Produsen/Prinsipal</p>
									<div class="col-sm-4">

										<select id="prinsipal" class="form-control js-example-basic-single" name="prinsipal"  required>
											<option value="">-Pilih-</option>
											<?php
												foreach($produsen as $row){
													echo '<option value="'.$row->id.'">'.$row->nm_produsen.'</option>';
												}
											?>
										</select>
									</div>
								</div>

			 					<div class="form-group row">
									<p class="col-sm-2 form-control-label " id="tindakan">Obat</p>
									<div class="col-sm-4">
									
										<select id="idobat" class="form-control js-example-basic-single" name="idobat" onchange="pilih_tindakan(this.value)" width="100%" required>
											<option value="">-Pilih Obat-</option>
											<?php
												foreach($data_obat as $row){
													echo '<option value="'.$row->id_obat.'">'.$row->nm_obat.'</option>';
												}
											?>
										</select>
									
									</div>
								</div>
								<div class="form-group row">
        							<p class="col-sm-2 form-control-label" id="lnobatch">No Batch</p>
        							<div class="col-sm-4">
          								<input type="text" class="form-control" name="batch_no" id="batch_no" required>
        							</div>
      							</div>
      							<div class="form-group row">
        							<p class="col-sm-2 form-control-label" id="lexpiredate">Expire Date</p>
        							<div class="col-sm-4">
          								<input type="text" id="date_picker" class="form-control" placeholder="Expire Date" name="expire_date" required>
          								<!-- <input type="hidden" class="form-control" name="batch_no" id="batch_no" value="0"> -->
        							</div>
      							</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_satuan">Satuan Besar</p>
									<div class="col-sm-4">

										<select id="satuanb" class="form-control js-example-basic-single" name="satuanb"  required>
											<option value="">-Pilih Satuan-</option>
											<?php
												foreach($data_satuan as $row){
													echo '<option value="'.$row->satuan.'">'.$row->satuan.'</option>';
												}
											?>
										</select>
									</div>
								</div>

								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_satuan">Faktor Satuan</p>
									<div class="col-sm-4">
										<input type="number" class="form-control" value="<?php //echo $satuank ?>" name="faktor_satuan" id="faktor_satuan" onchange="//set_kecil(this.value);set_total(this.value);" required min="1">
										<input type="hidden" class="form-control" value="" name="faktor_satuan_hide" id="faktor_satuan_hide">
									</div>
								</div>

								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_qtyind">Qty Beli Satuan Besar</p>
									<div class="col-sm-4">
										<input type="number" class="form-control" name="qtyb" id="qtyb" min=1 onchange="set_kecil(this.value)">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Harga Beli Satuan Besar</p>
									<div class="col-sm-4">
										<input type="text" class="form-control" value="<?php //echo $biaya_lab; ?>" name="biaya_besar" id="biaya_besar"  onchange="set_total(this.value)" placeholder="Harap isi harga">
										<!-- <input type="hidden" class="form-control" value="" name="biaya_obat_hide" id="biaya_obat_hide"> -->
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_satuan">Satuan Kecil</p>
									<div class="col-sm-4">
										<input type="text" class="form-control" value="" name="satuank" id="satuank" disabled>
										<input type="hidden" class="form-control" value="" name="satuank_hide" id="satuank_hide">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_qtyind">Qty Satuan Kecil</p>
									<div class="col-sm-4">
										<input type="number" class="form-control" name="qty" id="qty" min=1 onchange="set_total(this.value)" disabled>
										<input type="hidden" class="form-control" value="" name="qty_hide" id="qty_hide">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_qtyind">Harga Beli Satuan Kecil</p>
									<div class="col-sm-4">
										<input type="number" class="form-control" name="biaya_kecil" id="biaya_kecil" readonly>
										<input type="hidden" class="form-control" value="" name="biaya_kecil_hide" id="biaya_kecil_hide">
									</div>
								</div>

								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_vtot">Total</p>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="biaya_total" id="biaya_total" readonly>
										<input type="hidden" class="form-control" name="biaya_total_hide" id="biaya_total_hide">
									</div>
								</div>


								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_qtyind">Diskon(%)</p>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="dis" id="dis" value="0"  onchange="set_total(this.value)">
									</div>
								</div>

								

							
								<div class="form-group row">
									<p class="col-sm-2 form-control-label">PPN</p>
									<div class="col-sm-4">
	                                    <input type="radio" id="ppn10" class="with-gap radio-col-blue" value="0"  name="ppn" onclick="set_total()"  checked=""/>
	                                    <label for="ppn10">Include</label>
	                                    &nbsp;
	                                    <input type="radio" id="ppn0" class="with-gap radio-col-blue" value="11" name="ppn" onclick="set_total()" />
	                                    <label for="ppn0" >Not Included</label>
									</div>
								</div>
								
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Harga Beli Satuan Besar (Diskon+ppn)</p>
									<div class="col-sm-4">
										<input type="text" class="form-control" value="<?php //echo $biaya_lab; ?>" name="biaya_besar2" id="biaya_besar2" readonly>
										<!-- <input type="hidden" class="form-control" value="" name="biaya_obat_hide" id="biaya_obat_hide"> -->
									</div>
								</div>

								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_qtyind">Harga Beli Satuan Kecil (Diskon+ppn)</p>
									<div class="col-sm-4">
										<input type="number" class="form-control" name="hargabeli" id="hargabeli" readonly>
										<input type="hidden" class="form-control" value="" name="hargabeli_hide" id="hargabeli_hide">
									</div>
								</div>

								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_vtot">Total Harga Setelah Diskon+PPN</p>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="vtot_x" id="vtot_x" readonly>
										<input type="hidden" class="form-control" name="vtot_x_hide" id="vtot_x_hide">
									</div>
								</div>

								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Harga Sebelum Margin</p>
									<div class="col-sm-4">
										<input type="text" class="form-control" value="<?php //echo $biaya_lab; ?>" name="biaya_obat_sblm_margin" id="biaya_obat_sblm_margin"  readonly>
										
									</div>
								</div>


								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_qtyind">Margin(%)</p>
									<div class="col-sm-4">
										<input type="number" class="form-control" name="margin" onchange="set_total(this.value)" id="margin" value="25" required>
									</div>
								</div>
							
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Harga Jual</p>
									<div class="col-sm-4">
										<input type="text" class="form-control" value="<?php //echo $biaya_lab; ?>" name="biaya_obat" id="biaya_obat" onkeypress="return event.charCode >=48 &amp;&amp; event.charCode <=57" placeholder="Harga akan otomatis terisi" disabled>
										<input type="hidden" class="form-control" value="" name="biaya_obat_hide" id="biaya_obat_hide">
									</div>
								</div>
								
								
								<hr>
								<div class="col-md-10" align="right">
									<button type="reset" class="btn bg-orange" onclick="reset()" value="Reset Form">Reset</button>
									<button type="submit" class="btn btn-primary">Simpan</button>
								</div>
			</div>
							<div class="form-inline" align="right">
								<?php $i="1" ;?>
								<input type="hidden" class="form-control" value="<?php echo $id_receiving;?>" name="receiving_id">
								<input type="hidden" class="form-control" value="<?php echo $no_faktur;?>" name="no_faktur">
								<input type="hidden" class="form-control" value="" name="jenis">
								<input type="hidden" class="form-control" value="<?php echo $i;?>" name="line">
								<input type="hidden" class="form-control" value="<?php echo $receiving_time;?>" name="receiving_time">
								<input type="hidden" class="form-control" value="<?php echo $supplier_id;?>" name="person_id">
								<input type="hidden" class="form-control" value="<?php echo $payment_type;?>" name="payment_type">
								<input type="hidden" class="form-control" value="<?php echo $no_faktur;?>" name="no_faktur">
								<input type="hidden" class="form-control" value="<?php echo $total_price;?>" name="total">
 							</div>
		     </div>
							<?php echo form_close();?>
     </div><!-- end panel body -->
	

   </div><!-- end div id home -->
   
   
   
    <div class="card">
     	<div class="card-block">
    		<div class="form-group row">
    			<div class="table-responsive col-sm-12">
						<table id="tabel_receiving" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
							<tr>
									<th>No</th>
									<th>Item Obat</th>
									<th>No Batch</th>
									<th>Expire Date</th>
									<th>Qty Besar</th>
									<th>Qty Kecil</th>
									<th>Harga Obat (Besar)</th>
									<th>Harga Obat (Kecil)</th>
									<th>Total Harga Obat</th>
									<th>Diskon(%)</th>
									<th>PPN(%)</th>
									<!-- <th>Harga Obat (Besar)</th>
									<th>Harga Obat (Kecil)</th>
									<th>Total</th>
									<th>Harga Sblm Margin</th>
									<th>Margin</th>
									<th>Harga Jual</th> -->
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
									// print_r($pasien_daftar);
									$ppn=10;
										foreach($data_receiving_item as $row){
											$i = 1;
										//$id_pelayanan_poli=$row->id_pelayanan_poli;
									?>
										<tr>
										<td><?php echo $i++ ; ?></td>
											<td><?php echo $row->description ; ?></td>
											<td><?php echo $row->batch_no ; ?></td>
											<td><?php echo $row->expire_date ; ?></td>
											<td><?php echo $row->qtyb ; ?></td>
											<td><?php echo $row->quantity_purchased ; ?></td>
											<td><?php echo $row->biaya_besar ?></td>
											<td> <?= number_format($row->biaya_kecil, '2', ',', '.') ?></td>
											<td><?php echo $row->biaya_total ?></td>
											<td><?php echo $row->discount_percent; ?></td>
											<td> <?php echo $row->ppn_percent  ?> </td>
											<!-- <td><?php //echo $row->biaya_besar2; ?></td>
											<td><?php //echo number_format($row->harga_beli, '2', ',', '.') ?></td>
											<td><?php //echo $row->item_cost_price; ?></td>
											<td><?php //echo number_format($row->harga_sblm_margin, '2', ',', '.') ?></td>
											<td><?php //echo $row->margin_percent; ?></td>
											<td><?php //echo $row->harga_jual; ?></td> -->
											<td>
												<!-- <?php 
												if ($row->verif == null){?>
													<a href="<?php echo site_url("logistik_farmasi/Frmcpembelian/insert_stock_pembelian/".$row->id_receivings_item."/".$row->item_id."/".$row->receiving_id);?>" class="btn btn-success btn-xs">Verif</a>
												<?php }  ?> -->
												<a href="<?php echo site_url("logistik_farmasi/Frmcpembelian/hapus_data_receiving/".$row->id_receivings_item."/".$row->item_id."/".$no_faktur."/".$row->receiving_id);?>" class="btn btn-danger btn-xs">Hapus</a>
											
											</td>

										</tr>
									<?php
										}
									?>
									
							</tbody>
							
						</table>
				</div><br>
						<h4>
								<?php
								$total_akhir_data= 0;
								$total_akhir_data_sblm_diskon_ppn= 0;
                                foreach($data_receiving_item as $data){
									$total_akhir_data_sblm_diskon_ppn += (int)$data->biaya_total;
                                    $total_akhir_data += $data->item_cost_price;
                                }


                                ?>
                               Total Sebelum Diskon+ppn : Rp. <?= number_format($total_akhir_data_sblm_diskon_ppn, '2', ',', '.') ?><br>
							   Total Setelah Diskon+ppn : Rp. <?= number_format($total_akhir_data, '2', ',', '.') ?>
							</h4>
						<?php 
						//if($verif != 1 && $role_id == 1025){
						
						?>
						<div class="col-sm-12">
							<div class="form-inline" style="margin-right:10px;">
								<div class="input-group"><span class="input-group-addon">Rp</span>								
									<input type="text" class="form-control" placeholder="Biaya Tambahan" name="b_tambahan" id="b_tambahan">				
									
									<span class="input-group-btn">
										<button type="btn" class="btn btn-primary" onclick="setTotakhir()">Input</button>
									</span>
								</div>		
							</div><br>

							<div class="form-inline" style="margin-right:10px;">
								<div class="input-group"><span class="input-group-addon">Pembulatan</span>								
									<input type="text" class="form-control" placeholder="0" name="pembulatan" id="pembulatan">				
									
									<span class="input-group-btn">
										<button type="btn" class="btn btn-primary" onclick="setTotakhir()">Input</button>
									</span>
								</div>	
							</div><br>
						</div>
							

						
							<?php echo form_open('logistik_farmasi/Frmcpembelian/insert_verifikasi');?>
							<br><hr>
								<div class="form-inline" style="margin-right:10px;">
										<div class="input-group"><span class="input-group-addon">Total Awal</span>								
											<input type="text" class="form-control" value="<?php echo isset( $total_akhir_data)? $total_akhir_data:''?>" name="total_price_awal" id="total_price_awal">				
										</div>	
								</div><br>

								<div class="form-inline" style="margin-right:10px;">
									<div class="input-group"><span class="input-group-addon">Total Akhir</span>								
										<input type="text" class="form-control" value="<?php echo isset( $total_akhir_data)? $total_akhir_data:''?>" name="total_price" id="total_price">				
									</div>	
								</div><br><br>
								<div class="row g-2" align="right">
									<div class="col">
										<input type="hidden" name="faktur_hidden" value="<?php echo isset($no_faktur)? $no_faktur == null ? $no_do:$no_faktur:'' ?>"></input>
										<input type="hidden" name="receiving_id_hidden" value="<?php echo $id_receiving ; ?>"></input>
										<input type="hidden" class="form-control" name="b_tambahan_hide" id="b_tambahan_hide">
										<input type="hidden" class="form-control" name="pembulatan_hide" id="pembulatan_hide">
										<button class="btn btn-primary" type="submit">Verifikasi (Gudang)</button>
									</div>
							<?php echo form_close(); ?>


							<?php echo form_open('logistik_farmasi/Frmcpembelian/insert_verifikasi_penerima');?>
							
								<div class="col">
									<input type="hidden" name="receiving_id_hidden" value="<?php echo $id_receiving ; ?>"></input>
									<button class="btn btn-primary" type="submit">Verifikasi (Penerima)</button>
								</div>
							<?php echo form_close(); ?>
						</div>
						<?php 

						//}
						?>
						
				
			</div>
  		</div>
 	</div>
	 
 </div>

<?php

    $this->load->view("layout/footer_left");

?>

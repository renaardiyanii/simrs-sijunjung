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
		url:"<?php echo base_url('logistik_farmasi/Frmcpengembalian/get_biaya_obat')?>",
		data: {
			idobat: idobat
		},
		success: function(data){
			
			let html = '';
			console.log(data);
                if(data.length){
					
                    $('#pilihbatch').empty();
                    html+= '<option value="" selected>Pilih Batch</option>';
                    data.map((i)=>{
                        html+= `
                        <option value="${i.id_inventory}">${i.batch_no}</option>
                        `;
						$('#batch_no').val(i.batch_no);
                        console.log(i)
                    })

                    $('#pilihbatch').html(html);
                  
                    // console.log(data)
                        
                }
			
		},
		error: function(){
			alert("error");
		}
    });
}

function set_exp_date(id_inven) {

	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('logistik_farmasi/Frmcpengembalian/get_exp_obat')?>",
		data: {
			id_inven: id_inven
		},
		success: function(data){
			$("#exp_date").val(data.expire_date);
		},
		error: function(){
			alert("error");
		}
    });
	

}

function set_total() {
	var biaya_besar = $('input[name=biaya_besar]').val();
	// check if biaya_besar contains , then remove it
	biaya_besar = biaya_besar.replace(',','');
	
	var faktor = $('input[name=faktor_satuan]').val();
	var qty_obat = $('input[name=qty]').val();
	var qty_obat_besar = $('input[name=qtyb]').val();
	
	var biaya_obat =biaya_besar/faktor;
	var total_obat =biaya_besar * qty_obat_besar;
	$('#biaya_kecil').val(biaya_obat);
	$('#biaya_total').val(total_obat);

}

function set_kecil() {
	var qtyb = $('input[name=qtyb]').val();
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
include('Frmvdetailpengembalian.php');
?>
<section class="content" style="width:97%;margin:0 auto">
 <div class="row">
 <div class="col-lg-12 col-md-12">
  <div class="card">
   <!--  <div class="panel panel-info"> -->

   <?php //if ($role_id == '1026' || $role_id == '1'){?>
     <div class="card-block">
     		<?php echo form_open('logistik_farmasi/Frmcpengembalian/insert_pengembalian'); ?>
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
									<select id="pilihbatch" name="id_inventory" class="form-control" width="100%" onchange="set_exp_date(this.value)">
                                        </select>
										<input type="hidden" id="batch_no" class="form-control" name="batch_no" >	
        							</div>
      							</div>

      							<div class="form-group row">
        							<p class="col-sm-2 form-control-label" id="lexpiredate">Expire Date</p>
        							<div class="col-sm-4">
          								<input type="text" id="exp_date" class="form-control" placeholder="Expire Date" name="expire_date" required>
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
									<p class="col-sm-2 form-control-label" id="lbl_satuan">Satuan Kecil</p>
									<div class="col-sm-4">
										<input type="text" class="form-control" value="" name="satuank" id="satuank" readonly>
										<input type="hidden" class="form-control" value="" name="satuank_hide" id="satuank_hide">
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
									<p class="col-sm-2 form-control-label" id="lbl_qtyind">Qty Satuan Besar</p>
									<div class="col-sm-4">
										<input type="number" class="form-control" name="qtyb" id="qtyb" min=1 onchange="set_kecil(this.value)">
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
									<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Harga Satuan Besar</p>
									<div class="col-sm-4">
										<input type="text" class="form-control" value="<?php //echo $biaya_lab; ?>" name="biaya_besar" id="biaya_besar"  onchange="set_total(this.value)" placeholder="Harap isi harga">
									</div>
								</div>
								
								
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_qtyind">Harga Satuan Kecil</p>
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
							
								<hr>
								<div class="col-md-10" align="right">
									<button type="reset" class="btn bg-orange" onclick="reset()" value="Reset Form">Reset</button>
									<button type="submit" class="btn btn-primary">Simpan</button>
								</div>
			</div>
							<div class="form-inline" align="right">
								<?php $i="1" ;?>
								<input type="hidden" class="form-control" value="<?php echo $id_retur;?>" name="retur_id">
								<input type="hidden" class="form-control" value="<?php echo $no_surat;?>" name="no_surat">
								<input type="hidden" class="form-control" value="<?php echo $return_time;?>" name="retur_time">
								<input type="hidden" class="form-control" value="<?php echo $supplier_id;?>" name="supplier_id">
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
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$ppn=10;
										foreach($data_retur_item as $row){
											$i = 1;
									?>
										<tr>
										<td><?php echo $i++ ; ?></td>
											<td><?php echo $row->nm_obat ; ?></td>
											<td><?php echo $row->batch_no ; ?></td>
											<td><?php echo $row->expire_date ; ?></td>
											<td><?php echo $row->qty_besar ; ?></td>
											<td><?php echo $row->qty_kecil ; ?></td>
											<td><?php echo $row->harga_besar ?></td>
											<td> <?= number_format($row->harga_kecil, '2', ',', '.') ?></td>
											<td><?php echo $row->total ?></td>
											<td>
												<!-- <?php 
												if ($row->verif == null){?>
													<a href="<?php echo site_url("logistik_farmasi/Frmcpembelian/insert_stock_pembelian/".$row->id_retur_items."/".$row->id_obat."/".$row->receiving_id);?>" class="btn btn-success btn-xs">Verif</a>
												<?php }  ?> -->
												<a href="<?php echo site_url("logistik_farmasi/Frmcpengembalian/hapus_data_retur/".$row->id_retur_items."/".$row->id_obat."/".$row->retur_id);?>" class="btn btn-danger btn-xs">Hapus</a>
											
											</td>

										</tr>
									<?php
										}
									?>
									
							</tbody>
							
						</table>
				</div><br><br>
						<h4>
								<?php
								$total_akhir_data= 0;
							
                                foreach($data_retur_item as $data){
                                    $total_akhir_data += $data->total;
                                }


                                ?>
                               
							   Total : Rp. <?= number_format($total_akhir_data, '2', ',', '.') ?>
							</h4>
						<?php 
						//if($verif != 1 && $role_id == 1025){
						
						?>
						<div class="col-sm-12">
							<!-- <div class="form-inline" style="margin-right:10px;">
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
							</div><br> -->
						</div>
						
							<?php echo form_open('logistik_farmasi/Frmcpengembalian/insert_verifikasi_pengembalian');?>
							<br><hr>
						
								<div class="row">
									<div class="col">
										<input type="hidden" name="faktur_hidden" value="<?php echo isset($no_surat)? $no_surat:'' ?>"></input>
										<input type="hidden" name="retur_id_hidden" value="<?php echo $id_retur ; ?>"></input>
										<button class="btn btn-primary" type="submit">Verifikasi</button>
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
<script>
	// Jquery Dependency

$("#biaya_besar").on({
    keyup: function() {
      formatCurrency($(this));
    },
    blur: function() { 
      formatCurrency($(this), "blur");
    }
});


function formatNumber(n) {
  // format number 1000000 to 1,234,567
  return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}


function formatCurrency(input, blur) {
  // appends $ to value, validates decimal side
  // and puts cursor back in right position.
  
  // get input value
  var input_val = input.val();
  
  // don't validate empty input
  if (input_val === "") { return; }
  
  // original length
  var original_len = input_val.length;

  // initial caret position 
  var caret_pos = input.prop("selectionStart");
    
  // check for decimal
  if (input_val.indexOf(".") >= 0) {

    // get position of first decimal
    // this prevents multiple decimals from
    // being entered
    var decimal_pos = input_val.indexOf(".");

    // split number by decimal point
    var left_side = input_val.substring(0, decimal_pos);
    var right_side = input_val.substring(decimal_pos);

    // add commas to left side of number
    left_side = formatNumber(left_side);

    // validate right side
    right_side = formatNumber(right_side);
    
    // On blur make sure 2 numbers after decimal
    if (blur === "blur") {
      right_side += "00";
    }
    
    // Limit decimal to only 2 digits
    right_side = right_side.substring(0, 2);

    // join number by .
    input_val = left_side + "." + right_side;

  } else {
    // no decimal entered
    // add commas to number
    // remove all non-digits
    input_val = formatNumber(input_val);
    input_val = input_val;
    
    // final formatting
    if (blur === "blur") {
      input_val += ".00";
    }
  }
  
  // send updated string to input
  input.val(input_val);

  // put caret back in the right position
  var updated_len = input_val.length;
  caret_pos = updated_len - original_len + caret_pos;
  input[0].setSelectionRange(caret_pos, caret_pos);
}



</script>
<?php

    $this->load->view("layout/footer_left");

?>

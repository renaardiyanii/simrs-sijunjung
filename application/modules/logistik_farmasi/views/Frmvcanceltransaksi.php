<?php
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_horizontal");
}
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
			//alert(data);
			// $('#biaya_obat').val(data[0].hargabeli);
			// $('#biaya_obat_hide').val(data[0].hargabeli);
			$('#qty').val('1');
			$('#faktor_satuan').val(data[0].faktorsatuan);
			$('#satuank').val(data[0].satuank);
			$('#satuanb').val(data[0].satuanb);
			set_total() ;
		},
		error: function(){
			alert("error");
		}
    });
}

function set_total() {
	var biaya_besar = $('input[name=biaya_besar]').val();
	var ppn =  $('input[name=ppn]:checked').val()/100;
	// var biaya_obat = $('input[name=biaya_obat]').val();
	var faktor = $('input[name=faktor_satuan]').val();
	var margin = $('input[name=margin]').val();
	var biaya_obat =biaya_besar/faktor;
	var biaya_obat_plus = (margin/100*biaya_obat) + biaya_obat;
	var biaya_obat_plus_margin = (10/100*biaya_obat_plus) + biaya_obat_plus;
	$('#biaya_obat').val(biaya_obat_plus_margin);
	$('#biaya_obat_hide').val(biaya_obat_plus_margin);
	var qty_obat = $('input[name=qty]').val();
	var dis = $('input[name=dis]').val();
	var totdis = dis/100;
	var ttl = biaya_obat * qty_obat;
	var ttot =ttl;
	var tot =ttot*totdis;
	var totppn =(ttot-tot)*ppn;
	var total =ttot-tot+totppn;
	// var total =biaya_obat;
	$('#vtot_x').val(total);
	$('#vtot_x_hide').val(total);
}

function set_kecil() {
	var qtyb = $('input[name=qtyb]').val();
	// var biaya_obat = $('input[name=biaya_obat]').val();
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
     <div class="card-block">
     
     </div><!-- end panel body -->
   </div><!-- end div id home -->   
    <div class="card">
     	<div class="card-block">
    		<div class="form-group row">
    			<div class="col-sm-12">
						<table id="tabel_receiving" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<!-- <th>No</th> -->
									<th>Item Obat</th>
									<th>Qty</th>
									<th>Harga Obat</th>
									<th>PPN(%)</th>
									<th>Diskon(%)</th>
									<th>Total</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
									// print_r($pasien_daftar);
									$ppn=10;
										foreach($data_receiving_item as $row){
										//$id_pelayanan_poli=$row->id_pelayanan_poli;
									?>
										<tr>
											<!-- <td><?php echo $i++ ; ?></td> -->
											<td><?php echo $row->description ; ?></td>
											<td><?php echo $row->quantity_purchased ; ?></td>
											<td><?php echo ($row->item_cost_price/$row->quantity_purchased); ?></td>
											<td><?php echo $row->ppn_percent ?></td>
											<td><?php echo $row->discount_percent; ?></td>
											<td><?php echo $row->item_cost_price; ?></td>
											<td><a href="<?php echo site_url("logistik_farmasi/Frmccancelpembelian/hapus_data_receiving/".$row->id_receivings_item."/".$row->item_id."/".$no_faktur."/".$row->receiving_id);?>" class="btn btn-danger btn-xs">Hapus</a></td>

										</tr>
									<?php
										}
									?>
							</tbody>
						</table>
				
						<!-- <?php echo form_open('logistik_farmasi/Frmcpembelian/faktur_pembelian');?>
						<br><hr>
							<div class="col-md-12" align="right">
									<input type="hidden" name="faktur_hidden" value="<?php echo $no_faktur ; ?>"></input>
									<input type="hidden" name="receiving_id_hidden" value="<?php echo $id_receiving ; ?>"></input>
									<button class="btn btn-primary" type="submit">Selesai & Cetak</button>
							</div>
						<?php echo form_close(); ?> -->
				</div>
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

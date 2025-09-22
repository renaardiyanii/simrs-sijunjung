<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
?>
<html>
<script type='text/javascript'>
//-----------------------------------------------Data Table
$(document).ready(function() {
    $('#example').DataTable({
    	"pageLength":100
    });
    $("#warn_kartu").hide();
	$('#input_kontraktor').hide();
} );
//---------------------------------------------------------

$(function() {
$('#date_picker').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});  
		

});

// var intervalSetting = function () {
// 		location.reload();
// 	};
// setInterval(intervalSetting, 60000);
</script>
<script type='text/javascript'>

function edit_cara_bayar(no_register) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('irj/rjcpelayanan/get_data_by_register')?>",
      data: {
        no_register: no_register
      },
      success: function(data){
        $('#no_reg_hidden').val(data[0].no_register);
        $('#no_reg').val(data[0].no_register);
        $('#nm_pasien').val(data[0].nama);
        $('#cara_bayar').val(data[0].cara_bayar).change();
      },
      error: function(){
        alert("error");
      }
    });
  }
var ajaxku;
var site = "<?php echo site_url();?>";
function pilih_cara_bayar(val_cara_bayar){
	if(val_cara_bayar=='KERJASAMA'){
		$('#input_kontraktor').show();
		document.getElementById("id_kontraktor").required = false;
		ajaxku = buatajax();
	    var url="<?php echo site_url('irj/rjcregistrasi/data_kontraktor'); ?>";
	    url=url+"/"+val_cara_bayar;
	    url=url+"/"+Math.random();
	    ajaxku.onreadystatechange=stateChangedKontraktor;
	    ajaxku.open("GET",url,true);
	    ajaxku.send(null);

	} else if(val_cara_bayar=='BPJS'){
		$('#input_kontraktor').show();
		document.getElementById("id_kontraktor").required = true;
		ajaxku = buatajax();
	    var url="<?php echo site_url('irj/rjcregistrasi/data_kontraktor_bpjs'); ?>";
	    url=url+"/"+val_cara_bayar;
	    url=url+"/"+Math.random();
	    ajaxku.onreadystatechange=stateChangedKontraktor;
	    ajaxku.open("GET",url,true);
	    ajaxku.send(null);

	
	}else{
		$('#input_kontraktor').hide();
		document.getElementById("id_kontraktor").required = false;
	}
}
function buatajax(){
    if (window.XMLHttpRequest){
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}
function stateChangedKontraktor(){
    var data;
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("id_kontraktor").innerHTML = data;
		}
    }
}

$(document).on("submit","#form_cara_bayar",function(e){
			e.preventDefault();
			document.getElementById("btn-form-cara-bayar-update").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
			$.ajax({  
				url:"<?php echo base_url(); ?>irj/rjcpelayanan/edit_cara_bayar/",                         
				method:"POST",  
				data:new FormData(this),  
				contentType: false,  
				cache: false,  
				processData:false,  
				success: function(data)  
				{ 
					document.getElementById("form_cara_bayar").reset();
					new swal({
									title: "Selesai",
									text: "Data berhasil disimpan",
									type: "success",
									showCancelButton: false,
									closeOnConfirm: false,
									showLoaderOnConfirm: true
								},
								function () {
									window.location.reload();
								});
					
					
				},
				error:function(event, textStatus, errorThrown) {
					swal("Error","Data gagal disimpan.", "error"); 
					console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
				}  
        	}); 
		})  
</script>

	<section class="content-header">
			<?php
				echo $this->session->flashdata('success_msg');
				echo $this->session->flashdata('notification');				
				echo $this->session->flashdata('notification_sep');				
			?>
				
			</section>
			<section class="content">
			<div class="row">			
		    	<div class="col-lg-12 col-md-12">
		       	  <div class="card">
					<div class="card-block p-b-20">


						<table class="table table-bordered">
						<thead>
							<tr>
								<th>Aksi</th>
								<th>No Antrian</th>
								<th>Tanggal Kunjungan</th>
								<th>No Medrec</th>
								<th>No Registrasi</th>
								<th>Nama</th>
								<th>Status</th>
								<th>Kelas</th>
									
							</tr>
						</thead>
						<tbody>
						<?php
								// print_r($pasien_daftar);
								$i=1;
									foreach($pasien_daftar as $row){
									$no_register=$row->no_register;	
							?>
							<tr>
								<td>
									<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal" onclick="edit_cara_bayar('<?php echo $row->no_register;?>')"><span> Edit Cara Bayar</span></button>
								</td>
								<td><?php echo $row->no_antrian;?></td>
								<td><?php echo date("d-m-Y", strtotime($row->tgl_kunjungan)).' | '.date("H:i", strtotime($row->tgl_kunjungan));?></td>
								<td><?php echo $row->no_cm;?></td>
								<?php if($row->cara_bayar=='UMUM' and $row->unpaid>0 ){
									?>
								<td style="color: red !important;"><?php echo $row->no_register;?></td>
									<?php } else {?>
								<td><?php echo $row->no_register;?></td>
									<?php }?>
								<td><?php echo strtoupper($row->nama);?> </td>
								<td>
									<?php 
									if ($row->cara_bayar == 'KERJASAMA'){
										echo strtoupper($row->nm_kontraktor);
									}else{
										echo strtoupper($row->cara_bayar);
									}	
								?>
								</td>
								<td><?php echo $row->kelas_pasien;?></td>
								
							</tr>
							<?php } ?>
						</tbody>
						</table>							
							</div>
						</div>
					</div>

					<!-- Modal Edit Status-->
					<!-- <?php echo form_open('irj/rjcpelayanan/edit_cara_bayar');?> -->
	<form method="POST" id="form_cara_bayar" class="form-horizontal">				
		<div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Rubah Cara Bayar</h4>
                </div>
                <div class="modal-body">
                <input type="hidden" class="form-control" name="no_reg_hidden" id="no_reg_hidden">
                  
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nama">No Register</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="no_reg" id="no_reg" disabled>
                    </div>
                  </div>

                <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nama">Nama Pasien</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="nm_pasien" id="nm_pasien" disabled>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nama">Cara Bayar</p>
                    <div class="col-sm-6">
                      	<select id="cara_bayar" class="form-control" style="width: 100%" name="cara_bayar" onChange="pilih_cara_bayar(this.value)" required>
							<option value="">-Pilih Cara Bayar-</option>
								<?php
									foreach($cara_bayar as $row){
										echo '<option value="'.$row->cara_bayar.'">'.$row->cara_bayar.'</option>';
									}
								?>
						</select>
                    </div>
                  </div>

                  <div class="form-group row" id="input_kontraktor">
                  				<div class="col-sm-1"></div>
									<p class="col-sm-3 control-label" id="lbl_input_kontraktor">Dijamin Oleh</p>
									<div class="col-sm-6">
										<div class="form-inline">
												<select id="id_kontraktor" class="form-control select2" style="width: 100%" name="id_kontraktor">
													<option value="">-Pilih Penjamin-</option>
													
												</select>
										</div>
									</div>
								</div>
				</div>

                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-form-cara-bayar-update">Edit</button>
                </div>
            </div>
          </div>
		</form>  
          </div>
			</section>
<?php
	$this->load->view('layout/footer_left.php');
?>	

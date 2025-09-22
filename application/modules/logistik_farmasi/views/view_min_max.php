<?php
    $this->load->view("layout/header_left");

?>
<style>
hr {
	border-color:#7DBE64 !important;
}

/* thead {
	/* background: #c4e8b6 !important;
	color:#4B5F43 !important;
	background: -moz-linear-gradient(top,  #c4e8b6 0%, #7DBE64 100%) !important;
	background: -webkit-linear-gradient(top,  #c4e8b6 0%,#7DBE64 100%) !important;
	background: linear-gradient(to bottom,  #c4e8b6 0%,#7DBE64 100%) !important;
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#c4e8b6', endColorstr='#7DBE64',GradientType=0 )!important; */
/* }  */
</style>	

<script type='text/javascript'>
	$(document).ready(function () {
        var dataTable = $('#dataTables-example').DataTable( {
			
		});
        $('.datatable').DataTable({});
        //$('.datatables').DataTable();	
		$('#tgl').daterangepicker({
          	opens: 'left',
			format: 'DD/MM/YYYY',
			startDate: moment('<?= $tgl_awal ?>'),
          	endDate: moment('<?= $tgl_akhir ?>'),
		});
    });
	function download(){
		swal({
		  title: "Download?",
		  text: "Download !",
		  type: "warning",
		  showCancelButton: true,
	  	  showLoaderOnConfirm: false,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Ya!",
		  cancelButtonText: "Tidak!",
		  closeOnConfirm: false,
		  closeOnCancel: false
		},
		function(isConfirm){
		  if (isConfirm) {
			swal("Download", "Sukses", "success");
			window.open("<?php echo base_url('logistik_farmasi/frmclaporan/download_peneriamaan_obat/'.$supplier.'/'.$jenis.'/'.$jenis_obat.'/'.$tgl_awal.'/'.$tgl_akhir)?>");
		  } else {
		    swal("Close", "Tidak Jadi", "error");
			document.getElementById("ok1").checked = false;
		  }
		});
	}	

    function cek_tgl_awal(tgl_awal){
		//var tgl_akhir=document.getElementById("date_picker2").value;
		var tgl_akhir=$('#date_picker2').val();
		if(tgl_akhir==''){
		//none :D just none
		}else if(tgl_akhir<tgl_awal){
			$('#date_picker2').val('');
			//document.getElementById("date_picker2").value = '';
		}
	}
	function cek_tgl_akhir(tgl_akhir){
		//var tgl_awal=document.getElementById("date_picker1").value;
		var tgl_awal=$('#date_picker1').val();
		if(tgl_akhir<tgl_awal){
			$('#date_picker1').val('');
			//document.getElementById("date_picker1").value = '';
		}
	}
</script>
<!-- <div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <form method="post" action="<?= base_url('logistik_farmasi/Frmclaporan/fast_moving_search') ?>">

                    <div class="row">

                            <div style="margin-left:10px;margin-right:10px;margin-top:5px">Tanggal :</div>

                            <div class="form-group col-md-3">
                                <input type="date" id="date_picker1" class="form-control" placeholder="Pilih Tanggal" name="tgl_awal" onchange="cek_tgl_awal(this.value)" required>
                            </div>

                            <div class="form-group col-md-3">
                                <input type="date" id="date_picker2" class="form-control" placeholder="Tanggal Akhir" name="tgl_akhir" onchange="cek_tgl_akhir(this.value)" required>
                            </div>

                            
                    </div>

                    <div class="row">    
                        <div style="margin-left:10px;margin-right:10px;margin-top:5px">Kategori :</div>                
                        <div class="form-group col-md-3">
                            <select name="kategori" id="filter" class="form-control">
                                <option value="" selected="">---- Pilih Kategori ----</option>
                                <option value="semua" >Semua</option>
                                <option value="Fast Moving" >Fast Moving</option>
                                <option value="Medium Moving" >Medium Moving</option>
                                <option value="Slow Moving" >Slow Moving</option>
                                <option value="Dead" >Dead</option>
                               
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                       
                            <span class="input-group-btn">
                                <button class="btn btn-primary pull-right" type="submit">Lihat</button>
                            </span>
                        </div>              
                    </div>
                   
                    
               
                </form>
            </div>
        </div>
    </div>
</div> -->

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
        <div class="card-header">
            <div class="row">
              <div class="col-xs-9" id="alertMsg">  
                    <?php echo $this->session->flashdata('alert_msg'); ?>
              </div>
            </div>
        </div>
        <div class="card-block">
            <!-- <div class="modal-body table-responsive"> -->
            <table class=" datatable table  table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Tgl Hitung Terakhir</th>
                    <th>Nama Obat</th>
                    <th>Minimum Stock</th>
                    <th>Maximum Stock</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $index=1; foreach ($data_stock as $val):?>
                      <tr>
                          <td><?= $index ?></td>
                          <td><?= $val->tgl_update_terakhir ?></td>
                          <td><?= $val->nm_obat ?></td>
                          <td><?= $val->min_stock ?></td>
                          <td><?= $val->max_stock ?></td>
                         
                    <?php $index++; endforeach; ?>
                  </tbody>
                </table>        
            <!-- </div> -->
        </div>
        </div>
    </div>
</div>
<script>
	$(document).ready(function() {
		var dataTable = $('#dataTables-example').DataTable( {
			
		});
    $('.datatable').DataTable({});
	});
</script>
<?php

    $this->load->view("layout/footer_left");

?>

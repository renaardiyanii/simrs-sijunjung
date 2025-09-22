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
        // var dataTable = $('#dataTables-example').DataTable( {
			
		// });
        // $('.datatable').DataTable({});
        //$('.datatables').DataTable();	
      
        $('#example').DataTable();
      

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


<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <?php 
                $bulan_now = date('Y-m');
                ?>
               <a href="<?php echo site_url('irj/Rjclaporan/monitoring_jmlh_bed/'.$bulan_now);?>">
                <input type="button" class="btn" style="background-color: blue;color:white;margin:5px" value="GENERATE BED"></a>

                <a href="<?php echo site_url('irj/Rjclaporan/bor_los_toi_ruangan/');?>">
                <input type="button" class="btn" style="background-color: green;color:white;margin:5px" value="KEMBALI"></a>
            </div>
        </div>
    </div>
</div>


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
                <!-- <h4 align="center" style="font-weight:bold">PELAYANAN RAWAT INAP</h4></div> -->
                    <div class="table-responsive col-sm-12">
                        <center><h4><b>MENGHITUNG JUMLAH BED</b></h4></center>
                        <table  id="example_rg" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Tanggal Update</th>
                                    <th>ruang</th>
                                    <th>kelas</th>
                                    <th>Jmlh Bed</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data_bed as $val){ ?>
                                    <tr>
                                        <td><?= date('d-m-Y',strtotime($val->tgl_update)) ?></td>
                                        <td><?= $val->ruangan ?></td>
                                        <td><?= $val->kelas ?></td>
                                        <td><?= $val->bed ?></td>
                                    </tr>
                              
                                <?php } ?>
                            </tbody>
                        </table>
                        <div style="margin-right:1000px">
                        </div>
                    </div>     
                <!-- <a href="<?php echo site_url('irj/Rjclaporan/excel_bor_los_toi_new/'.$bulannow);?>">
                <input type="button" class="btn" style="background-color: lime;color:white;margin:5px" value="EXCEL"></a> -->
            </div>
        </div>
    </div>
</div>






<script>
	$(document).ready(function() {
		var dataTable = $('#dataTables-example').DataTable( {
			
		});
    $('.datatable').DataTable({});
    $('#example_rg').DataTable();
   
	});
</script>
<?php

    $this->load->view("layout/footer_left");

?>

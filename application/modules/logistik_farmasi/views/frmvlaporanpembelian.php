<?php
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_horizontal");
}
?>
<style>
hr {
	border-color:#7DBE64 !important;
}

thead {
	background: #c4e8b6 !important;
	color:#4B5F43 !important;
	background: -moz-linear-gradient(top,  #c4e8b6 0%, #7DBE64 100%) !important;
	background: -webkit-linear-gradient(top,  #c4e8b6 0%,#7DBE64 100%) !important;
	background: linear-gradient(to bottom,  #c4e8b6 0%,#7DBE64 100%) !important;
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#c4e8b6', endColorstr='#7DBE64',GradientType=0 )!important;
}
</style>	

<script type='text/javascript'>
	$(document).ready(function () {	
		$('#tanggal_laporan').daterangepicker({
          	opens: 'left',
			format: 'DD/MM/YYYY',
			startDate: moment(),
          	endDate: moment(),
		});
    });
    function lihat(){
        var table;    
        var startDate = $('#tanggal_laporan').data('daterangepicker').startDate;
        var endDate = $('#tanggal_laporan').data('daterangepicker').endDate;
        startDate = startDate.format('YYYY-MM-DD');
        endDate = endDate.format('YYYY-MM-DD');
        var filter = $("#filter").val();
        table = $('#table').DataTable();
        $.ajax({
           // url:  "<?php // echo site_url('logistik_farmasi/Frmclaporan/lihat_pembelian'); ?>/"+startDate+"/"+endDate+"/"+filter,
           url:  "<?php echo site_url('logistik_farmasi/Frmclaporan/lihat_pembelian'); ?>/"+startDate+"/"+endDate,
            type: 'POST',
            dataType: "json",
            success: function (response) {
                table.clear().draw();
                table.rows.add(response);
                table.columns.adjust().draw();
            }
        });
        
    }
	function download(){	
		var startDate = $('#tanggal_laporan').data('daterangepicker').startDate;
		var endDate = $('#tanggal_laporan').data('daterangepicker').endDate;
		startDate = startDate.format('YYYY-MM-DD');
		endDate = endDate.format('YYYY-MM-DD');
        var filter = $("#filter").val();
		
		swal({
		  title: "Download?",
		  text: "Download Laporan Pembelian Obat!",
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
			window.open("<?php echo base_url('logistik_farmasi/frmclaporan/download_pembelian')?>/"+startDate+"/"+endDate+"/"+filter);
		  } else {
		    swal("Close", "Tidak Jadi", "error");
			document.getElementById("ok1").checked = false;
		  }
		});
		
		
	}	
</script>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <?php echo $message_nodata; ?>
                <form class="form-material m-t-40 row">
                    <!-- <div class="form-group col-md-4 m-t-10">
                        <label>Filter Faktur Berdasarkan</label>
                    </div> -->
                    <!-- <div class="form-group col-md-8 m-t-10">
                        <select name="filter" id="filter" class="form-control" style="width:100%" required="">
                            <option value="" selected="">---- Pilih Semua ----</option>
                            <option value="BPJS">BPJS</option>
                            <option value="Umum">Umum</option>
                        </select>
                    </div> -->
                    <div class="form-group col-md-10 m-t-10">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>&nbsp;&nbsp;
                            <input type="text" class="form-control pull-right" id="tanggal_laporan" name="tanggal_laporan">
                        </div>
                    </div>
                    <div class="form-group col-md-2 m-t-10">
                        <span class="input-group-btn">
                            <!-- <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit">Cari</button> -->
                            <button class="btn btn-primary pull-right" type="button" onclick="lihat()">lihat</button>
                            <button class="btn btn-primary pull-right" type="button" onclick="download()">Download</button>
                        </span>
                    </div>
                </form>
            </div>

            <div class="card-block">
                <div class="modal-body">

                </div>
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
            <div class="modal-body">
                <table id="table" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                  <thead>
                  <tr>
                    <th>ID PO</th>
                    <th>No. PO</th>
                    <th>Tgl PO</th>
                    <th>Supplier</th>
                    <th>Sumber Dana</th>
                    <th>User</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                </table>        
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

<?php
  $this->load->view('layout/header_left.php');
?>
<script type='text/javascript'>
  $(document).ready(function() {  
    $('#detailModal').on('shown.bs.modal', function(e) {
      var id = $(e.relatedTarget).data('id');
      var nm = $(e.relatedTarget).data('nmps');
      var tgl = $(e.relatedTarget).data('tgl');
      $('#nm').html(nm);
      // console.log(nm);
      // console.log(id);
      $.ajax({
        dataType: "json",
        type: 'POST',
        data: {id:id, tgl:tgl},
        url: "<?php echo site_url(); ?>logistik_farmasi/Frmchistory/get_history_detail",
        success: function( response ) {
          tablePengeluaran.clear().draw();
          tablePengeluaran.rows.add(response.data);
          tablePengeluaran.columns.adjust().draw();

          // $("#totals").html('<h3>' + response.total + '</h3>');
        }
      }); 
    });

    tablePengeluaran = $('#tablePengeluaran').DataTable({
      columns: [
        { data: "tgl_kunjungan" },
        { data: "nama_obat" },
        { data: "qty" },
        { data: "signa" }
      ],
      paging: true,
      bDestroy: true,
      bSort: false,
      order:  [[ 2, "asc" ]]
    });

    $('.datepicker').datepicker({
    format: "yyyy-mm-dd",
    endDate: '0',
    autoclose: true,
    todayHighlight: true
    });  
  });

  $(document).on('click', '#btnCari', function() {
    $('#btnCari').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
    refreshList();
  });

  $(function(){
    table = $('#example').DataTable({
      ajax: "<?php echo site_url(); ?>logistik_farmasi/frmchistory/get_data_pasien",
      columns: [
        { data: "tgl_kunjungan" },
        { data: "no_medrec" },
        { data: "nama" },
        { data: "poli" },
        { data: "aksi" }
      ],
      columnDefs: [
        { targets: [ 0 ], visible: true }
      ],
      // searching: true,
      paging: true,
      bDestroy : true,
      bSort : false,
      "lengthMenu": [[50, 75, 100, -1], [50, 75, 100, "All"]]
    });
   });

   function refreshList(){
    $.ajax({
        url: '<?php echo site_url(); ?>logistik_farmasi/frmchistory/get_data_pasien',
        type: 'POST',
        data: $('#formtgl').serialize(),
        dataType: "json",
        success: function (response) {
          $('#btnCari').html('<i class="fa fa-search"></i> Cari');
          //alert(JSON.stringify(response.data));
          table.clear().draw();
          table.rows.add(response.data);
          table.columns.adjust().draw(); 
        }
    });
   }
</script>

<div class="row">
	<div class="col-lg-12 col-md-12">	
	<div style="background: #e4efe0">
		<div class="inner">
			<div class="container-fluid"><br>
        <form id='formtgl'>
				<div class="form-group row">
          <label class="col-sm-2 control-label">Periode Tanggal</label>
          <div class="col-sm-2">
            <input type="text" class="form-control datepicker" name="tgl0" id="tgl0" >
          </div>
          <label class="col-sm-1 control-label">s/d</label>
          <div class="col-sm-2">
            <input type="text" class="form-control datepicker" name="tgl1" id="tgl1" >
          </div>
          <div class="col-sm-2">
            <button type="button" id="btnCari" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Cari</button>
          </div>
		    </div>
        </form>		
			</div>
		</div>
	</div>
	</div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12">
      <div class="card-title"></div>
      <div class="card">
        <div class="card-block">
            <div class="modal-body">
				<table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th style="text-align: center;">Tgl Kunjungan</th>
						<th style="text-align: center;">No Medrec</th>
						<th style="text-align: center;">Nama Pasien</th>
						<th style="text-align: center;">Asal Poli / Ruang</th>
						<th style="text-align: center;">Aksi</th>
					</tr>
        </thead>        
				</table>		
			</div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="detailModal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-default modal-lg">

	  <!-- Modal content-->
	  <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Riwayat Obat <span id="nm"></span></h4>
	    </div>
	    <div class="modal-body table-responsive">
	      <table id="tablePengeluaran" class="display nowrap table table-hover table-bordered table-striped">
	        <thead>
	          <tr>
	            <th><p align="center">Tanggal Berobat</p></th>
	            <th><p align="center">Nama Obat</p></th>
	            <th><p align="center">Qty</p></th>
              <th><p align="center">Penggunaan</p></th>
	          </tr>
	        </thead>
	      </table>
	    </div>
	    <!-- TOTAL : <p id="totals"></p> -->
	    <div class="modal-footer">
	      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	    </div>
	  </div>
	</div>
	</div>
</div>


<?php
  $this->load->view('layout/footer_left.php');
?>
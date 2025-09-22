<?php
  $this->load->view('layout/header_left.php');
?>
<script type='text/javascript'>
  $(document).ready(function() {
    $('#example').DataTable({
      "iDisplayLength": 100
    });
    
    $('#detailModal').on('shown.bs.modal', function(e) {
      var id = $(e.relatedTarget).data('id');
      var nm = $(e.relatedTarget).data('nmobat');
      $('#nm').html(nm);
      // console.log(nm);
      // console.log(id);
      $.ajax({
        dataType: "json",
        type: 'POST',
        data: {id:id},
        url: "<?php echo site_url(); ?>logistik_farmasi/Frmcexpendobat/get_detail_pengeluaran",
        success: function( response ) {
          tablePengeluaran.clear().draw();
          tablePengeluaran.rows.add(response.data);
          tablePengeluaran.columns.adjust().draw();

          $("#totals").html('<h3>' + response.total + '</h3>');
        }
      }); 
    });

    tablePengeluaran = $('#tablePengeluaran').DataTable({
      columns: [
        { data: "nama" },
        { data: "qty" },
        { data: "tanggal" }
      ],
      "iDisplayLength": 100,
      bFilter: true,
      bPaginate: true,
      destroy: true,
      order:  [[ 2, "asc" ]]
    });

    $('.datepicker').datepicker({
    format: "yyyy-mm-dd",
    endDate: '0',
    autoclose: true,
    todayHighlight: true
    });  
  });
</script>

<div class="row">
	<div class="col-lg-12 col-md-12">	
	<div style="background: #e4efe0">
		<div class="inner">
			<div class="container-fluid"><br>
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
		                <button type="button" id="btnCari" class="btn btn-primary pull-right">Cari</button>
		              </div>
		        </div>		
			</div>
		</div>
	</div>
	</div>
</div>
<br><br>
<div class="row">
    <div class="col-lg-12 col-md-12">
      <div class="card">
        <div class="card-block">
            <div class="modal-body">
				<table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th style="text-align: center;">No</th>
						<th style="text-align: center;">Nama</th>
						<th style="text-align: center;">Stock Awal</th>
						<th style="text-align: center;">Pemakaian</th>
						<th style="text-align: center;">Stock Akhir</th>
						<th style="text-align: center;">Action</th>
					</tr>
                </thead>
                <tbody id="bodyt">
                  <?php
                      $i=1;
                      foreach($obat as $row){
                  ?>
                  <tr>
                    <td><?php echo $i++;?></td>
                    <td><?php echo $row->nama;?></td>
                    <td>
                      <?php 
                        if($row->stock == 0){
                          echo "0";
                        }else{
                          echo $row->stock;
                        }
                      ?>  
                    </td>
                    <td><?php 
                        if($row->pemakaian == 0){
                          echo "0";
                        }else{
                          
                          echo $row->pemakaian;
                        }?></td>
                    <td><?php echo $row->stock - $row->pemakaian;?></td>
                    <td>
                      <center><button class="btn btn-primary pull-right" data-toggle="modal" data-target="#detailModal" data-id="<?php echo $row->id;?>" data-nmobat="<?php echo $row->nama;?>">Detail Pengeluaran</button></center>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
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
	      <h4 class="modal-title">Pengeluaran Obat <span id="nm"></span></h4>
	    </div>
	    <div class="modal-body table-responsive">
	      <table id="tablePengeluaran" class="display nowrap table table-hover table-bordered table-striped table-responsive" cellspacing="0" width="100%">
	        <thead>
	          <tr>
	            <th><p align="center">Nama pasien</p></th>
	            <th><p align="center">Qty Obat</p></th>
	            <th><p align="center">Tanggal</p></th>
	          </tr>
	        </thead>
	      </table>
	    </div>
	    TOTAL : <p id="totals"></p>
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
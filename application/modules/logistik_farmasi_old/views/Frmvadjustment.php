<?php
  $this->load->view('layout/header_left.php');
?>
<script>

  function distribusi(id_inventory) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('logistik_farmasi/Frmcadjustment/get_data_detail_retur')?>",
      data: {
        id_inventory : id_inventory
      },
      success: function(data){  
        $("#id_gudang option").attr("disabled", false);
       
        $('#edit_batch_no_dis').val(data[0].batch_no);
        $('#edit_batch_no').val(data[0].batch_no);
        $('#id_inventory').val(data[0].id_inventory);
        $('#edit_id_obat_dis').val(data[0].id_obat);
        $('#edit_id_obat').val(data[0].id_obat);
        $('#id_obat').val(data[0].id_obat);
        $('#id_gudang_awal').val(data[0].id_gudang);
        $('#edit_description_dis').val(data[0].nm_obat);
        $('#edit_description').val(data[0].nm_obat);
        $('#edit_qty_dis').val(data[0].qty);
        $('#edit_qty').val(data[0].qty);
         $('#edit_expire_dis').val(data[0].expire_date);
         $('#edit_expire').val(data[0].expire_date);
         $("#id_gudang option[value='"+data[0].id_gudang+"']").attr("disabled", true);
         $('#qty_adjustment').val('');
		
        //alert(data[0].id_gudang);

      },
      error: function(){
        alert("error");
      }
    });
  } 
  function hapus(id_inventory) {
	$( "#dialog-confirm" ).html("Anda yakin akan menghapus data obat?");
	$( "#dialog-confirm" ).dialog({
	  resizable: false,
	  modal: true,
	  buttons: {
		"Ya": function() {					  
			$.ajax({
				data: {id:id_inventory},
				type: 'POST',
				url: '<?php echo site_url('logistik_farmasi/Frmcadjustment/hapus_obat'); ?>',
				dataType:'json',
				success: function( response ) {
					if (response.success) {
						table.row( trow ).remove().draw();
					}else{
						alert("Gagal menghapus");
					}
				}
			});
			$( this ).dialog( "close" );
		},
		"Batal": function() {
		  $( this ).dialog( "close" );
		}
	  }
	});
  } 
  function detail_gudang(nm_gudang) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('logistik_farmasi/Frmcadjustment/get_data_detail_gudang')?>",
      data: {
        nm_gudang : nm_gudang
      },
      success: function(data){    
        $('#edit_batch_no').val(data[0].batch_no);
        $('#edit_description').val(data[0].nm_obat);
        $('#edit_qty').val(data[0].qty);
        $('#edit_expire').val(data[0].expire_date);
      },
      error: function(){
        alert("error");
      }
    });
  } 

var table, trow;
$(function() {
	// var $id_obat = $("#edit_id_obat").select2();
  // console.log($id_obat)
	var $id_gudang = $("#select_gudang").select2();
  $("#id_obat").select2();
	//$(".select2").select2();
	
	$('#date_picker').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});  
	table = $('#example').DataTable({
		//ajax: "<?php echo site_url(); ?>logistik_farmasi/Frmcadjustment/list_data",
		columns: [
			{ data: "id_inventory" },
			{ data: "nama_gudang" },
			{ data: "batch_no" },
			{ data: "nm_obat" },
			{ data: "qty" },
			{ data: "expire_date" },
			{ data: "aksi" }
		],
		destroy: true,
		order:  [[ 1, "asc" ]]
	});	
	/*
   	$( "#select_gudang" ).change(function() {
		selectGudang = $( "#select_gudang option:selected" ).text();
		table.columns( 1 ).search( selectGudang ).draw();
	});*/
	$( "#qty_real" ).change(function() {
		selisih = $( "#qty_real" ).val() - $( "#edit_qty_dis" ).val();
		$( "#qty_adjustment" ).val( selisih );
	});
	$('#lihatdetail').on('shown.bs.modal', function(e) {
		$( "#qty_real" ).focus();
		$('#frmAdjustment').on('submit', function (e) {
			e.preventDefault();
			//alert("ok");
			/**/
      // console.log($('#frmAdjustment').serialize());
    	$.ajax({
				url: '<?php echo site_url(); ?>logistik_farmasi/Frmcadjustment/insert_adjustment',
				type: 'POST',
				data: $('#frmAdjustment').serialize(),
				dataType: "json",
				success: function (response) {
					//alert(JSON.stringify(response));
					 if(response.success){
            // $('#qty_real').val();
					 	$('#lihatdetail').modal('hide');
					 	data_tabel($('#edit_id_obat').val(),$('#edit_batch_no').val());
            //  location.reload();
					 }
          
        }
			});
			
		});
	});
	
  function data_tabel(id_obat='',batch_no=''){
    var datas = $('#frmCari').serialize();
    if(id_obat !== ''){
      datas+= `&id_obat=${id_obat}-${batch_no}`;

    }
    $.ajax({
      url: '<?php echo site_url(); ?>logistik_farmasi/Frmcadjustment/list_data',
      type: 'POST',
      data: datas,
      // data: {
      //   'select_gudang':$('#select_gudang').val(),
      //   'id_obat':$('id_obat').val()
      // },
      dataType: "json",
      success: function (response) {
        console.log(response);
        //alert(JSON.stringify(response.data));Frmcamprah/get_amprah_detail_list",
        table.clear().draw();
        table.rows.add(response.data);
        table.columns.adjust().draw(); 
       
      }
    });
  }

	$('#btnCari').click(function(){
		data_tabel();
	});
	$('#btnReset').click(function(){
		$id_obat.val("").trigger("change");
		$id_gudang.val("").trigger("change");
	});
	
	$('#example tbody').on('click', 'tr', function () {
        trow = table.row( this ).index();
		//alert(trow);
		
    } );
});

var site = "<?php echo site_url();?>";
    
</script>

<section class="content-header">
  <?php
    echo $this->session->flashdata('success_msg');
  ?>
</section>


<section class="content" style="width:97%;margin:0 auto">
  <div class="row">
    <div class="col-lg-12 col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">DAFTAR BARANG</h3>
        </div>
        
          <div class="card-block">
              <form id="frmCari" class="form-horizontal">
                <div class="form-group row">
                  <p class="col-sm-2 form-control-label" id="lidgudang">Gudang</p>
                    <div class="col-sm-3">
                        <!--<select name="id_gudang" class="form-control js-example-basic-single" id="select_gudang">
                        </select>-->				
                        <select name="select_gudang" id="select_gudang" class="form-control select2">
                          <option value="">-Pilih Gudang-</option>
                          <?php 
                          foreach($select_gudang as $row){
                            echo '<option value="'.$row->id_gudang.'">'.$row->nama_gudang.'</option>';
                          }
                          ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                  <p class="col-sm-2 form-control-label">Obat</p>
                    <div class="col-sm-3">
                        <!--<select name="id_gudang" class="form-control js-example-basic-single" id="select_gudang">
                        </select>-->				
                        <select id="id_obat" class="form-control select2" name="id_obat">
                          <option value="">-Pilih Obat-</option>
                          <?php
                            foreach($data_obat as $row){
                              echo '<option value="'.$row->id_obat.'-'.$row->batch_no.'">'.$row->nm_obat.' '.'-'.' '.$row->batch_no.'</option>';
                            }
                          ?>
                        </select>
                    </div>
                </div>
              
                    <div class="col-sm-8">
                      <button type="button" id="btnCari" class="btn btn-primary">Cari</button>
                      <!-- <button type="button" id="btnReset" class="btn btn-primary">Reset</button> -->
                    </div>
                </div>
              </form>
              <div class="col-sm-12">
                <table id="example"  cellspacing="0" cellpadding="12" width="100%">
                    <thead>
                    <tr>
                      <th>No.Inv</th>
                      <th>Gudang</th>
                      <th>Batch Number</th>
                      <th>Nama Obat</th>
                      <th>Quantity</th>
                      <th>Expire Date</th>
                      <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
              </div>

            <!-- Modal Edit Obat -->
            <div class="modal fade" id="lihatdetail" role="dialog" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog modal-success">
                <form id = "frmAdjustment" method="POST">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Detail Barang</h4>
                  </div>
                  <div class="modal-body">
                          <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Id Obat</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_id_obat_dis" id="edit_id_obat_dis" disabled="">
                        <input type="hidden" class="form-control" name="edit_id_obat" id="edit_id_obat">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Batch Number</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_batch_no_dis" id="edit_batch_no_dis" disabled="">
                        <input type="hidden" class="form-control" name="edit_batch_no" id="edit_batch_no">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Nama Barang</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_description_dis" id="edit_description_dis" disabled="">
                        <input type="hidden" class="form-control" name="edit_description" id="edit_description">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Expire Date</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_expire_dis" id="edit_expire_dis" disabled="">
                        <input type="hidden" class="form-control" name="edit_expire" id="edit_expire">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Quantity</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_qty_dis" id="edit_qty_dis" disabled="">
                        <input type="hidden" class="form-control" name="edit_qty" id="edit_qty">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Quantity Real</p>
                      <div class="col-sm-6">
                        <input type="number" class="form-control" name="qty_real" id="qty_real" min="0" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Quantity Adjustment</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="qty_adjustment" id="qty_adjustment" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Ket Adjustment</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="ket_adjustment" id="ket_adjustment">
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <!-- <input type="hidden" class="form-control" name="id_obat_dis" id="id_obat_dis"> -->
                      <!-- <input type="hidden" class="form-control" name="id_obat" id="id_obat"> -->
                      <input type="hidden" class="form-control" name="id_inventory" id="id_inventory">
                      <input type="hidden" class="form-control" name="id_gudang_awal" id="id_gudang_awal">
                    <button type="submit" class="btn btn-default">Simpan</button>
                  </div>
                </div>
                </form>
              </div>
            </div>              
          </div>
		
		   </div>
       </div>
    </div>
</section>
<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 
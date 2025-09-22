<?php
  $this->load->view('layout/header.php');
?>
<script type='text/javascript'>
//-----------------------------------------------Data Table
$(document).ready(function() {
    //document.getElementById('exceldown').href= "<?php echo base_url('logistik_farmasi/Frmcstok/exceldown/')?>";
     $('#example').DataTable( {
        initComplete: function () {
            this.api().columns('.filter_gudang').every( function () {
                var column = this;
                var select = $('#select_gudang')
                    // .appendTo( $(column.header()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
    } );
} );
//---------------------------------------------------------


  function detail_gudang(nm_gudang) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('logistik_farmasi/Frmcdistribusi/get_data_detail_gudang')?>",
      data: {
        nm_gudang : nm_gudang
      },
      success: function(data){    
        $('#edit_batch_no').val(data[0].batch_no);
        $('#edit_description').val(data[0].nm_obat);
        $('#edit_qty').val(data[0].qty);
        $('#edit_expire_date').val(data[0].expire_date);
      },
      error: function(){
        alert("error");
      }
    });
  }

  function setparam(gudang){
    //alert(gudang);
      
  } 
var site = "<?php echo site_url();?>";

  function getexcel(){
    var nm_gudang=document.getElementById('select_gudang').value;
    window.open(site+'/logistik_farmasi/Frmcstok_optik/exceldown/'+nm_gudang, "_blank");window.focus();
    /*$.ajax({
      type:'GET',
      dataType: 'json',
      url:"echo base_url('logistik_farmasi/Frmcstok/exceldown')/!*"+'/'+nm_gudang*!/,
      success: function(data){    
       
      },
      error: function(){
        alert("error");
      }
    });*/
  }

  function getexcel_so(){
    var nm_gudang=document.getElementById('select_gudang').value;
    window.open(site+'/logistik_farmasi/Frmcstok/exceldown_so/'+nm_gudang, "_blank");window.focus();
  }

  function getexcel_hasilso(){
    var nm_gudang=document.getElementById('select_gudang').value;
    var new_name = nm_gudang.replace("/", "-")
    window.open(site+'/logistik_farmasi/Frmcstok/exceldown_hasilso/'+new_name, "_blank");window.focus();
  }

function edit_obat(id_obat, id_inventory) {
    $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('logistik_farmasi/Frmcstok/get_data_edit_obat')?>",
        data: {
            id_obat: id_obat,
            id_inventory: id_inventory
        },
        success: function(data){
            $('#edit_id_obat').val(data[0].id_obat);
            $('#edit_id_inventory').val(data[0].id_inventory);
            $('#edit_batch').val(data[0].batch_no);
            $('#edit_ed').val(data[0].expire_date);
        },
        error: function(){
            alert("error");
        }
    });
}

$(function() {
$('#date_picker').datepicker({
    format: "yyyy-mm-dd",
    endDate: '0',
    autoclose: true,
    todayHighlight: true,
  });  
    
});


    
</script>

<section class="content-header">
  <?php
    echo $this->session->flashdata('success_msg');
  ?>
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">DAFTAR STOK BARANG</h3>
        </div>
        
        <div class="box-body">
        <div class="form-group row">
           <p class="col-sm-2 form-control-label" id="lidgudang">Pilihan Gudang</p>
             <div class="col-sm-6">
                <select name="id_gudang" class="form-control js-example-basic-single" id="select_gudang" onchange="setparam(this.value)" disabled="">
                </select><br>
                <a target="_blank" id="exceldown" onclick="getexcel()"><input type="button" class="btn 
                  btn-primary" value="Download Excel"></a>
             </div>
        </div>
          <table id="example" class="display" cellspacing="0" width="100%">
              <thead>
              <tr>
                <th>No</th>
                <th class="filter_gudang">Gudang</th>
                <th>Batch Number</th>
                <th>Nama Item</th>
                <th>Harga Beli</th>
                <th>Quantity</th>
                <th>Min Stock</th>
                <th>Type</th>
                <th>Expire Date</th>
              </tr>
              </thead>

              <tbody>
              <?php
              // print_r($pasien_daftar);
                $i=1;
                foreach($data_barang as $row){
                $batch_no=$row->batch_no;

                /** Hitung Selisih Expire Date dengan Tanggal Sekarang, pake DateTime ga Jalan */
                $now = date("Y-m-d");
                $pecah1 = explode("-", $now);
                $date1 = $pecah1[2];
                $month1 = $pecah1[1];
                $year1 = $pecah1[0];

                $pecah2 = explode("-", $row->expire_date);
                $date2 = $pecah2[2];
                $month2 = $pecah2[1];
                $year2 =  $pecah2[0];

                $jd1 = GregorianToJD($month1, $date1, $year1);
                $jd2 = GregorianToJD($month2, $date2, $year2);
                $selisih = $jd2 - $jd1;
                /** --------------------------------------------------------------------------- */
                if($selisih <= 90){ $bg1 = "bgcolor='#ffa500'"; }else{ $bg1 = ""; }
                if($row->qty < $row->min_stock){ $bg = "bgcolor='#cd5c5c'"; }else{ $bg = ""; }
              ?>
                <tr>
                  <td><?php echo $i++;?></td>
                  <td><?php echo $row->nama_gudang;?></td>
                  <td><?php echo $row->batch_no;?></td>
                  <td><?php echo $row->nm_item;?></td>
                  <td><div align="right"><?php echo number_format($row->hargabeli, '0', ',', '.');?></div></td>
                  <td <?=$bg?>><div align="right"><?php echo number_format($row->qty, '0', ',', '.');?></div></td>
                  <td><div align="right"><?php echo $row->min_stock;?></div></td>
                  <td><?php echo $row->jenis_barang;?></td>
                  <td <?=$bg1?>><div align="center"><?php echo $row->expire_date;?></div></td>
                </tr>
              <?php
                }
              ?>
              </tbody>
            </table>
          <?php
            //echo $this->session->flashdata('message_nodata'); 
          ?>
            <?php echo form_open('logistik_farmasi/Frmcstok/edit_obat');?>
            <!-- Modal Edit Obat -->
            <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-success">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit Obat</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-sm-1"></div>
                                <p class="col-sm-3 form-control-label">Id Obat</p>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="edit_id_obat" id="edit_id_obat" readonly>
                                    <input type="hidden" class="form-control" name="edit_id_inventory" id="edit_id_inventory" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-1"></div>
                                <p class="col-sm-3 form-control-label">Batch Number</p>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="edit_batch" id="edit_batch">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-1"></div>
                                <p class="col-sm-3 form-control-label">Expired Date</p>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="edit_ed" id="edit_ed">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit">Edit Obat</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close();?>

          </div>              
        </div>
      </div>
    </div>
</section>
<?php
  $this->load->view('layout/footer.php');
?>
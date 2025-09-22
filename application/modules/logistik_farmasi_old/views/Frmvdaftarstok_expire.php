<?php
  $this->load->view('layout/header_left.php');
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
    window.open(site+'/logistik_farmasi/Frmcstok/exceldown/'+nm_gudang, "_blank");window.focus();
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
    window.open(site+'/logistik_farmasi/Frmcstok/exceldown_so_expire/'+$('#id_gudang_baru').val(), "_blank");window.focus();
    // var nm_gudang=document.getElementById('select_gudang').value;
    // window.open(site+'/logistik_farmasi/Frmcstok/exceldown_so/'+nm_gudang, "_blank");window.focus();
  }

  function getexcel_hasilso(){
    var nm_gudang=document.getElementById('select_gudang').value;
    var new_name = nm_gudang.replace("/", "-")
    window.open(site+'/logistik_farmasi/Frmcstok/exceldown_hasilso/'+new_name, "_blank");window.focus();
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Obat Gudang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?php echo base_url().'logistik_farmasi/Frmcstok/add_to_gudang'  ?>" method="post">
      <div class="modal-body">

        <div class="form-group">
          <label for="id_gudang" class="col-md-3">Gudang</label>
          <select name="id_gudang" id="id_gudang" class="form-control col-md-8 select2" style="width:65%;" required>
            <option value="">-- Pilih Gudang --</option>
            <?php foreach ($allgudang as $rows) { ?>
              <option value="<?php echo $rows->id_gudang ?>"><?php echo $rows->nama_gudang ?></option>
            <?php } ?> 
          </select>
        </div>

        <div class="form-group">
          <label for="id_obat" class="col-md-3">Obat</label>
          <select name="id_obat" id="id_obat" class="form-control col-md-8 select2" style="width:65%;" required>
            <option value="">-- Pilih Obat --</option>
            <?php foreach ($alloabt as $row) { ?>
              <option value="<?php echo $row->id_obat ?>"><?php echo $row->nm_obat ?></option>
            <?php } ?> 
          </select>
        </div>

        <div class="form-group">
          <label for="qty" class="col-md-3">Qty</label>
          <input type="number" class="form-control col-md-8" name="qty" id="qty" required>
        </div>

        <div class="form-group">
          <label for="exp_date" class="col-md-3">Expire Date</label>
          <input type="date" class="form-control col-md-8" name="exp_date" id="exp_date" required>
        </div>

        <div class="form-group">
          <label for="batch_no" class="col-md-3">batch No</label>
          <input type="number" class="form-control col-md-8" name="batch_no" id="batch_no" required>
        </div>

        <div class="form-group">
          <label for="hargajual" class="col-md-3">Harga Jual</label>
          <input type="number" class="form-control col-md-8" name="hargajual" id="hargajual">
        </div>

        <div class="form-group">
          <label for="hargabeli" class="col-md-3">Harga Beli</label>
          <input type="number" class="form-control col-md-8" name="hargabeli" id="hargabeli">
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div style="background: #e4efe0">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">DAFTAR STOK BARANG</h3>
                </div>
                <div class="card-block">
                    <div class="modal-body">
        <div class="box-body">
        <button class="btn btn-info" style="float: right;" onclick="refresh()">REFRESH</button>
        <!-- <button class="btn btn-info" style="float: right;margin-right: 10px;" data-toggle="modal" data-target="#exampleModal">TAMBAH</button> -->
        <?php if ($all_gudang == '') { ?>
          <a class="btn btn-primary" style="float: right;margin-right: 10px;" href="<?php echo base_url().'logistik_farmasi/Frmcstok/index_expire/all' ?>">SEMUA GUDANG</a>  
        <?php }else{ ?>
          <a class="btn btn-primary" style="float: right;margin-right: 10px;" href="<?php echo base_url().'logistik_farmasi/Frmcstok/index_expire' ?>">GUDANG INDIVIDU</a>
        <?php } ?> 
        <div class="form-group row">
           <p class="col-sm-2 form-control-label" id="lidgudang">Pilihan Gudang</p>
             <div class="col-sm-6">
                <select name="id_gudang" class="form-control js-example-basic-single" id="id_gudang_baru"  style="margin-bottom:10px">
                </select>
                <!-- <a target="_blank" id="exceldown" onclick="getexcel()"><input type="button" class="btn 
                  btn-primary" value="Download Excel"></a> -->
                <a target="_blank" id="exceldown" onclick="getexcel_so()"  ><input type="button" class="btn 
                  btn-danger" value="Download Excel untuk SO"></a>
                <!-- <a target="_blank" id="exceldown" onclick="getexcel_hasilso()"><input type="button" class="btn 
                  btn-success" value="- Download HASIL SO -"></a> -->
             </div>
        </div>
        <div class="table table-responsive">
          <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
              <thead>
              <tr>
                <th>No</th>
                <th class="filter_gudang">Gudang</th>
                <th>Batch</th>
                <th>id_obat</th>
                <th>Nama Obat</th>
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
                // $now = date("Y-m-d");
                // $pecah1 = explode("-", $now);
                // $date1 = $pecah1[2];
                // $month1 = $pecah1[1];
                // $year1 = $pecah1[0];

                // if ($row->expire_date == null) {
                //   $now2 = date("Y-m-d");
                //   $pecah2 = explode("-", $now2);
                //   $date2 = $pecah2[2];
                //   $month2 = $pecah2[1];
                //   $year2 = $pecah2[0];                  
                // }else{
                //   $now2 = date('Y-m-d',strtotime($row->expire_date));
                //   $pecah2 = explode("-", $now2);
                //   $date2 = $pecah2[2];
                //   $month2 = $pecah2[1];
                //   $year2 =  $pecah2[0];
                // }
                // $waktu1 = date_create($now);
                // $waktu2 = date_create($now2);
                
								// $last_diff = date_diff($waktu2,$waktu1);
                // $tahun_selisih = (int)$last_diff->format('%y');
                // $bulan_selisih = (int)$last_diff->format('%m');
                // $tanggal_selisih = (int)$last_diff->format('%d');
               
                // if ($tahun_selisih > 0) {
                //   $bg1 = "bgcolor='#00ff00'";    
                //   $bg2 = '';
                // }elseif($tahun_selisih == 0){
                //   if ($bulan_selisih > 6) {
                //     if ($tanggal_selisih >= 0) {
                //       $bg1 = "bgcolor='#00ff00'";
                //       $bg2 = '';
                //     }else{
                //       $bg1 = '';
                //       $bg2 = '';
                //     }   
                //   }elseif ($bulan_selisih >= 3){
                //     if ($tanggal_selisih >= 0) {
                //       $bg1 = "bgcolor='#fff000'";
                //       $bg2 = '';
                //     }else{
                //       $bg1 = '';
                //       $bg2 = '';
                //     }   
                //   }elseif($bulan_selisih < 3) {
                //     if ($tanggal_selisih >= 0) {
                //       $bg1 = "bgcolor='#ff0000'";
                //       $bg2 = " style='display:none' ";
                //     }else{
                //       $bg1 = '';
                //       $bg2 = '';
                //     }                       
                //   }else{
                //     $bg1 = '';
                //     $bg2 = '';
                //   }
                // }else{                  
                //   $bg1 = '';
                //   $bg2 = '';
                // }

                $bg1 = "bgcolor='#ff0000'";
                if($row->qty < $row->min_stock){ $bg = "bgcolor='#cd5c5c'"; }else{ $bg = ""; }
              ?>
                <tr >
                  <td><?php echo $i++;?></td>
                  <td><?php echo $row->nama_gudang;?></td>
                  <td><?php echo $row->batch_no;?></td>
                  <td><?php echo $row->id_obat;?></td>
                  <td><?php echo $row->nm_obat;?></td>
                  <td><div align="right"><?php echo number_format($row->hargabeli, '0', ',', '.');?></div></td>
                  <td <?=$bg?>>
                      <div align="right">
                          <a href ="<?=base_url('logistik_farmasi/Frmcstok/edit_stok/'.$row->id_inventory)?>" target="_blank">
                            <?php echo number_format($row->qty, '0', ',', '.');?>
                          </a>
                      </div>
                 </td>   
                  <td><div align="right"><?php echo number_format($row->min_stock, '0', ',', '.');?></div></td>
                  <td><?php echo $row->jenis_barang;?></td>
                  <td <?=$bg1?> class="text-white"><div align="center"><?php echo $row->expire_date ;?></div></td>
                  <!-- <td <?=$bg1?> class="text-white"><div align="center"><?php echo $tahun_selisih.' '.$bulan_selisih.' '.$tanggal_selisih; ?></div></td> -->
                </tr>
              <?php
                }
              ?>
              </tbody>
          </table>
        </div>
          <?php
            //echo $this->session->flashdata('message_nodata'); 
          ?>  
          </div>              
        </div>
      </div>
    </div>
    </div>
    </div>
    <div class="collapse m-t-15" id="tt11" aria-expanded="true">
        <code>
            &lt;span class="mytooltip tooltip-effect-1"&gt;
            &lt;span class="tooltip-item2">Euclid&lt;/span&gt;
            &lt;span class="tooltip-content4 clearfix"&gt;
            &lt;span class="tooltip-text2"&gt;
            &lt;strong&gt;Euclid&lt;/strong&gt;
        </code>
    </div>
</div>

<script>
  $.ajax({
      dataType: 'json',
      url:"<?php echo base_url('logistik_farmasi/frmcstok/get_data_master_gudang_all')?>",

      success: function(data){    
        // console.log(data);
        var html = '';
        data.map((val)=>{
          html+= `<option value="${val.id_gudang}">${val.nama_gudang}</option>`;
        })
        $('#id_gudang_baru').append(html);
      },
      error: function(){
        console.log(data);
      }
    });
</script>
<?php
  $this->load->view('layout/footer_left.php');
?>
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
                    select.append( '<option value="'+d+'">'+d+'</option>' );
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
    window.open(site+'/logistik_farmasi/Frmcstok/exceldown/'+$('#id_gudang_baru').val(), "_blank");window.focus();
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

    window.open(site+'/logistik_farmasi/Frmcstok/exceldown_so/'+$('#id_gudang_baru').val(), "_blank");window.focus();
    // var nm_gudang=document.getElementById('select_gudang').value;
    // window.open(site+'/logistik_farmasi/Frmcstok/exceldown_so/'+nm_gudang, "_blank");window.focus();
  }

  function getexcel_hasilso(){
    // var nm_gudang=document.getElementById('select_gudang').value;
    // var new_name = nm_gudang.replace("/", "-")
    window.open(site+'/logistik_farmasi/Frmcstok/exceldown_hasilso/'+$('#id_gudang_baru').val(), "_blank");window.focus();
    // window.open(site+'/logistik_farmasi/Frmcstok/exceldown_hasilso/'+new_name, "_blank");window.focus();
  }

$(function() {
$('#date_picker').datepicker({
    format: "yyyy-mm-dd",
    endDate: '0',
    autoclose: true,
    todayHighlight: true,
  });  

  // $("#id_obat").select2();

  $("#id_obat").select2(
    {
      dropdownParent:$("#exampleModal")
    }
  );
    
});



function refresh() {
  window.location.reload();
}


function set_total() {
	var biaya_obat_satuan = $('input[name=hargabeli]').val();
	var ppn = $('input[name=ppn]:checked').val()/100;
	var qty = $('input[name=qty]').val();
	var margin = $('input[name=margin]').val()/100;


	

	// $('#hargabeli').val(harga_beli);
	var tot_margin = margin*biaya_obat_satuan;

	var tot_ppn = ppn*biaya_obat_satuan;
  // console.log(tot_ppn)
	//hrga jual--------------
   ppn_margin =  (tot_margin + tot_ppn);
  // console.log(ppn_margin)
  var total_harga_jual = parseInt(biaya_obat_satuan)+ppn_margin;


  console.log(total_harga_jual)
	$('#hargajual').val(total_harga_jual);
    // --------------------

  // var harga_beli_besar = biaya_obat_satuan*qty;
  var biaya_obat_plus_ppn = (ppn*parseInt(biaya_obat_satuan)) + parseInt(biaya_obat_satuan);
	// totalllll
	$('#vtot_x').val(biaya_obat_plus_ppn);
}


    
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
          <label for="qty" class="col-md-3">Gudang</label>
          <input type="text" class="form-control col-md-8" name="nm_gudang" id="nm_gudang" value="<?= $gudang?>" readonly>
          <input type="hidden" class="form-control" id="id_gudang" name="id_gudang" value="<?= $id_gudang ?>">
        </div>

        <div class="form-group">
          <label  class="col-md-3 form-control-label">Obat</label>
          <select name="id_obat" id="id_obat" class="form-control col-md-8 select2" style="width:65%;">
            <option value="">-- Pilih Obat --</option>
            <?php foreach ($alloabt as $row) {
              echo '<option value="'.$row->id_obat.'">'.$row->nm_obat.'</option>';
             
            } ?> 
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
          <input type="text" class="form-control col-md-8" name="batch_no" id="batch_no" required>
        </div>

        <div class="form-group">
          <label for="hargabeli" class="col-md-3">Harga Beli (satuan kecil)</label>
          <input type="number" class="form-control col-md-8" name="hargabeli" id="hargabeli" onchange="set_total(this.value)">
        </div>

        <div class="form-group">
            <label for="hargabeli" class="col-md-3">Margin(%)</label>
            <input type="number" class="form-control col-md-8" name="margin" onchange="set_total(this.value)" id="margin" value="25" required>
				</div>

        <div class="form-group">
            <label for="hargabeli" class="col-md-3">PPN</label>
            <input type="radio" id="ppn10" class="with-gap radio-col-blue" value="11"  name="ppn" onclick="set_total()"  checked=""/>
            <label for="ppn10">11%</label>
            &nbsp;
            <input type="radio" id="ppn0" class="with-gap radio-col-blue" value="0" name="ppn" onclick="set_total()" />
            <label for="ppn0" >0%</label>
        </div>

        <div class="form-group">
          <label for="hargajual" class="col-md-3">Harga Jual (satuan kecil)</label>
          <input type="number" class="form-control col-md-8" name="hargajual" id="hargajual">
        </div>

        <div class="form-group">
          <label for="hargajual" class="col-md-3">Total Harga Beli</label>
          <input type="number" class="form-control col-md-8" name="vtot_x" id="vtot_x">
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
        <button class="btn btn-info" style="float: right;margin-right: 10px;" data-toggle="modal" data-target="#exampleModal">TAMBAH</button>
        <?php if ($all_gudang == '') { ?>
          <a class="btn btn-primary" style="float: right;margin-right: 10px;" href="<?php echo base_url().'logistik_farmasi/Frmcstok/index/all' ?>">SEMUA GUDANG</a>  
        <?php }else{ ?>
          <a class="btn btn-primary" style="float: right;margin-right: 10px;" href="<?php echo base_url().'logistik_farmasi/Frmcstok/index' ?>">GUDANG INDIVIDU</a>
        <?php } ?> 

        <!-- <a class="btn btn-primary" style="float: right;margin-right: 10px;" href="<?php echo base_url().'logistik_farmasi/Frmclaporan/min_max_stock_gdfarmasi' ?>">Hitung Min/Max Stock</a> -->
        
      

        <div class="form-group row">
           <p class="col-sm-2 form-control-label" id="lidgudang">Pilihan Gudang</p>
             <div class="col-sm-6">
                <select  class="form-control js-example-basic-single" id="id_gudang_baru" style="margin-bottom:10px">                
                </select>
               
                
                
             </div>
        </div>

        <?php echo form_open('logistik_farmasi/Frmcstok/index');?>

          <!-- <div class="form-group row">
              <label class="col-sm-2 control-label">Janis Obat</label>
              <div class="col-sm-4">
              <select id="jenis_obat" class="form-control" name="jenis_obat">
                <option value="" disabled selected="">-Pilih Jenis-</option>
                <?php 
                  foreach($jenis as $row){
                    echo '<option value="'.$row->nm_jenis.'">'.$row->nm_jenis.'</option>';
                  }
                ?>
              </select>
              </div>
              
          </div> -->


          <!-- <div class="form-group row">
              <label class="col-sm-2 control-label">Kelompok</label>
              <div class="col-sm-4">
              <select id="kel" class="form-control" name="kel">
                <option value="" disabled selected="">-Pilih Kelompok-</option>
                <?php 
                  foreach($kelompok as $row){
                    echo '<option value="'.$row->kode.'">'.$row->nm_kelompok.'</option>';
                  }
                ?>
              </select>
              </div>
              
          </div> -->

          <!-- <div class="form-group row">
              <label class="col-sm-2 control-label">Sub Kelompok</label>
              <div class="col-sm-4">
              <select id="subkel" class="form-control" name="subkel">
                <option value="" disabled selected="">-Pilih SubKelompok-</option>
                <?php 
                  foreach($subkelompok as $row){
                    echo '<option value="'.$row->kode.'">'.$row->bentuk_sediaan.'</option>';
                  }
                ?>
              </select>
              </div>
              
          </div> -->

          <!-- <div class="col-sm-4">
            <div class="form-actions">
            <input type="hidden" class="form-control" value="<?php echo isset($rolegd)?$rolegd:'';?>" name="role">
              <button class="btn btn-primary" type="submit">Cari</button>
            </div>
          </div> -->
        <?php echo form_close();?>

          <br><br>

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
                <?php //if($id_gudang == '1'){ ?>
                  <th>Harga Jual</th>
                <?php //} ?>
                <th>Quantity</th>
                <th>Min Stock</th>
                <th>Type</th>
                <th>Expire Date</th> 
                <th>Aksi</th>
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

                if ($row->expire_date == null) {
                  $now2 = date("Y-m-d");
                  $pecah2 = explode("-", $now2);
                  $date2 = $pecah2[2];
                  $month2 = $pecah2[1];
                  $year2 = $pecah2[0];                  
                }else{
                  $now2 = date('Y-m-d',strtotime($row->expire_date));
                  $pecah2 = explode("-", $now2);
                  $date2 = $pecah2[2];
                  $month2 = $pecah2[1];
                  $year2 =  $pecah2[0];
                }
                $waktu1 = date_create($now);
                $waktu2 = date_create($now2);
                
								$last_diff = date_diff($waktu2,$waktu1);
                $tahun_selisih = (int)$last_diff->format('%y');
                $bulan_selisih = (int)$last_diff->format('%m');
                $tanggal_selisih = (int)$last_diff->format('%d');
                if ($tahun_selisih > 0) {
                  $bg1 = "bgcolor='#00ff00'";    
                  $bg2 = '';
                }elseif($tahun_selisih == 0){
                  if ($bulan_selisih > 6) {
                    if ($tanggal_selisih >= 0) {
                      $bg1 = "bgcolor='#00ff00'";
                      $bg2 = '';
                    }else{
                      $bg1 = '';
                      $bg2 = '';
                    }   
                  }elseif ($bulan_selisih >= 3){
                    if ($tanggal_selisih >= 0) {
                      $bg1 = "bgcolor='#fff000'";
                      $bg2 = '';
                    }else{
                      $bg1 = '';
                      $bg2 = '';
                    }   
                  }elseif($bulan_selisih < 3) {
                    if ($tanggal_selisih >= 0) {
                      $bg1 = "bgcolor='#ff0000'";
                      $bg2 = " style='display:none' ";
                    }else{
                      $bg1 = '';
                      $bg2 = '';
                    }                       
                  }else{
                    $bg1 = '';
                    $bg2 = '';
                  }
                }else{                  
                  $bg1 = '';
                  $bg2 = '';
                }

                // $jd1 = GregorianToJD($month1, $date1, $year1);
                // $jd2 = GregorianToJD($month2, $date2, $year2);
                // $selisih = $jd2 - $jd1;
                /** --------------------------------------------------------------------------- */
                // if($selisih <= 90){  }else{ $bg1 = ""; }
                if($row->qty < $row->min_stock){ $bg = "bgcolor='#cd5c5c'"; }else{ $bg = ""; }
              ?>
                <tr >
                  <td><?php echo $i++;?></td>
                  <td><?php echo $row->nama_gudang;?></td>
                  <td><?php echo $row->batch_no;?></td>
                  <td><?php echo $row->id_obat;?></td>
                  <td><?php echo $row->nm_obat;?></td>
                  <td><div align="right"><?php echo $row->hargabeli?></div></td>
                  <?php if($id_gudang == '1'){ ?>
                  <td>
                      <div align="right">
                          <a href ="<?=base_url('logistik_farmasi/Frmcstok/edit_hargajual/'.$row->id_inventory)?>" target="_blank">
                              <div align="right"><?php echo $row->hargajual?></div>
                          </a>
                      </div>
                      
                  </td>
                  <?php }else { ?>
                    <td>
                      <div align="right">
                         <?php echo $row->hargajual?>
                      </div>
                      
                  </td>
                  <?php } ?>
                  <td <?=$bg?>>
                      <div align="right">
                          <a href ="<?=base_url('logistik_farmasi/Frmcstok/edit_stok/'.$row->id_inventory)?>" target="_blank">
                            <?php echo $row->qty;?>
                          </a>
                      </div>
                  </td>   
                  <td><div align="right"><?php echo number_format($row->min_stock, '0', ',', '.');?></div></td>
                  <td><?php echo $row->jenis_barang;?></td>
                  <td <?=$bg1?> class="text-white"><div align="center"><?php echo $row->expire_date ;?></div></td>
                  <!-- <td <?=$bg1?> class="text-white"><div align="center"><?php echo $tahun_selisih.' '.$bulan_selisih.' '.$tanggal_selisih; ?></div></td> -->
                  <td><a href="<?php echo site_url(); ?>logistik_farmasi/frmcstok/cetak_label/<?php echo $row->id_inventory ?>" target="_blank" class="btn btn-info btn-xs"><i class="fa fa-plusthick"></i>Cetak Label</a></td>
                </tr>
              <?php
                }
              ?>
              </tbody>
          </table>
        </div>
        <a target="_blank" id="exceldown" onclick="getexcel_so()"><input type="button" class="btn 
                  btn-danger" value="Download Excel untuk SO"></a>
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
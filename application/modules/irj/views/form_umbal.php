<?php

?><?php
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_left");
}
?>
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
});

var no_register = '<?php echo $no_register;?>';

function insert_tarif(id_tindakan) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('irj/rjclaporan/get_data_tindakan')?>",
      data: {
        id_tindakan: id_tindakan,
        no_register: no_register
      },
      success: function(data){
        $('#edit_nmtindakan').val(data.jenis_tindakan);
        $('#noreg_hide').val(data.no_register);
        $('#idtindakan_hide').val(data.id_tindakan);
        $('#keltindakan_hide').val(data.kel_tindakan);
        $('#subkelompok_hide').val(data.sub_kelompok);
        $('#kategori_hide').val(data.kategori);
        $('#satuan_hide').val(data.satuan);
        $('#vol_umum').val(data.total);
        $('#tarif_umum').val(data.vtot);
        $('#nmtindakan_hide').val(data.jenis_tindakan);
      },
      error: function(){
        alert("error");
      }
    });
}

function insert_tarif_obat(item_obat) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('irj/rjclaporan/get_data_tindakan_obat')?>",
      data: {
        item_obat: item_obat,
        no_register: no_register
      },
      success: function(data){
        $('#nmobat').val(data.nama_obat);
        $('#noreg_hide_obat').val(data.no_register);
        $('#idobat_hide').val(data.item_obat);
        $('#keltindakan_hide_obat').val(data.kel_tindakan);
        $('#subkelompok_hide_obat').val(data.sub_kelompok);
        $('#kategori_hide_obat').val(data.kategori);
        $('#satuan_hide_obat').val(data.satuan);
        $('#vol_umum_obat').val(data.total);
        $('#tarif_umum_obat').val(data.vtot);
        $('#nmobat_hide').val(data.nama_obat);
      },
      error: function(){
        alert("error");
      }
    });
}

function submitTarif() {
    let data = $("#formedit").serialize();
    // console.log(data);
    document.getElementById("btnEdit").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
    $.ajax({  
      url:"<?php echo base_url(); ?>irj/rjclaporan/insert_realisasi_tindakan",                         
      method:"POST",  
      data:data,  
      success: function(data)  
      { 
        document.getElementById("btnEdit").innerHTML = 'Insert';
        $('#editModal').modal('hide'); 
        document.getElementById("formedit").reset();
        swal({
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
        document.getElementById("btnEdit").innerHTML = 'Insert';
        $('#editModal').modal('hide');
        swal("Error","Data gagal diperbaharui.", "error"); 
        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
      }  
  });   
}

function submitTarifObat() {
    let data = $("#formeditObat").serialize();
    // console.log(data);
    document.getElementById("btnEditObat").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
    $.ajax({  
      url:"<?php echo base_url(); ?>irj/rjclaporan/insert_realisasi_tindakan_obat",                         
      method:"POST",  
      data:data,  
      success: function(data)  
      { 
        document.getElementById("btnEditObat").innerHTML = 'Insert';
        $('#editModalObat').modal('hide'); 
        document.getElementById("formeditObat").reset();
        swal({
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
        document.getElementById("btnEditObat").innerHTML = 'Insert';
        $('#editModalObat').modal('hide');
        swal("Error","Data gagal diperbaharui.", "error"); 
        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
      }  
  });   
}
</script>
<style>
hr {
border-color:#7DBE64 !important;
}
</style>
<?php include('data_pasien_umbal.php'); ?>
                 
<div class="row">
<div class="col-lg-12 col-md-12">
    <div class="card">
        <div class="card-block">
            <div class="card-title" align="center" >
                <h4 align="center">Input Realisasi Tindakan Rawat Jalan/IGD</h4></div>					
                <div class="panel-body">
                    <div class="table-responsive m-t-15">
                            <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Kelompok Tindakan</th>
                                        <th>Kategori</th>
                                        <th>Sub Kelompok</th>
                                        <th>Tindakan</th>
                                        <th>Satuan</th>
                                        <th>Aksi</th>
                                    </tr>                                       
                                </thead>
                                <tbody id="tbodyexample">
                                <?php 
                                    foreach($tindakan as $row) { ?>
                                        <tr>
                                            <td><?php echo $row->kel_tindakan;?></td>
                                            <td><?php echo $row->kategori;?></td>
                                            <td><?php echo $row->sub_kelompok;?></td>
                                            <td><?php echo $row->jenis_tindakan;?></td>
                                            <td><?php echo $row->satuan;?></td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" onclick="insert_tarif('<?php echo $row->id_tindakan; ?>')"><i class="fa fa-edit"></i></button>
                                            </td>
                                        </tr>
                                <?php }
                                    if($resep) {
                                      foreach($resep as $r) { ?>
                                        <tr>
                                            <td><?php echo $r->kel_tindakan;?></td>
                                            <td><?php echo $r->kategori;?></td>
                                            <td><?php echo $r->sub_kelompok;?></td>
                                            <td><?php echo $r->nama_obat;?></td>
                                            <td><?php echo $r->satuan;?></td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModalObat" onclick="insert_tarif_obat('<?php echo $r->item_obat; ?>')"><i class="fa fa-edit"></i></button>
                                            </td>
                                        </tr>
                                <?php }
                                    }
                                ?>
                                </tbody>
                            </table>
                    </div>
                </div>	
            </div>
        </div>
    </div>	 	
</div>	 	
</div><!-- end row -->

<form method="POST" id="formedit" class="form-horizontal">
<div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Input Rupiah</h4>
            </div>
            <div class="modal-body">
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_nama">Tindakan</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="edit_nmtindakan" id="edit_nmtindakan" disabled>
                        <input type="hidden" class="form-control" name="noreg_hide" id="noreg_hide">
                        <input type="hidden" class="form-control" name="idtindakan_hide" id="idtindakan_hide">
                        <input type="hidden" class="form-control" name="keltindakan_hide" id="keltindakan_hide">
                        <input type="hidden" class="form-control" name="subkelompok_hide" id="subkelompok_hide">
                        <input type="hidden" class="form-control" name="kategori_hide" id="kategori_hide">
                        <input type="hidden" class="form-control" name="satuan_hide" id="satuan_hide">
                        <input type="hidden" class="form-control" name="nmtindakan_hide" id="nmtindakan_hide">
                      </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                      <p class="col-sm-6 form-control-label" id="lbl_nama">Tarif RS</p>
                      <p class="col-sm-6 form-control-label" id="lbl_nama">Rupiah Realisasi</p>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-6">
                        <input type="number" class="form-control" name="vol_umum" id="vol_umum" step="100" min="0">
                      </div>
                      <div class="col-sm-6">
                        <input type="number" class="form-control" name="tarif_umum" id="tarif_umum" step="100" min="0">
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="button" id="btnEdit" class="btn btn-primary" onclick="submitTarif()">Insert</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<form method="POST" id="formeditObat" class="form-horizontal">
<div class="modal fade" id="editModalObat" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Input Rupiah</h4>
            </div>
            <div class="modal-body">
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_nama">Tindakan</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="nmobat" id="nmobat" disabled>
                        <input type="hidden" class="form-control" name="noreg_hide_obat" id="noreg_hide_obat">
                        <input type="hidden" class="form-control" name="idobat_hide" id="idobat_hide">
                        <input type="hidden" class="form-control" name="keltindakan_hide_obat" id="keltindakan_hide_obat">
                        <input type="hidden" class="form-control" name="subkelompok_hide_obat" id="subkelompok_hide_obat">
                        <input type="hidden" class="form-control" name="kategori_hide_obat" id="kategori_hide_obat">
                        <input type="hidden" class="form-control" name="satuan_hide_obat" id="satuan_hide_obat">
                        <input type="hidden" class="form-control" name="nmobat_hide" id="nmobat_hide">
                      </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                      <p class="col-sm-6 form-control-label" id="lbl_nama">Tarif RS</p>
                      <p class="col-sm-6 form-control-label" id="lbl_nama">Rupiah Realisasi</p>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-6">
                        <input type="number" class="form-control" name="vol_umum_obat" id="vol_umum_obat" step="100" min="0">
                      </div>
                      <div class="col-sm-6">
                        <input type="number" class="form-control" name="tarif_umum_obat" id="tarif_umum_obat" step="100" min="0">
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="button" id="btnEditObat" class="btn btn-primary" onclick="submitTarifObat()">Insert</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<?php
if ($role_id == 1) {
    $this->load->view("layout/footer_left");
} else {
    $this->load->view("layout/footer_left");
}
?>
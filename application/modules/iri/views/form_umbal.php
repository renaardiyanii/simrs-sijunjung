<?php
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
 
var inacbg = '<?php echo $inacbg;?>';
var no_ipd = '<?php echo $no_register;?>';
var noregasal = '<?php echo $noregasal;?>';
function insert_tarif_bpjs(id_tindakan) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('iri/riclaporan/get_data_tindakan')?>",
      data: {
        id_tindakan: id_tindakan,
        no_ipd: no_ipd,
        noregasal: noregasal
      },
      success: function(data){
        $('#edit_nmtindakan').val(data.jenis_tindakan);
        $('#idtindakan_hide').val(data.id_tindakan);
        $('#keltindakan_hide').val(data.kel_tindakan);
        $('#subkelompok_hide').val(data.sub_kelompok);
        $('#kategori_hide').val(data.kategori);
        $('#satuan_hide').val(data.satuan);
        $('#vol_umum').val(data.total);
        $('#tarif_umum').val(data.vtot);
        $('#ina-cbg').val(inacbg);
        $('#noipd').val(no_ipd);
        $('#nmtindakan_hide').val(data.jenis_tindakan);
      },
      error: function(){
        alert("error");
      }
    });
}
var total_ruang = 0;
function insert_tarif_ruang_bpjs(idrg) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('iri/riclaporan/get_data_tindakan_ruang')?>",
      data: {
        no_ipd: no_ipd,
        idrg: idrg
      },
      success: function(data){
        // console.log(data);
        var diff = 1;
        if(data.tglkeluarrg !== null){
          var start = new Date(data.tglmasukrg);//start
          var end = new Date(data.tglkeluarrg);//end
            
          //diff = end->diff(start)->format("%a");
          var time = end.getTime() - start.getTime();
          diff = time / (1000 * 3600 * 24);
          if(diff == 0){
            diff = 1;
          }
        }else{
          if(data.tgl_keluar_resume !== null){
            var start = new Date(data.tglmasukrg);//start
            var end = new Date(data.tgl_keluar_resume);//end
            
            //var diff = end->diff(start)->format("%a");
            var time = end.getTime() - start.getTime();
            diff = time / (1000 * 3600 * 24);
            if(diff == 0){
              diff = 1;
            }
          }else{
            var start = new Date(data.tglmasukrg);//start
            var end = new Date(date("Y-m-d"));//end
            
            // var diff = end->diff(start)->format("%a");
            var time = end.getTime() - start.getTime();
            diff = time / (1000 * 3600 * 24);
            if(diff == 0){
              diff = 1;
            } 
          }
        }
        total_ruang += (data.total_tarif * diff);
        $('#edit_nmtindakan_ruang').val(data.tindakan);
        $('#idrg').val(data.idrg);
        $('#keltindakan_hide_ruang').val(data.kel_tindakan);
        $('#subkelompok_hide_ruang').val(data.sub_kelompok);
        $('#kategori_hide_ruang').val(data.kategori);
        $('#satuan_hide_ruang').val(data.satuan);
        $('#vol_umum_ruang').val(total_ruang);
        $('#tarif_umum_ruang').val(data.vtot);
        $('#ina-cbg_ruang').val(inacbg);
        $('#noipd_ruang').val(no_ipd);
        $('#nmtindakan_hide_ruang').val(data.tindakan);
      },
      error: function(){
        alert("error");
      }
    });
}

function insert_tarif_ruang_iks(idrg) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('iri/riclaporan/get_data_tindakan_ruang')?>",
      data: {
        no_ipd: no_ipd,
        idrg: idrg
      },
      success: function(data){
        // console.log(data);
        var diff = 1;
        if(data.tglkeluarrg !== null){
          var start = new Date(data.tglmasukrg);//start
          var end = new Date(data.tglkeluarrg);//end
            
          //diff = end->diff(start)->format("%a");
          var time = end.getTime() - start.getTime();
          diff = time / (1000 * 3600 * 24);
          if(diff == 0){
            diff = 1;
          }
        }else{
          if(data.tgl_keluar_resume !== null){
            var start = new Date(data.tglmasukrg);//start
            var end = new Date(data.tgl_keluar_resume);//end
            
            //var diff = end->diff(start)->format("%a");
            var time = end.getTime() - start.getTime();
            diff = time / (1000 * 3600 * 24);
            if(diff == 0){
              diff = 1;
            }
          }else{
            var start = new Date(data.tglmasukrg);//start
            var end = new Date(date("Y-m-d"));//end
            
            // var diff = end->diff(start)->format("%a");
            var time = end.getTime() - start.getTime();
            diff = time / (1000 * 3600 * 24);
            if(diff == 0){
              diff = 1;
            } 
          }
        }
        total_ruang += (data.total_tarif * diff);
        $('#edit_nmtindakan_ruang_iks').val(data.tindakan);
        $('#idrg_iks').val(data.idrg);
        $('#keltindakan_hide_ruang_iks').val(data.kel_tindakan);
        $('#subkelompok_hide_ruang_iks').val(data.sub_kelompok);
        $('#kategori_hide_ruang_iks').val(data.kategori);
        $('#satuan_hide_ruang_iks').val(data.satuan);
        $('#vol_umum_ruang_iks').val(total_ruang);
        $('#tarif_umum_ruang_iks').val(data.vtot);
        $('#noipd_ruang_iks').val(no_ipd);
        $('#nmtindakan_hide_ruang_iks').val(data.tindakan);
      },
      error: function(){
        alert("error");
      }
    });
}

function insert_tarif_obat_bpjs(item_obat) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('iri/riclaporan/get_data_tindakan_obat')?>",
      data: {
        item_obat: item_obat,
        no_ipd: no_ipd,
        noregasal: noregasal
      },
      success: function(data){
        $('#nmobat').val(data.nama_obat);
        $('#idobat_hide').val(data.item_obat);
        $('#keltindakan_hide_obat').val(data.kel_tindakan);
        $('#subkelompok_hide_obat').val(data.sub_kelompok);
        $('#kategori_hide_obat').val(data.kategori);
        $('#satuan_hide_obat').val(data.satuan);
        $('#vol_umum_obat').val(data.total);
        $('#tarif_umum_obat').val(data.vtot);
        $('#ina-cbg_obat').val(inacbg);
        $('#noipd_obat').val(no_ipd);
        $('#nmobat_hide').val(data.nama_obat);
      },
      error: function(){
        alert("error");
      }
    });
}

function insert_tarif_obat_iks(item_obat) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('iri/riclaporan/get_data_tindakan_obat')?>",
      data: {
        item_obat: item_obat,
        no_ipd: no_ipd,
        noregasal: noregasal
      },
      success: function(data){
        $('#nmobat_iks').val(data.nama_obat);
        $('#idobat_hide_iks').val(data.item_obat);
        $('#keltindakan_hide_obat_iks').val(data.kel_tindakan);
        $('#subkelompok_hide_obat_iks').val(data.sub_kelompok);
        $('#kategori_hide_obat_iks').val(data.kategori);
        $('#satuan_hide_obat_iks').val(data.satuan);
        $('#vol_umum_obat_iks').val(data.total);
        $('#tarif_umum_obat_iks').val(data.vtot);
        $('#noipd_obat_iks').val(no_ipd);
        $('#nmobat_hide_iks').val(data.nama_obat);
      },
      error: function(){
        alert("error");
      }
    });
}

function insert_tarif_iks(id_tindakan) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('iri/riclaporan/get_data_tindakan')?>",
      data: {
        id_tindakan: id_tindakan,
        no_ipd: no_ipd,
        noregasal: noregasal
      },
      success: function(data){
        $('#edit_nmtindakan_iks').val(data.jenis_tindakan);
        $('#idtindakan_hide_iks').val(data.id_tindakan);
        $('#keltindakan_hide_iks').val(data.kel_tindakan);
        $('#subkelompok_hide_iks').val(data.sub_kelompok);
        $('#kategori_hide_iks').val(data.kategori);
        $('#satuan_hide_iks').val(data.satuan);
        $('#vol_umum_iks').val(data.total);
        $('#tarif_umum_iks').val(data.vtot);
        $('#noipd_iks').val(no_ipd);
        $('#nmtindakan_hide_iks').val(data.jenis_tindakan);
      },
      error: function(){
        alert("error");
      }
    });
}

function submitTarifBpjs() {
    let data = $("#formedit").serialize();
    document.getElementById("btnEdit").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
    $.ajax({  
      url:"<?php echo base_url(); ?>iri/riclaporan/insert_realisasi_tindakan_bpjs",                         
      method:"POST",  
      data:data,  
      success: function(data)  
      { 
        document.getElementById("btnEdit").innerHTML = 'Insert';
        $('#editModalBpjs').modal('hide'); 
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
        $('#editModalBpjs').modal('hide');
        swal("Error","Data gagal diperbaharui.", "error"); 
        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
      }  
  });   
}

function submitObatBpjs() {
    let data = $("#formeditObat").serialize();
    document.getElementById("btnEditObat").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
    $.ajax({  
      url:"<?php echo base_url(); ?>iri/riclaporan/insert_realisasi_tindakan_obat_bpjs",                         
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

function submitObatIks() {
    let data = $("#formeditObatIks").serialize();
    document.getElementById("btnEditObatIks").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
    $.ajax({  
      url:"<?php echo base_url(); ?>iri/riclaporan/insert_realisasi_tindakan_obat_iks",                         
      method:"POST",  
      data:data,  
      success: function(data)  
      { 
        document.getElementById("btnEditObatIks").innerHTML = 'Insert';
        $('#editModalObatIks').modal('hide'); 
        document.getElementById("formeditObatIks").reset();
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
        document.getElementById("btnEditObatIks").innerHTML = 'Insert';
        $('#editModalObatIks').modal('hide');
        swal("Error","Data gagal diperbaharui.", "error"); 
        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
      }  
  });   
}

function submitTarifIks() {
    let data = $("#formeditIks").serialize();
    document.getElementById("btnEditIks").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
    $.ajax({  
      url:"<?php echo base_url(); ?>iri/riclaporan/insert_realisasi_tindakan_iks",                         
      method:"POST",  
      data:data,  
      success: function(data)  
      { 
        document.getElementById("btnEditIks").innerHTML = 'Insert';
        $('#editModalIks').modal('hide'); 
        document.getElementById("formeditIks").reset();
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
        document.getElementById("btnEditIks").innerHTML = 'Insert';
        $('#editModalIks').modal('hide');
        swal("Error","Data gagal diperbaharui.", "error"); 
        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
      }  
  });   
}

function submitTarifBpjsRuang() {
  let data = $("#formeditRuang").serialize();
    document.getElementById("btnEditRuang").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
    $.ajax({  
      url:"<?php echo base_url(); ?>iri/riclaporan/insert_realisasi_tindakan_ruang",                         
      method:"POST",  
      data:data,  
      success: function(data)  
      { 
        document.getElementById("btnEditRuang").innerHTML = 'Insert';
        $('#editModalRuang').modal('hide'); 
        document.getElementById("formeditRuang").reset();
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
        document.getElementById("btnEditRuang").innerHTML = 'Insert';
        $('#editModalRuang').modal('hide');
        swal("Error","Data gagal diperbaharui.", "error"); 
        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
      }  
  }); 
}

function submitTarifIksRuang() {
  let data = $("#formeditRuangIks").serialize();
    document.getElementById("btnEditRuangIks").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
    $.ajax({  
      url:"<?php echo base_url(); ?>iri/riclaporan/insert_realisasi_tindakan_ruang_iks",                         
      method:"POST",  
      data:data,  
      success: function(data)  
      { 
        document.getElementById("btnEditRuangIks").innerHTML = 'Insert';
        $('#editModalRuangIks').modal('hide'); 
        document.getElementById("formeditRuangIks").reset();
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
        document.getElementById("btnEditRuangIks").innerHTML = 'Insert';
        $('#editModalRuangIks').modal('hide');
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
                <h4 align="center">Input Realisasi Tindakan Rawat Inap</h4></div>					
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
                                            <td><?php 
                                            if($carabayar == 'BPJS') { ?> 
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModalBpjs" onclick="insert_tarif_bpjs('<?php echo $row->id_tindakan;?>')"><i class="fa fa-edit"></i></button>
                                            <?php } else if($carabayar == 'KERJASAMA') { ?>
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModalIks" onclick="insert_tarif_iks('<?php echo $row->id_tindakan;?>')"><i class="fa fa-edit"></i></button>
                                            <?php }
                                            ?>
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
                                                <td><?php 
                                                if($carabayar == 'BPJS') { ?> 
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModalObat" onclick="insert_tarif_obat_bpjs('<?php echo $r->item_obat;?>')"><i class="fa fa-edit"></i></button>
                                                <?php } else if($carabayar == 'KERJASAMA') { ?>
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModalObatIks" onclick="insert_tarif_obat_iks('<?php echo $r->item_obat;?>')"><i class="fa fa-edit"></i></button>
                                                <?php }
                                                ?>
                                                </td>
                                            </tr>
                                <?php }
                                 }
                                ?>
                                <?php
                                    if($ruang) {
                                        foreach($ruang as $val) { ?>
                                            <tr>
                                                <td><?php echo $val->kel_tindakan;?></td>
                                                <td><?php echo $val->kategori;?></td>
                                                <td><?php echo $val->sub_kelompok;?></td>
                                                <td><?php echo $val->nmruang.' - '.$val->tindakan;?></td>
                                                <td><?php echo $val->satuan;?></td>
                                                <td><?php 
                                                if($carabayar == 'BPJS') { ?> 
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModalRuang" onclick="insert_tarif_ruang_bpjs('<?php echo $val->idrg;?>')"><i class="fa fa-edit"></i></button>
                                                <?php } else if($carabayar == 'KERJASAMA') { ?>
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModalRuangIks" onclick="insert_tarif_ruang_iks('<?php echo $val->idrg;?>')"><i class="fa fa-edit"></i></button>
                                                <?php }
                                                ?>
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

<form method="POST" id="formeditRuang" class="form-horizontal">
<div class="modal fade" id="editModalRuang" role="dialog" data-backdrop="static" data-keyboard="false">
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
                        <input type="text" class="form-control" name="edit_nmtindakan_ruang" id="edit_nmtindakan_ruang" disabled>
                        <input type="hidden" class="form-control" name="nmtindakan_hide_ruang" id="nmtindakan_hide_ruang">
                        <input type="hidden" class="form-control" name="noreg_hide_ruang" id="noreg_hide_ruang">
                        <input type="hidden" class="form-control" name="noipd_ruang" id="noipd_ruang">
                        <input type="hidden" class="form-control" name="idrg" id="idrg">
                        <input type="hidden" class="form-control" name="keltindakan_hide_ruang" id="keltindakan_hide_ruang">
                        <input type="hidden" class="form-control" name="subkelompok_hide_ruang" id="subkelompok_hide_ruang">
                        <input type="hidden" class="form-control" name="kategori_hide_ruang" id="kategori_hide_ruang">
                        <input type="hidden" class="form-control" name="satuan_hide_ruang" id="satuan_hide_ruang">
                      </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                      <p class="col-sm-4 form-control-label" id="lbl_nama">Tarif RS</p>
                      <p class="col-sm-4 form-control-label" id="lbl_nama">Tarif INA-CBG</p>
                      <p class="col-sm-4 form-control-label" id="lbl_nama">Rupiah Realisasi</p>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-4">
                        <input type="number" class="form-control" name="vol_umum_ruang" id="vol_umum_ruang" step="100" min="0">
                      </div>
                      <div class="col-sm-4">
                        <input type="number" class="form-control" name="ina-cbg_ruang" id="ina-cbg_ruang" step="100" min="0">
                      </div>
                      <div class="col-sm-4">
                        <input type="number" class="form-control" name="tarif_umum_ruang" id="tarif_umum_ruang" step="100" min="0">
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="button" id="btnEditRuang" class="btn btn-primary" onclick="submitTarifBpjsRuang()">Insert</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<form method="POST" id="formeditRuangIks" class="form-horizontal">
<div class="modal fade" id="editModalRuangIks" role="dialog" data-backdrop="static" data-keyboard="false">
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
                        <input type="text" class="form-control" name="edit_nmtindakan_ruang_iks" id="edit_nmtindakan_ruang_iks" disabled>
                        <input type="hidden" class="form-control" name="nmtindakan_hide_ruang_iks" id="nmtindakan_hide_ruang_iks">
                        <input type="hidden" class="form-control" name="noreg_hide_ruang_iks" id="noreg_hide_ruang_iks">
                        <input type="hidden" class="form-control" name="noipd_ruang_iks" id="noipd_ruang_iks">
                        <input type="hidden" class="form-control" name="idrg_iks" id="idrg_iks">
                        <input type="hidden" class="form-control" name="keltindakan_hide_ruang_iks" id="keltindakan_hide_ruang_iks">
                        <input type="hidden" class="form-control" name="subkelompok_hide_ruang_iks" id="subkelompok_hide_ruang_iks">
                        <input type="hidden" class="form-control" name="kategori_hide_ruang_iks" id="kategori_hide_ruang_iks">
                        <input type="hidden" class="form-control" name="satuan_hide_ruang_iks" id="satuan_hide_ruang_iks">
                      </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                      <p class="col-sm-6 form-control-label" id="lbl_nama">Tarif RS</p>
                      <p class="col-sm-6 form-control-label" id="lbl_nama">Rupiah Realisasi</p>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-6">
                        <input type="number" class="form-control" name="vol_umum_ruang_iks" id="vol_umum_ruang_iks" step="100" min="0">
                      </div>
                      <div class="col-sm-6">
                        <input type="number" class="form-control" name="tarif_umum_ruang_iks" id="tarif_umum_ruang_iks" step="100" min="0">
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="button" id="btnEditRuangIks" class="btn btn-primary" onclick="submitTarifIksRuang()">Insert</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<form method="POST" id="formedit" class="form-horizontal">
<div class="modal fade" id="editModalBpjs" role="dialog" data-backdrop="static" data-keyboard="false">
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
                        <input type="hidden" class="form-control" name="nmtindakan_hide" id="nmtindakan_hide">
                        <input type="hidden" class="form-control" name="noreg_hide" id="noreg_hide">
                        <input type="hidden" class="form-control" name="noipd" id="noipd">
                        <input type="hidden" class="form-control" name="idtindakan_hide" id="idtindakan_hide">
                        <input type="hidden" class="form-control" name="keltindakan_hide" id="keltindakan_hide">
                        <input type="hidden" class="form-control" name="subkelompok_hide" id="subkelompok_hide">
                        <input type="hidden" class="form-control" name="kategori_hide" id="kategori_hide">
                        <input type="hidden" class="form-control" name="satuan_hide" id="satuan_hide">
                      </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                      <p class="col-sm-4 form-control-label" id="lbl_nama">Tarif RS</p>
                      <p class="col-sm-4 form-control-label" id="lbl_nama">Tarif INA-CBG</p>
                      <p class="col-sm-4 form-control-label" id="lbl_nama">Rupiah Realisasi</p>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-4">
                        <input type="number" class="form-control" name="vol_umum" id="vol_umum" step="100" min="0">
                      </div>
                      <div class="col-sm-4">
                        <input type="number" class="form-control" name="ina-cbg" id="ina-cbg" step="100" min="0">
                      </div>
                      <div class="col-sm-4">
                        <input type="number" class="form-control" name="tarif_umum" id="tarif_umum" step="100" min="0">
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="button" id="btnEdit" class="btn btn-primary" onclick="submitTarifBpjs()">Insert</button>
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
                        <input type="hidden" class="form-control" name="nmobat_hide" id="nmobat_hide">
                        <input type="hidden" class="form-control" name="noreg_hide_obat" id="noreg_hide_obat">
                        <input type="hidden" class="form-control" name="noipd_obat" id="noipd_obat">
                        <input type="hidden" class="form-control" name="idobat_hide" id="idobat_hide">
                        <input type="hidden" class="form-control" name="keltindakan_hide_obat" id="keltindakan_hide_obat">
                        <input type="hidden" class="form-control" name="subkelompok_hide_obat" id="subkelompok_hide_obat">
                        <input type="hidden" class="form-control" name="kategori_hide_obat" id="kategori_hide_obat">
                        <input type="hidden" class="form-control" name="satuan_hide_obat" id="satuan_hide_obat">
                      </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                      <p class="col-sm-4 form-control-label" id="lbl_nama">Tarif RS</p>
                      <p class="col-sm-4 form-control-label" id="lbl_nama">Tarif INA-CBG</p>
                      <p class="col-sm-4 form-control-label" id="lbl_nama">Rupiah Realisasi</p>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-4">
                        <input type="number" class="form-control" name="vol_umum_obat" id="vol_umum_obat" step="100" min="0">
                      </div>
                      <div class="col-sm-4">
                        <input type="number" class="form-control" name="ina-cbg_obat" id="ina-cbg_obat" step="100" min="0">
                      </div>
                      <div class="col-sm-4">
                        <input type="number" class="form-control" name="tarif_umum_obat" id="tarif_umum_obat" step="100" min="0">
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="button" id="btnEditObat" class="btn btn-primary" onclick="submitObatBpjs()">Insert</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<form method="POST" id="formeditIks" class="form-horizontal">
<div class="modal fade" id="editModalIks" role="dialog" data-backdrop="static" data-keyboard="false">
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
                        <input type="text" class="form-control" name="edit_nmtindakan_iks" id="edit_nmtindakan_iks" disabled>
                        <input type="hidden" class="form-control" name="nmtindakan_hide_iks" id="nmtindakan_hide_iks">
                        <input type="hidden" class="form-control" name="noreg_hide_iks" id="noreg_hide_iks">
                        <input type="hidden" class="form-control" name="noipd_iks" id="noipd_iks">
                        <input type="hidden" class="form-control" name="idtindakan_hide_iks" id="idtindakan_hide_iks">
                        <input type="hidden" class="form-control" name="keltindakan_hide_iks" id="keltindakan_hide_iks">
                        <input type="hidden" class="form-control" name="subkelompok_hide_iks" id="subkelompok_hide_iks">
                        <input type="hidden" class="form-control" name="kategori_hide_iks" id="kategori_hide_iks">
                        <input type="hidden" class="form-control" name="satuan_hide_iks" id="satuan_hide_iks">
                      </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                      <p class="col-sm-6 form-control-label" id="lbl_nama">Tarif RS</p>
                      <p class="col-sm-6 form-control-label" id="lbl_nama">Rupiah Realisasi</p>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-6">
                        <input type="number" class="form-control" name="vol_umum_iks" id="vol_umum_iks" step="100" min="0">
                      </div>
                      <div class="col-sm-6">
                        <input type="number" class="form-control" name="tarif_umum_iks" id="tarif_umum_iks" step="100" min="0">
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="button" id="btnEditIks" class="btn btn-primary" onclick="submitTarifIks()">Insert</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<form method="POST" id="formeditObatIks" class="form-horizontal">
<div class="modal fade" id="editModalObatIks" role="dialog" data-backdrop="static" data-keyboard="false">
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
                        <input type="text" class="form-control" name="nmobat_iks" id="nmobat_iks" disabled>
                        <input type="hidden" class="form-control" name="nmobat_hide_iks" id="nmobat_hide_iks">
                        <input type="hidden" class="form-control" name="noreg_hide_obat_iks" id="noreg_hide_obat_iks">
                        <input type="hidden" class="form-control" name="noipd_obat_iks" id="noipd_obat_iks">
                        <input type="hidden" class="form-control" name="idobat_hide_iks" id="idobat_hide_iks">
                        <input type="hidden" class="form-control" name="keltindakan_hide_obat_iks" id="keltindakan_hide_obat_iks">
                        <input type="hidden" class="form-control" name="subkelompok_hide_obat_iks" id="subkelompok_hide_obat_iks">
                        <input type="hidden" class="form-control" name="kategori_hide_obat_iks" id="kategori_hide_obat_iks">
                        <input type="hidden" class="form-control" name="satuan_hide_obat_iks" id="satuan_hide_obat_iks">
                      </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                      <p class="col-sm-6 form-control-label" id="lbl_nama">Tarif RS</p>
                      <p class="col-sm-6 form-control-label" id="lbl_nama">Rupiah Realisasi</p>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-6">
                        <input type="number" class="form-control" name="vol_umum_obat_iks" id="vol_umum_obat_iks" step="100" min="0">
                      </div>
                      <div class="col-sm-6">
                        <input type="number" class="form-control" name="tarif_umum_obat_iks" id="tarif_umum_obat_iks" step="100" min="0">
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="button" id="btnEditObatIks" class="btn btn-primary" onclick="submitObatIks()">Insert</button>
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
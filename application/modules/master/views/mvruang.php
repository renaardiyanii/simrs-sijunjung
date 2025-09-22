<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?>
<script type='text/javascript'>

  
function lihatBed(data)
    {
        ambilBed(data.kodekelas);
        $("#myBed").modal('show');
    }

    function ambilBed(kelas)
    {
        // hasilBedJKN
        $.ajax({
            url: '<?= base_url('/master/mcruang/getallbedaktif') ?>',
            beforeSend: function() {
                let html = `<tr><td colspan="3">Silahkan Ditunggu...</td></tr>`;
                $("#hasilBedJKNBridging").html(html);

            },
            success: function(data) {
                let html ='';
                let index = 1;
                if(data)
                {
                    data.map((e)=>{
                        html+=`<tr>
                            <td>${index}</td>
                            <td>${e.bed}</td>
                            <td>${e.kelas}</td>
                            <td>${e.nmruang}</td>
                            <td>
                                <input type="checkbox" name="bed-${kelas}[]" id="bed-${e.bed}" value="${e.bed}" ${e.kelasjkn == kelas?'checked':(e.kelasjkn == null?'':'disabled')} />
                                <label class="checkbox-label" for="bed-${e.bed}"></label>
                            </td>
                        </tr>`;
                        index++;
                    });
                }else{
                    html+=`<tr><td colspan="3">Data Kosong</td></tr>`;
                }
                $("#hasilBedJKNBridging").html(html+=`
                `);
            },
            error: function(xhr) { // if error occured
                let html = `<tr><td colspan="3">Data Gagal Dimuat , silahkan kontak Tim IT SIRS</td></tr>`;
                $("#hasilBedJKNBridging").html(html);
            },
            complete: function() {
                
            },
        });
    }


    function get_kelas_jkn()
    {
        $.ajax({
            url: '<?= base_url('/bpjs/aplicares/refkamar') ?>',
            beforeSend: function() {
                let html = `<tr><td colspan="3">Silahkan Ditunggu...</td></tr>`;
                $("#hasilKelasJkn").html(html);

            },
            success: function(data) {
                let html ='';
                let index = 1;
                if(data.metadata.code = 1)
                {
                    data.response.list.map((e)=>{
                        html+=`<tr>
                            <td>${index}</td>
                            <td>${e.namakelas}</td>
                            <td>
                            <button class="btn btn-xs btn-primary" onclick='lihatBed(${JSON.stringify(e)})'>Lihat Detail</button>
                            </td>
                        </tr>`;
                        index++;
                    });
                }else{
                    html+=`<tr><td colspan="3">${data.metadata.message}</td></tr>`;
                }
                $("#hasilKelasJkn").html(html);
            },
            error: function(xhr) { // if error occured
                let html = `<tr><td colspan="3">Data Gagal Dimuat , silahkan kontak Tim IT SIRS</td></tr>`;
                $("#hasilKelasJkn").html(html);
            },
            complete: function() {
                
            },
        });
    }

    function simpanKelasJkn(){
        let data = $("#simpanjkn").serialize();
        $.ajax({
            url: '<?= base_url('/master/mcruang/insert_jkn_kelas') ?>',
            method: "POST",
            data:data,
            beforeSend: function() {

            },
            success: function(data) {
              alert(data.message);
            },
            error: function(xhr) { 
            },
            complete: function() {
                
            },
        });
    }
  //-----------------------------------------------Data Table
  $(document).ready(function() {
    get_kelas_jkn();

    $('#table-ruangan').DataTable({
      "columnDefs": [
        { "orderable": false, "targets": 5 }
      ]
    });
    $('#table-bed').DataTable({
      "columnDefs": [
        { "orderable": false, "targets": 7 }
      ]
    });
  } );
  //---------------------------------------------------------

  $(function() {
    $('#date_picker').datepicker({
      format: "yyyy-mm-dd",
      endDate: '0',
      autoclose: true,
      todayHighlight: true,
    });  
  }); 

  function edit_ruang(idrg) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcruang/get_data_edit_ruang')?>",
      data: {
        idrg: idrg
      },
      success: function(data){
        $('#edit_id_ruang_hidden').val(data[0].id_ruang);
        $('#edit_idrg').val(data[0].idrg);
        $('#edit_idrg_hidden').val(data[0].idrg);
        $('#edit_kelas_ruang').val(data[0].kelas);
        $('#edit_nmruang').val(data[0].nmruang);
        $('#edit_jumlah_tt').val(data[0].jumlah_tt);
        $('#edit_aktif').val(data[0].aktif);
        $('#edit_vvip').val(data[0].VVIP);
        $('#edit_vip').val(data[0].VIP);
        $('#edit_utama').val(data[0].UTAMA);
        $('#edit_i').val(data[0].I);
        $('#edit_ii').val(data[0].II);
        $('#edit_iii').val(data[0].III);
      },
      error: function(){
        alert("error");
      }
    });
  }

  function edit_bed(bed) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcruang/get_data_edit_bed')?>",
      data: {
        bed: bed
      },
      success: function(data){        
        $('#edit_bed_hidden').val(data[0].bed);
        $('#edit_idrg_bed').val(data[0].idrg);
        $('#edit_idrg_hidden_bed').val(data[0].idrg);
        $('#edit_no_bed').val(data[0].no_bed);
        $('#edit_no_bed_hidden').val(data[0].no_bed);
        $('#edit_nmruang_bed').val(data[0].idrg).change();
        $('#edit_kelas').val(data[0].kelas);
        $('#edit_isi').val(data[0].isi);
        $('#edit_status').val(data[0].status);
        if(parseInt(data[0].aktif)>0){
          document.getElementById("btn-editbed").disabled=false;
        }else{
          document.getElementById("btn-editbed").disabled=false;
        }
      },
      error: function(){
        alert("error");
      }
    });
  }

  function get_banyak_bed(kelas) {
    var idrg=document.getElementById("idrg").value;
    if(idrg==''){
      alert('Mohon Pilih Ruangan');
    } else {
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('master/mcruang/get_banyak_bed')?>",
        data: {
          idrg: idrg,
          kelas:  kelas
        },
        success: function(data){
          if(data==''){
            $('#no_bed').val('0');
            $('#no_bed_hidden').val('0');
          } else {
            $('#no_bed').val(data[0].banyak);
            $('#no_bed_hidden').val(data[0].banyak);
          }
         
        },
        error: function(){
          alert("error");
        }
      });
    }
  }

  function hapus_bed(bed){
    if (confirm('Yakin Menghapus Bed?')) {
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('master/mcruang/hapus_bed')?>",
        data: {
          bed: bed
        },
        success: function(data){
          location.reload();
        },
        error: function(){
          location.reload();
        }
      });
    } 
  }

  function nonaktif_bed(bed,isi){
    if (confirm('Yakin Nonaktif Bed?')) {
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('master/mcruang/nonaktif_bed')?>",
        data: {
          bed: bed,
          isi:isi
        },
        success: function(data){
          location.reload();
        },
        error: function(){
          location.reload();
        }
      });
    } 
  }


</script>
<section class="content-header">
  <?php
    echo $this->session->flashdata('success_msg');
  ?>
</section>

<section class="content">
  <div class="row" id="row">
    <div class="col-sm-12">
      <div class="card card-outline-primary">
        <div class="card-header">
          <h4 class="text-white">DAFTAR RUANGAN</h4>
        </div>
        <div class="card-block">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myRuang" title="Tambah Ruangan"><i class="fa fa-plus"></i> Ruangan Baru</button>       
          <div class="p-20">
            <table id="table-ruangan" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th class="text-center">No</th>
                  <th>ID Ruang</th>
                  <th>Nama Ruang</th>
                  <th>Kelas</th>
                  <th>Tarif</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    $i=1;
                    foreach($ruang as $row){
                ?>
                <tr>
                  <td class="text-center"><?php echo $i++;?></td>
                  <td><?php echo $row->idrg;?></td>
                  <td><?php echo $row->nmruang;?></td>
                  <td><?php echo $row->kelas;?></td>
                  <td><?php echo $row->tarif;?></td>
                  <td class="text-center"><?php echo $row->aktif;?></td>
                  <td class="text-center">                             
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" title="Edit Ruangan" data-target="#editModalRuang" onclick="edit_ruang('<?php echo $row->idrg;?>')"><i class="fa fa-edit"></i> Edit</button>      
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <br/> 
          
      </div>
    </div>

    <div class="col-sm-12">
      <div class="card card-outline-success">
        <div class="card-header">
          <h4 class="text-white">DAFTAR BED</h4>
        </div>
        <div class="card-block">
          <div class="col-sm-3" align="left">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myBed" title="Tambah Bed"><i class="fa fa-plus"></i> Bed Baru</button>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->
          <br/>           
          <table id="table-bed" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>ID Ruang</th>
                <th>Nama Ruang</th>
                <th>Kelas</th>
                <th>No Bed</th>
                <th>Status</th>
                <th class="text-center">Ruangan</th>
                <th>Keterangan</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $i=1;
                  foreach($bed as $row){
              ?>
              <tr>
                <td class="text-center"><?php echo $i++;?></td>
                <td><?php echo $row->idrg;?></td>
                <td><?php echo $row->nmruang;?></td>
                <td><?php echo $row->kelas;?></td>
                <td><?php echo $row->no_bed;?></td>
                <td><?= $row->aktif==NULL?'AKTIF':$row->aktif ?></td>
                <td>
                <?php 
                if($row->isi=='Y'){
                    echo "
                          <button type='button' class='btn-danger btn-sm text' disabled>
                          <h6 class='text-white'><i class='icon fa fa-ban'></i> Bed Terisi</h6>
                          </button>
                        ";
                  } else{
                    echo "
                          <button type='button' class='btn-success btn-sm' disabled>
                          <h6 style='color: #ededed;'><i class='icon fa fa-check'></i> Bed Kosong</h6>
                          </button>
                        ";
                  }
                ?>
                </td>
                <td class="text-center">
                <?php 
                if($row->status=='1'){
                    echo "
                          <h6>Utama</h6>
                        ";
                  } else{
                    echo "
                          <h6>Cadangan</h6>
                        ";
                  }
                ?>
                </td>
                <td class="text-center">                  
                  <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#editModal" title="Edit Bed"  onclick="edit_bed('<?php echo $row->bed;?>')"><i class="fa fa-edit"></i> Edit</button>
                  <button type="button" class="btn <?= $row->aktif!=null?'btn-info':'btn-danger' ?> btn-sm" title="Nonaktif Ruangan" onclick="nonaktif_bed('<?php echo $row->bed;?>','<?= $row->aktif!=null?NULL:'TIDAK AKTIF' ?>')"><i class="fa fa-delete"></i><?= $row->aktif!=null?'Aktifkan':'Non - Aktifkan' ?></button>
                  
                  <button type="button" class="btn btn-danger btn-sm btn-block" title="Hapus Bed"  onclick="hapus_bed('<?php echo $row->bed;?>')"><i class="fa fa-trash"></i> Hapus</button>                  
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <?php echo form_open('master/mcruang/edit_ruang');?>
            <!-- Modal Edit Obat -->
            <div class="modal fade" id="editModalRuang" role="dialog" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog modal-success modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Ruang</h4>
                  </div>
                  <div class="modal-body">
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Id Ruang</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_idrg" id="edit_idrg" disabled="">
                        <input type="hidden" class="form-control" name="edit_idrg_hidden" id="edit_idrg_hidden">
                        <input type="hidden" class="form-control" name="edit_id_ruang_hidden" id="edit_id_ruang_hidden">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Nama Ruang</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_nmruang" id="edit_nmruang">
                      </div>
                    </div>
                    <div class="col-sm-1"></div>
                    <p>* Nama Ruangan tidak diperkenankan menggunakan tanda ' - '</p>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Kelas</p>
                      <div class="col-sm-6">
                          <select class="form-control" name="edit_kelas_ruang" id="edit_kelas_ruang">
                            <?php 
                            foreach($kelas as $row){
                                echo '<option value="'.$row->kelas.'">'.$row->kelas.'</option>';
                              }?>
                          </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Status</p>
                      <div class="col-sm-6">
                        <select class="form-control" name="edit_aktif" id="edit_aktif">
                          <option value="Active">Active</option>
                          <option value="Tidak Active">Tidak Active</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Jumlah Tempat Tidur</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_jumlah_tt" id="edit_jumlah_tt">
                      </div>
                    </div>
                    
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Edit Ruang</button>
                  </div>
                </div>
              </div>
            </div>
          <?php echo form_close();?>

          <?php echo form_open('master/mcruang/edit_bed');?>
            <!-- Modal Edit Obat -->
            <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog modal-success">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Bed</h4>
                  </div>
                  <div class="modal-body">
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Id Ruang</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_idrg_bed" id="edit_idrg_bed" disabled="">
                        <input type="hidden" class="form-control" name="edit_idrg_hidden_bed" id="edit_idrg_hidden_bed">
                        <input type="hidden" class="form-control" name="edit_bed_hidden" id="edit_bed_hidden">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">No Bed</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_no_bed" id="edit_no_bed" disabled="">
                        <input type="hidden" class="form-control" name="edit_no_bed_hidden" id="edit_no_bed_hidden">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Nama Ruang</p>
                      <div class="col-sm-6">
                        <select id="edit_nmruang_bed" class="form-control" name="edit_nmruang_bed" required>
                          <option value="" disabled selected="">-Pilih Ruangan-</option>
                          <?php 
                            foreach($ruang as $row){
                              echo '<option value="'.$row->idrg.'">'.$row->nmruang.'</option>';
                            }
                          ?>
                        </select>
                        <!-- <input type="text" class="form-control" name="edit_nmruang_bed" id="edit_nmruang_bed"> -->
                      </div>
                    </div>                 
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Kelas</p>
                      <div class="col-sm-6">
                        <select class="form-control" name="edit_kelas" id="edit_kelas">
                          <?php 
                          foreach($kelas as $row){
                              echo '<option value="'.$row->kelas.'">'.$row->kelas.'</option>';
                            }?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Status</p>
                      <div class="col-sm-6">
                        <select class="form-control" name="edit_isi" id="edit_isi" required>
                          <option value="Y">ISI</option>
                          <option value="N">KOSONG</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Keterangan</p>
                      <div class="col-sm-6">
                        <select class="form-control" name="edit_status" id="edit_status" required>
                          <option value="1">UTAMA</option>
                          <option value="2">CADANGAN</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="btn-editbed">Edit Bed</button>
                  </div>
                </div>
              </div>
            </div>
          <?php echo form_close();?>

        </div>
      </div>
    </div>


    <div class="col-sm-12">
    <div class="card card-outline-success">
    <div class="card-header">
        <h4 class="text-white">DAFTAR Kelas JKN</h4>
    </div>
    <div class="card-block">
        <div class="col-sm-3" align="left">
        <div class="input-group">
            <span class="input-group-btn">
            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myBed" title="Tambah Bed"><i class="fa fa-plus"></i> Bed Baru</button> -->
            </span>
        </div><!-- /input-group --> 
        </div><!-- /col-lg-6 -->
        <br/>  

        <table class="table" width="100%">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Nama Kelas</th>
                    <th>Bed</th>
                </tr>
                
            </thead>
              <tbody id="hasilKelasJkn">

              </tbody>

        </table>

    </div>
    </div>
</div>
</div>

<form id="simpanjkn">

  <div class="modal fade" id="myBedJKN" role="dialog" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-success modal-lg">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="title_modal">Daftar Bed </h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
              <div class="modal-body">

                  <table class="table table-responsive">
                      <thead>
                          <tr>
                              <th>No.</th>
                              <th>Bed</th>
                              <th>Kelas</th>
                              <th>Nama Ruang</th>
                              <th>Aksi</th>
                          </tr>
                      </thead>
                      
                          <tbody id="hasilBedJKNBridging">
                            
                          </tbody>
                      
                  </table>
              
                
              </div>
              <div class="modal-footer">
                <button class="btn btn-primary" type="button" onclick="simpanKelasJkn()" >Simpan</button>
                  
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>
</form>

</section>
    <?php echo form_open('master/mcruang/insert_bed');?>    
      <div class="modal fade" id="myBed" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-success">
          <!-- Modal content-->
          <div class="modal-content">
           <div class="modal-header">
                  <h4 class="modal-title" id="title_modal">Tambah Bed Baru</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
            <div class="modal-body">
              <div class="form-group row">
                <div class="col-sm-1"></div>
                <p class="col-sm-3 form-control-label" id="lbl_nmruang">Ruangan</p>
                <div class="col-sm-6">
                  <select id="idrg" class="form-control" name="idrg" required>
                    <option value="" disabled selected="">-Pilih Ruangan-</option>
                    <?php 
                      foreach($ruang as $row){
                        echo '<option value="'.$row->idrg.'">'.$row->nmruang.'</option>';
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-1"></div>
                <p class="col-sm-3 form-control-label" id="lbl_kelas">Kelas</p>
                <div class="col-sm-6">
                  <select class="form-control" name="kelas" id="kelas" onclick="get_banyak_bed(this.value)" required>
                    <option value="" disabled selected="">-Pilih Kelas-</option>
                    <?php 
                    foreach($kelas as $row){
                       echo '<option value="'.$row->kelas.'">'.$row->kelas.'</option>';
                      }?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-1"></div>
                <p class="col-sm-3 form-control-label" id="lbl_kelas">Ruangan</p>
                <div class="col-sm-6">
                  <select class="form-control" name="status" id="status">
                    <option value="1">UTAMA</option>
                    <option value="2">CADANGAN</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-1"></div>
                <p class="col-sm-3 form-control-label" id="lbl_nmbed">Banyak Bed Sekarang</p>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="no_bed" id="no_bed" disabled="">
                  <input type="hidden" class="form-control" name="no_bed_hidden" id="no_bed_hidden">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button class="btn btn-primary" type="submit">Insert Bed</button>
            </div>
          </div>
        </div>
      </div>
    <?php echo form_close();?>

    <?php echo form_open('master/mcruang/insert_ruang');?>        
      <div class="modal fade" id="myRuang" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-success">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
                  <h4 class="modal-title" id="title_modal">Tambah Ruangan Baru</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
            <div class="modal-body">
              <div class="form-group row">
                <div class="col-sm-1"></div>
                <p class="col-sm-3 form-control-label" id="lbl_nmruang">Nama Ruangan</p>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="ruang_nmruangan" id="ruang_nmruangan">                    
                </div>
              </div>
              <div class="col-sm-1"></div>
              <p>* Nama Ruangan tidak diperkenankan menggunakan tanda ' - '</p>
              <div class="form-group row">
                <div class="col-sm-1"></div>
                <p class="col-sm-3 form-control-label" id="lbl_nmruang">Nomor Ruangan</p>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="ruang_noruangan" id="ruang_noruangan">                    
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-1"></div>
                <p class="col-sm-3 form-control-label" id="lbl_nmruang">Kelas</p>
                <div class="col-sm-6">
                  <select class="form-control" name="ruang_kelas" id="ruang_kelas">
                    <option value="" disabled selected="">-Pilih Kelas-</option>
                    <?php 
                    foreach($kelas as $row){
                        echo '<option value="'.$row->kelas.'">'.$row->kelas.'</option>';
                      }?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-1"></div>
                <p class="col-sm-3 form-control-label" id="lbl_nmruang">Tarif</p>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="ruang_tarif" id="ruang_tarif">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-1"></div>
                <p class="col-sm-3 form-control-label" id="lbl_nmruang">Jumlah Tempat Tidur</p>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="jumlah_tt" id="jumlah_tt">
                </div>
              </div>
              </div>
              <div class="modal-footer">
                <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit">Insert Ruangan</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php echo form_close();?>
<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>
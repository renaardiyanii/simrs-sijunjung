<?php if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
} ?>
<html>
<script type='text/javascript'>
  //-----------------------------------------------Data Table
  $(document).ready(function() {
    // $('#example').DataTable();
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });
  } );
  //---------------------------------------------------------

  $(function() {
    // $('#date_picker').datepicker({
    //   format: "yyyy-mm-dd",
    //   endDate: '0',
    //   autoclose: true,
    //   todayHighlight: true,
    // });
  });

  function hapus_data_kelompok(id_jenis_hasil_lab){
    swal({
      title: "Hapus Data",
      text: "Benar Akan Menghapus Data?",
      type: "info",
      showCancelButton: true,
      closeOnConfirm: false,
      showLoaderOnConfirm: true,
    },
    function(){
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('lab/mctindakanlab/delete_jenis_hasil_lab')?>/"+id_jenis_hasil_lab,
        success: function(data)
        {
          if(data.status) //if success close modal and reload ajax table
          {
            $("#tabel_lab").load("<?php echo base_url('lab/mctindakanlab/tindakan').'/'.$tindakan->idtindakan;?> #tabel_lab");
            swal({
              title: "Data Pemeriksaan Berhasil Dihapus.",
              timer: 2000,
              showConfirmButton: false,
              showCancelButton: true
            });
          }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          swal(textStatus);
        }
      });
    });
  }

  function save(){
    id_tindakan = $("#id_tindakan").val();
    jenis_hasil = $("#jenis_hasil").val();
    kadar_normal = $("#kadar_normal").val();
    satuan = $("#satuan").val();
    swal({
        title: "Tambah Data Kelompok",
        text: "Benar Akan Menyimpan Data?",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    },
    function(){
      $.ajax({
        url:"<?php echo base_url('lab/mctindakanlab/insert_jenis_hasil_lab')?>",
        type: "POST",
        data: {
          id_tindakan : id_tindakan,
          jenis_hasil : jenis_hasil,
          kadar_normal : kadar_normal,
          satuan : satuan
        },
        dataType: "JSON",
        success: function(data)
        {
          if(data.status) //if success close modal and reload ajax table
          {
            $("#tabel_lab").load("<?php echo base_url('lab/mctindakanlab/tindakan').'/'.$tindakan->idtindakan;?> #tabel_lab");
            swal({
              title: "Data Komponen Berhasil Disimpan.",
              timer: 2000,
              showConfirmButton: false,
              showCancelButton: true
            });
          }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          swal(textStatus);
        }
      });
    });
  }

</script>
<section class="content-header">
  <?php
    // echo $this->session->flashdata('success_msg');
    // $this->session->set_flashdata('success_msg', "");
    echo $this->session->tempdata('msg_success');
    $this->session->unset_tempdata('msg_success');
  ?>
</section>

<section class="content">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-block p-b-0">
          <a href="javascript:;" class="btn btn-success" onClick="return openUrl('<?php echo site_url('lab/mctindakanlab/'); ?>');"><i class="fa fa-arrow-left"></i> Kembali</a>
          <hr>
          <h4 class="card-title"><?=$tindakan->idtindakan;?></h4>
          <h6 class="card-subtitle"><?=$tindakan->nmtindakan;?></h6> 
        </div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs customtab" role="tablist">
          <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home2" role="tab" aria-expanded="true"><span class="hidden-sm-up"><i class="fa fa-file-text"></i></span> <span class="hidden-xs-down">Komponen Hasil</span></a> </li>
          <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile2" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="fa fa-dollar"></i></span> <span class="hidden-xs-down">Tarif</span></a> 
          </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane active" id="home2" role="tabpanel" aria-expanded="true">
              <div class="p-20">
                <h3>Komponen Hasil</h3>
                <div class="row">
                  <div class="col-md-12">
                    <div class="modal-body">
                      <h4 class="modal-title">Tambah Komponen Hasil</h4>
                      <hr>
                      <div class="col-sm-12">
                        <input type="hidden" class="form-control" name="id_tindakan" id="id_tindakan" value="<?=$tindakan->idtindakan;?>">
                        <div class="form-group row">
                          <p class="col-sm-3 form-control-label" id="lbl_jenis_hasil">Nama Jenis Hasil</p>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="jenis_hasil" id="jenis_hasil">
                          </div>
                        </div>
                        <div class="form-group row">
                          <p class="col-sm-3 form-control-label" id="lbl_kadar_normal">Kadar Normal</p>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="kadar_normal" id="kadar_normal">
                          </div>
                        </div>
                        <div class="form-group row">
                          <p class="col-sm-3 form-control-label" id="lbl_satuan">Satuan</p>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="satuan" id="satuan">
                          </div>
                        </div>
                      </div>
                      <div class="text-right">
                        <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                        <button class="btn btn-success" type="button" onclick="save()"> <i class="fa fa-save"></i> Tambah Komponen Hasil</button>
                      </div>
                      <hr>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <table id="tabel_lab" class="table display table-bordered table-striped">
                        <thead>
                          <tr>
                            <th class="text-center">No</th>
                            <th>Komponen Hasil</th>
                            <th>Kadar Normal</th>
                            <th>Satuan</th>
                            <th class="text-center">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $i=1;
                          foreach ($komponen_hasil as $row) {
                            echo '<tr><td class="text-center">'.$i++.'</td>';
                            echo '<td>'.$row->jenis_hasil.'</td>';
                            echo '<td>'.$row->kadar_normal.'</td>';
                            echo '<td>'.$row->satuan.'</td>';
                            echo '
                              <td class="text-center">
                                <button class="btn btn-danger" onclick="hapus_data_kelompok('.$row->id_jenis_hasil_lab.')"><i class="fa fa-trash"></i> Hapus</button>
                                </td>
                              </tr>';
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="tab-pane" id="profile2" role="tabpanel" aria-expanded="false">
            <div class="p-20">
                <h3>Tarif</h3>
                <div class="form-group row">
                  <p class="col-md-2 form-control-label">Kelas VVIP</p>
                  <div class="col-md-4">
                    <input type="number" class="form-control" name="kelas_vvip" id="kelas_vvip" step="100" min="0" value="<?=$tarif_vvip;?>" disabled>
                  </div>
                </div>
                <div class="form-group row">
                  <p class="col-md-2 form-control-label">Kelas VIP</p>
                  <div class="col-md-4">
                    <input type="number" class="form-control" name="kelas_vip" id="kelas_vip" step="100" min="0" value="<?=$tarif_vip;?>" disabled>
                  </div>
                </div>
                <div class="form-group row">
                  <p class="col-md-2 form-control-label">Kelas 1</p>
                  <div class="col-md-4">
                    <input type="number" class="form-control" name="kelas_1" id="kelas_1" step="100" min="0" value="<?=$tarif_1;?>" disabled>
                  </div>
                </div>
                <div class="form-group row">
                  <p class="col-md-2 form-control-label">Kelas 2</p>
                  <div class="col-md-4">
                    <input type="number" class="form-control" name="kelas_2" id="kelas_2" step="100" min="0" value="<?=$tarif_2;?>" disabled>
                  </div>
                </div>
                <div class="form-group row">
                  <p class="col-md-2 form-control-label">Kelas 3</p>
                  <div class="col-md-4">
                    <input type="number" class="form-control" name="kelas_3" id="kelas_3" step="100" min="0" value="<?=$tarif_3;?>" disabled>
                  </div>
                </div>
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

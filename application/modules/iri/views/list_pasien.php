<?php $this->load->view("layout/header_left"); ?>
<?php $this->load->view("iri/layout/script_addon"); ?>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>
<script src="<?php echo base_url('assets/sweetalert2@11.js') ?>"></script>
<script>
  $(document).ready(function() {
    $('.js-example-basic-single').select2();
  });
  // added @aldi batal pasien
  function batal_pasien(no_ipd, bed) {
    Swal.fire({
      title: 'Pembatal Pasien?',
      text: "Apakah Anda Yakin Membatalkan Pasien ?!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Batal Pasien!'
    }).then((result) => {
      if (result.isConfirmed) {

        $.ajax({
          url: '<?= base_url("iri/ricpasien/batal_pasien") ?>',
          type: "POST",
          data: {
            no_ipd: no_ipd,
            bed: bed,
          },
          dataType: "JSON",
          success: function(data) {
            console.log(data);
            Swal.fire(
              'Berhasil Hapus!',
              'Pembatalan Pasien Berhasil.',
              'success'
            );
          },
          error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire(
              'Gagal Hapus!',
              'Pembatalan Pasien Gagal.',
              'warning'
            );
          }
        });
      }
    });
  }


  //added amel (2/3/23)
  function diterima_pasien(no_ipd) {
    Swal.fire({
      title: 'Pasien Diterima?',
      text: "Apakah Pasien Sudah Memasuki Ruangan ?",
      // icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya'
    }).then((result) => {
      if (result.isConfirmed) {

        $.ajax({
          url: '<?= base_url("iri/ricpasien/diterima_pasien") ?>',
          type: "POST",
          data: {
            no_ipd: no_ipd
          },
          dataType: "JSON",
          success: function(data) {
            console.log(data);
            location.reload(true);
            Swal.fire(
              'Berhasil Simpan!',
              'Penerimaan Pasien Berhasil.',
              'success'
            );
          },
          error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire(
              'Gagal Simpan!',
              'Penerimaan Pasien Gagal.',
              'warning'
            );
          }
        });
      }
    });
  }

  function buatajax() {
    if (window.XMLHttpRequest) {
      return new XMLHttpRequest();
    }
    if (window.ActiveXObject) {
      return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
  }

  function ajaxdokter(id_poli) {
    var id = id_poli.substr(0, 4);
    var pokpoli = id_poli.substr(4, 4);

    ajaxku = buatajax();
    var url = "<?php echo site_url('iri/rictindakan/data_dokter_poli'); ?>";
    url = url + "/" + id;
    url = url + "/" + Math.random();
    ajaxku.onreadystatechange = stateChangedDokter;
    ajaxku.open("GET", url, true);
    ajaxku.send(null);

  }

  function stateChangedDokter() {
    var data;
    if (ajaxku.readyState == 4) {
      data = ajaxku.responseText;
      if (data.length >= 0) {
        document.getElementById("id_dokter").innerHTML = data;
      }
    }
  }

  function tindak(no_ipd) {
    //$.ajax({
    // type: "POST",
    // url: "<?php //echo base_url().'ird/rdcpelayananfdokter/update_waktu_masuk'; 
              ?>",
    // dataType: "JSON",
    // data: {'no_register' : no_register},
    //success: function(data){  
    //location.href = '<?php echo site_url('ird/rdcpelayananfdokter/pelayanan_tindakan'); ?>/'+id_poli+'/'+no_register; 
    $('.content').html('<div class="text-center"><span class="fa fa-refresh fa-spin"></span><h1>Please Wait ...</h1></div>');
    return openUrl('<?php echo site_url('iri/rictindakan/index'); ?>/' + no_ipd);
    // 	},
    // 	error:function(event, textStatus, errorThrown) {    
    // 		swal("Error","Gagal update waktu masuk.", "error");     
    // 		console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
    // 	}
    // }); 
  }
  $(document).ready(function() {
    $(".okbtn").on("mousedown", function() {
      var no_ipd = $(this).data('noipd');
      if (event.which === 1) {
        $('.content').html('<div class="text-center"><span class="fa fa-refresh fa-spin"></span><h1>Please Wait ...</h1></div>');
        return openUrl('<?php echo site_url('iri/rictindakan/index'); ?>/' + no_ipd);
      } else if (event.which === 3) {
        document.oncontextmenu = function() {
          return open('<?php echo site_url('iri/rictindakan/index'); ?>/' + no_ipd);
        };

        setTimeout(function() {
          document.oncontextmenu = function() {
            return false;
          }
        }, 1000);
      }
    });
  });
  //opeurl
</script>
<style>
  .text-white {
    color: green;
  }

  .bebas {
    background-color: #50CB93 !important;
  }

  .verifh_1{
    background-color: #96EFFF !important;
  }

  .batal {
    background-color: red !important;
  }

</style>
<section class="content" id="konten">
  <div class="col-lg-12 col-md-12">
    <?php echo $this->session->flashdata('pesan'); ?>
    <div class="card card-outline-info">
      <div class="card-header">
        <h5 class="m-b-0 text-white text-center">Pasien Dalam Perawatan</h5>
      </div>
      <div class="card-block">
        <!-- <h5 class="card-subtitle">Akses Ruangan : &nbsp;<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#roomModal" ><i class="fa fa-eye"></i></button></h5> -->

        
        <div class="table-responsive m-t-15">
          <table class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" id="list-pasien">
            <thead>
              <tr>
                <th>Aksi</th>
                <th>No. Register</th>
                <th>No. MedRec</th>
                <th>Nama</th>
                <th>Kamar</th>
                <th>Kelas</th>
                <th>Jatah Kelas</th>
                <th>No. Bed</th>
                <th>Tgl. Masuk</th>
                <th>Dokter Yang Merawat</th>
                <!-- <th>Ket TT</th> -->
                <th>Bayi</th>
                <th>PENJAMIN</th>
                <!-- <th>No. SEP</th> -->
                <!-- <th>Tgl Verif</th> -->

              </tr>
            </thead>
            <tbody>
              <?php
              if ($list_pasien != '') {
                foreach ($list_pasien as $r) {
                  $list_dokter = $this->rimdokter->select_drtambahan_iri($r['no_ipd']);
                  // var_dump($list_dokter); die();

                  $list_mutasi = $this->rimdokter->select_mutasi_pasien($r['no_ipd']);
              ?>
              <!-- <?php var_dump($r['nama_user']); ?> -->
                
                  <tr class="<?= $r['verifikasi_plg'] ? 'bebas' : ''; ?>">
                    <!-- <?php var_dump($r['nama_user']); ?> -->
                    <td class="<?= $r['verifikasi_plg'] ? 'bebas' : ''; ?>">
                     
                      <button data-noipd="<?php echo $r['no_ipd']; ?>" class="okbtn btn btn-primary btn-sm">Tindak</button>
                      <a href="<?php echo base_url(); ?>iri/ricmutasi/mutasi/<?php echo $r['no_ipd'] ?>"><button type="button" class="btn btn-default btn-sm"><i class="fa fa-plusthick"></i> Mutasi</button></a>
                      <a href="<?php echo base_url(); ?>iri/ricstatus/index/<?php echo $r['no_ipd'] ?>"><button type="button" class="btn btn-warning btn-sm"><i class="fa fa-plusthick"></i> Status</button></a>
                    </td>
                    <td class="<?= $r['verifikasi_plg'] ? 'bebas' : ''; ?>"><?php echo $r['no_ipd'] ?></td>
                    <td class="<?= $r['verifikasi_plg'] ? 'bebas' : ''; ?>"><?php echo $r['no_cm'] ?></td>
                    <td class="<?= $r['verifikasi_plg'] ? 'bebas' : ''; ?>"><?php echo $r['nama'] ?></td>
                    <td class="<?= $r['verifikasi_plg'] ? 'bebas' : ''; ?>"><?php echo $r['nmruang'] ?><br>
                      <?php foreach ($list_mutasi as $mut) {
                        echo $mut['nmruang'] . '(mutasi)<br>';
                      } ?>
                    </td>
                    <td class="<?= $r['verifikasi_plg'] ? 'bebas' : ''; ?>"><?php echo $r['kelas'] ?></td>
                    <td class="<?= $r['verifikasi_plg'] ? 'bebas' : ''; ?>"><?php echo $r['jatahklsiri'] ?></td>
                    <td class="<?= $r['verifikasi_plg'] ? 'bebas' : ''; ?>"><?php echo $r['bed'] ?><br>
                      <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onClick="edit_ruangan('<?php echo $r['no_ipd']; ?>')">Ganti Ruangan</button>
                    </td>
                    <td class="<?= $r['verifikasi_plg'] ? 'bebas' : ''; ?>">
                      <?php

                      echo date('d-m-Y', strtotime($r['tgl_masuk']));
                      ?>
                    </td>
                    <td class="<?= $r['verifikasi_plg'] ? 'bebas' : ''; ?>"><?php echo $r['dokter'] ?>(DPJP)<br>
                      <?php foreach ($list_dokter as $row) {
                        echo $row['nm_dokter'] . '(' . $row['modified_ket'] . ')<br>';
                      } ?><br>
                      <?php// if ($roleid == 1 || $roleid == 1012 || $roleid == 1027 || $roleid == 1038 || $roleid == 1011) { ?>
                        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editDokter" onClick="edit_ruangan('<?php echo $r['no_ipd']; ?>')">Ganti Dokter</button>
                      <?php //} ?>
                    </td>
                    
            
                    <td class="<?= $r['verifikasi_plg'] ? 'bebas' : ''; ?>"><?php
                                                                            if ($r['status_bayi'] == 0) {
                                                                              echo "Tidak Punya";
                                                                            } else {
                                                                              echo "Punya";
                                                                            }
                                                                            ?>
                    </td>
                    <!-- <td><?php //if($r['cara_bayar']=='BPJS' || $r['cara_bayar']=='DIJAMIN'){ echo $r['nmkontraktor']; } else echo $r['cara_bayar']; 
                              ?></td> -->
                    <td class="<?= $r['verifikasi_plg'] ? 'bebas' : ''; ?>">
                    <?php 
                      if($r['cara_bayar'] == 'KERJASAMA'){
                        echo $r['nmkontraktor'];
                      }else{
                        echo $r['cara_bayar'];
                      }
                      ?>
                   </td>
                   <!-- <td class="<?= $r['verifikasi_plg'] ? 'bebas' : ''; ?>">
                    <?php //echo $r['no_sep'] ?>

                   </td> -->

                 

                  </tr>
                
              <?php
                }
              }
              ?>
            <tfoot>
              <tr>
                <th>Aksi</th>
                <th>No. Register</th>
                <th>No. MedRec</th>
                <th>Nama</th>
                <th>Kamar</th>
                <th>Kelas</th>
                <th>Jatah Kelas</th>
                <th>No. Bed</th>
                <th>Tgl. Masuk</th>
                <th>Dokter Yang Merawat</th>
                <!-- <th>Ket TT</th> -->
                <th>Bayi</th>
                <th>PENJAMIN</th>
                <!-- <th>No. SEP</th> -->
                <!-- <th>Tgl Verif</th> -->

              </tr>
            </tfoot>
            </tbody>
          </table>
        </div><!-- style overflow -->
      </div>
      <!--- end panel body -->
    </div>
    <!--- end panel -->
  </div>
</section>
<!--- end row -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Admission</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('emedrec/C_emedrec_iri/cetak_general_consent'); ?>" method="post">
          <input type="hidden" name="user_id" value="">
          <button type="submit" class="list-group-item list-group-item-action" formtarget="_blank"> General Consent</button>
        </form>
        <form action="<?= base_url('emedrec/C_emedrec_iri/cetak_pengantar_iri'); ?>" method="post">
          <input type="hidden" name="user_id" value="">
          <button type="submit" class="list-group-item list-group-item-action" formtarget="_blank"> Surat Pengantar Rawat Inap</button>
        </form>
        <form action="<?= base_url('emedrec/C_emedrec_iri/surat_persetujuan'); ?>" method="post">
          <input type="hidden" name="user_id" value="">
          <button type="submit" class="list-group-item list-group-item-action" formtarget="_blank"> Surat Persetujuan</button>
        </form>
        <form action="<?= base_url('emedrec/C_emedrec_iri/surat_pernyatan_selisih_tarif'); ?>" method="post">
          <input type="hidden" name="user_id" value="">
          <input type="hidden" name="no_medrec" value="">
          <button type="submit" class="list-group-item list-group-item-action" formtarget="_blank"> Surat Pernyataan Selisih Tarif</button>
        </form>
        <form action="<?= base_url('emedrec/C_emedrec_iri/surat_persetujuan'); ?>" method="post">
          <input type="hidden" name="user_id" value="">
          <input type="hidden" name="no_medrec" value="">
          <button type="submit" class="list-group-item list-group-item-action" formtarget="_blank"> Tata Tertib Pasien </button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>


<!-- editDokter -->
<div class="modal fade" id="editDokter" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-success">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ganti Dokter</h4>
      </div>
      <div class="modal-body">
        <form action="#" id="formDokter" class="form-horizontal">
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label" id="lbl_nama">No Registrasi</p>
            <div class="col-sm-6">
              <input type="hidden" class="form-control" name="idrgiri" id="idrgiri">
              <input type="hidden" class="form-control" name="no_ipd" id="no_ipd">
              <input type="text" class="form-control" name="edit_no_ipd" id="edit_no_ipd" disabled="">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label" id="lbl_nama">No Medrec</p>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="edit_no_cm" id="edit_no_cm" disabled="">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label" id="lbl_nama">Nama Pasien</p>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="edit_nama" id="edit_nama" disabled="">
            </div>
          </div>
          <hr>
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label" id="lbl_nama">Dokter Dpjp Sekarang</p>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="edit_dpjp" id="edit_dpjp" disabled="">
              <input type="hidden" class="form-control" name="dpjp_asal" id="dpjp_asal">
            </div>
          </div>
          <hr>
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label" id="lbl_nama">Dokter Spesialis</p>
            <div class="col-sm-6">
              <select id="id_poli" class="form-control js-example-basic-single" style="width: 100%" name="id_poli_tujuan" onchange="ajaxdokter(this.value)" required>
                <option value="">-- Pilih Nama Poli --</option>
                <?php
                foreach ($poli as $row) {
                  echo '<option value="' . $row->id_poli . '' . $row->nm_pokpoli . '">' . $row->nm_poli . '</option>';
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label" id="lbl_nama">Dokter DPJP</p>
            <div class="col-sm-6">
              <select id="id_dokter" class="form-control js-example-basic-single" style="width: 100%" name="id_dokter_penerima" required>
                <option value="">-- Pilih Dokter --</option>
                <?php
                foreach ($dokter as $row) {
                  echo '<option value="' . $row->id_dokter . '">' . $row->nm_dokter . '</option>';
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label" id="lbl_nama">Keterangan</p>
            <div class="col-sm-6">
              <textarea name="ket_ganti_dpjp" id="ket_ganti_dpjp" cols="30" rows="5" required></textarea>
            </div>
          </div>
      </div>
      </form>
      <div class="modal-footer">
        <button type="button" id="btnEdit" onclick="gantiDPJP()" class="btn btn-primary">Ganti DPJP</button>
      </div>
    </div>
  </div>
</div>


<!-- eDIT Modal -->
<div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-success">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Ruangan</h4>
      </div>
      <div class="modal-body">
        <form action="#" id="formedit" class="form-horizontal">
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label" id="lbl_nama">No Registrasi</p>
            <div class="col-sm-6">
              <input type="hidden" class="form-control" name="idrgiri" id="idrgiri_ruang">
              <input type="hidden" class="form-control" name="no_ipd" id="no_ipd_ruang">
              <input type="text" class="form-control" name="edit_no_ipd" id="edit_no_ipd_ruang" disabled="">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label" id="lbl_nama">No Medrec</p>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="edit_no_cm" id="edit_no_cm_ruang" disabled="">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label" id="lbl_nama">Nama Pasien</p>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="edit_nama" id="edit_nama_ruang" disabled="">
            </div>
          </div>
          <hr>
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label" id="lbl_nama">Kode Ruang / Bed</p>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="edit_bed" id="edit_bed" disabled="">
              <input type="hidden" class="form-control" name="bed_asal" id="bed_asal">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label" id="lbl_nama">Nama Ruangan</p>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="edit_nmruang" id="edit_nmruang" disabled="">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label" id="lbl_nama">Kelas</p>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="edit_klsiri" id="edit_klsiri" disabled="">
            </div>
          </div>
          <hr>
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label" id="lbl_nama">Ganti Ruang</p>
            <div class="col-sm-6">
              <select id="ruang" class="form-control" name="ruang" onchange="get_bed(this.value)" required>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label" id="lbl_nama">Ganti Bed</p>
            <div class="col-sm-6">
              <select class="form-control input-sm" id="bed" name="bed" required>

              </select>
            </div>
          </div>
      </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="btnEdit" onclick="edit()" class="btn btn-primary">Edit Ruangan</button>
      </div>
    </div>
  </div>
</div>

<!-- show access room-->
<!-- eDIT Modal -->
<div class="modal fade" id="roomModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-success">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Akses Ruangan</h4>
      </div>
      <div class="modal-body">
        <?php foreach ($akses as $row) {
          echo '<span class="badge badge-danger ml-auto m-b-5" style="padding:5px;">' . $row->akses_ruang . '</span> ';
        }
        ?>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="edit-penanggungjawab" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-success">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Penanggungjawab Pasien</h4>
      </div>
      <div class="modal-body">
        <form id="formeditPenanggungjawab" class="form-horizontal">
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label">Nama</p>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="nmpjawabri" id="nmpjawabri">
              <input type="hidden" class="form-control" id="no_ipd_penanggungjawab" name="no_ipd">
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label">Jenis Kelamin</p>
            <div class="col-sm-6">
              <select id="jenkel" class="form-control" name="jenkel" >
                <option value="L">Laki - laki</option>
                <option value="P">Perempuan</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label">Alamat</p>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="alamatpjawabri" id="alamatpjawabri">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label">No. Telp/HP</p>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="notlppjawab" id="notlppjawab">
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label">No. Identitas</p>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="noidpjawab" id="noidpjawab">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label">Hubungan Keluarga</p>
            <div class="col-sm-6">
              <select id="hubpjawabri" class="form-control" name="hubpjawabri" >
                <option value="Suami">Suami</option>
                <option value="Istri">Istri</option>
                <option value="Ayah">Ayah</option>
                <option value="Ibu">Ibu</option>
                <option value="Saudara">Saudara</option>
                <option value="Anak">Anak</option>
              
              </select>
            </div>
          </div>
          
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label">Nama 1</p>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="namaaksespjawabri1" id="namaaksespjawabri1">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label">Nama 2</p>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="namaaksespjawabri2" id="namaaksespjawabri2">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-1"></div>
            <p class="col-sm-3 form-control-label">Nama 3</p>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="namaaksespjawabri3" id="namaaksespjawabri3">
            </div>
          </div>
      </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="btnEdit" onclick="submiteditpenanggungjawab()" class="btn btn-primary">Edit Ruangan</button>
      </div>
    </div>
  </div>
</div>


  <script>
    $(document).ready(function() {

      $('#exampleModal').on('show.bs.modal', function(e) {
        var userid = $(e.relatedTarget).data('noipd');
        var nomedrec = $(e.relatedTarget).data('nomedrec');
        // console.log(userid);
        $(e.currentTarget).find('input[name="user_id"]').val(userid);
        $(e.currentTarget).find('input[name="no_medrec"]').val(nomedrec);


      });
      $('#list-pasien tfoot th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Cari ' + title + '" />');
      });

      var dataTable = $('#list-pasien').DataTable({
        initComplete: function() {
          // Apply the search
          this.api().columns().every(function() {
            var that = this;

            $('input', this.footer()).on('keyup change clear', function() {
              if (that.search() !== this.value) {
                that
                  .search(this.value)
                  .draw();
              }
            });
          });
        }

      });
    });
    $('#calendar-tgl').datepicker();



    function edit_ruangan(no_ipd) {
      $('#edit_no_ipd').val('');
      $('#edit_no_ipd_hide').val('');
      $('#edit_no_cm').val('');
      $('#edit_nama').val('');
      $('#edit_bed').val('');
      $('#edit_nmruang').val('');
      $('#edit_klsiri').val('');
      $('#bed').val('');
      // $('#edit_paket').iCheck('uncheck');
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: "<?php echo base_url('iri/ricpasien/get_data_edit_ruangan') ?>",
        data: {
          no_ipd: no_ipd
        },
        success: function(data) {
          $('#idrgiri_ruang').val(data.response[0].idrgiri);
          $('#no_ipd_ruang').val(data.response[0].no_ipd);
          $('#edit_no_ipd_ruang').val(data.response[0].no_ipd);
          $('#edit_no_cm_ruang').val(data.response[0].no_cm);
          $('#edit_nama_ruang').val(data.response[0].nama);

          $('#edit_dpjp').val(data.response[0].nm_dokter);
          $('#dpjp_asal').val(data.response[0].id_dokter);

          $('#idrgiri').val(data.response[0].idrgiri);
          $('#no_ipd').val(data.response[0].no_ipd);
          $('#edit_no_ipd').val(data.response[0].no_ipd);
          $('#edit_no_cm').val(data.response[0].no_cm);
          $('#edit_nama').val(data.response[0].nama);
          $('#edit_bed').val(data.response[0].bed);
          $('#bed_asal').val(data.response[0].bed);
          $('#edit_nmruang').val(data.response[0].nmruang);
          $('#edit_klsiri').val(data.response[0].klsiri);

          var options, index, select, option;

          // Get the raw DOM object for the select box
          select = document.getElementById('ruang');

          // Clear the old options
          select.options.length = 0;

          // Load the new options
          options = data.options; // Or whatever source information you're working with
          select.options.add(new Option('Pilih Ruangan', ''));
          for (index = 0; index < options.length; ++index) {
            option = options[index];
            select.options.add(new Option(option.text, option.idrg));
          }
        },
        error: function() {
          alert("error");
        }
      });
    }



    function get_bed(val) {
      $('#bed')
        .find('option')
        .remove()
        .end();
      $("#bed").append("<option value=''>Loading...</option>");
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>iri/ricmutasi/get_empty_bed_select_ganti_ruang",
        data: {
          val: val
        },
      }).done(function(msg) {
        $('#bed')
          .find('option')
          .remove()
          .end();
        $("#bed").append(msg);
      });
    }

    function edit() {
      $('#btnEdit').text('saving...'); //change button text
      $('#btnEdit').attr('disabled', true); //set button disable 
      var url;

      url = "<?php echo site_url('iri/ricpasien/edit_ruangan') ?>";

      // ajax adding data to database
      $.ajax({
        url: url,
        type: "POST",
        data: $('#formedit').serialize(),
        dataType: "JSON",
        success: function(data) {

          $('#editModal').modal('hide');
          // alert('test');
          console.log(data);
          $('#btnEdit').text('Edit Ruangan'); //change button text
          $('#btnEdit').attr('disabled', false); //set button enable 

          if (data.sukses) {
            location.reload(true);
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR);
          console.log(textStatus);
          console.log(errorThrown);
          $('#editModal').modal('hide');
          // alert('Error adding / update data');
          $('#btnEdit').text('Edit Ruangan'); //change button text
          $('#btnEdit').attr('disabled', false); //set button enable 

        }
      });
    }

    function gantiDPJP() {
      $('#btnEdit').text('saving...'); //change button text
      $('#btnEdit').attr('disabled', true); //set button disable 
      var url;

      url = "<?php echo site_url('iri/ricpasien/gantiDPJP') ?>";

      // ajax adding data to database
      $.ajax({
        url: url,
        type: "POST",
        data: $('#formDokter').serialize(),
        dataType: "JSON",
        success: function(data) {

          // $('#editModal').modal('hide');

          $('#btnEdit').text('Ganti DPJP'); //change button text
          $('#btnEdit').attr('disabled', false); //set button enable 

          if (data.code === 200) {
            location.reload(true);
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $('#editModal').modal('hide');
          // alert('Error adding / update data');
          $('#btnEdit').text('Edit Ruangan'); //change button text
          $('#btnEdit').attr('disabled', false); //set button enable 

        }
      });
    }

    function editpenanggungjawabpasien(noipd)
    {
      $.ajax({
        url: '<?= base_url('iri/ricpendaftaran/get_penanggungjawab_pasien/') ?>' + noipd,
        success: function(data) {
          $("#nmpjawabri").val(data.nmpjawabri);
          $("#jenkel").val(data.jenkel);
          $("#alamatpjawabri").val(data.alamatpjawabri);
          $("#notlppjawab").val(data.notlppjawab);
          $("#noidpjawab").val(data.noidpjawab);
          $("#hubpjawabri").val(data.hubpjawabri);
          $("#namaaksespjawabri1").val(data.namaaksespjawabri1);
          $("#namaaksespjawabri2").val(data.namaaksespjawabri2);
          $("#namaaksespjawabri3").val(data.namaaksespjawabri3);
          $("#no_ipd_penanggungjawab").val(noipd);
        },
        error: function(jqXHR, textStatus, errorThrown) {
        
        }
      });
      $("#edit-penanggungjawab").modal('toggle');
    }

    function submiteditpenanggungjawab()
    {
      let data = $("#formeditPenanggungjawab").serialize();
      $.ajax({
        url: '<?= base_url('iri/ricpendaftaran/update_penanggung_jawab') ?>' ,
        data:data,
        dataType:'json',
        method:'post',
        success: function(data) {
          if(data.code === 200){
            Swal.fire(
                'Berhasil Diperbarui!',
                'Pembaruan Penanggungjawab Pasien Berhasil.',
                'success'
              );
              return;
          }
          Swal.fire(
              'Gagal Diperbarui!',
              'Pembaruan Penanggungjawab Pasien Gagal.',
              'error'
            );
        },
        error: function(jqXHR, textStatus, errorThrown) {
          Swal.fire(
              'Gagal Diperbarui!',
              'Pembaruan Penanggungjawab Pasien Gagal.',
              'error'
            );
        }
      });
    }
  </script>

  <?php
  // if ($role_id == 1) {
  $this->load->view("layout/footer_left");
  // } else {
  // $this->load->view("layout/footer_horizontal");
  // }
  ?>
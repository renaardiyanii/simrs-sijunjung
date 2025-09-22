<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left_emr");
        } else {
            $this->load->view("layout/header_left_emr");
        }
        // var_dump($data_pasien_irj);
        // var_dump($data_pasien_iri);
    ?>

<style>
  #customSearch {
    padding: 10px 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    width: 300px;
    font-size: 14px;
    margin-bottom: 15px;
    outline: none;
    transition: 0.3s ease;
  }

  #customSearch:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
  }
</style>


<script type='text/javascript'>
register = '<?= $register ?>';
register_old = '<?= $register_old ?>';

$(function() {
  if(register!=''){
    $('#modal_rawat_inap').modal('toggle');
    $('#modal_rawat_inap').modal('show');

    $('#modal_rawat_inap2').modal('toggle');
    $('#modal_rawat_inap2').modal('show');
  }else{
    console.log('gaada');
  }
  // $('#btn_elektromedik_irj').hide();
    $('#tbl-rawatjalan').DataTable({
          "language": {
          "emptyTable": "Data tidak tersedia."
          },
          "order": [[ 1, "desc" ]]
      });
      $('#tbl-rawatinap').DataTable({
          "language": {
          "emptyTable": "Data tidak tersedia."
          },
          "order": [[ 2, "desc" ]]
      });
     
      
     var table = $('#tableranap').DataTable({
          dom: 'tp', // Sembunyikan search bawaan
          language: {
            emptyTable: "Data tidak tersedia."
          }
        });
 
        // 🔎 Custom Search Box: cari berdasarkan kolom pertama (index 0)
        $('#customSearch').on('keyup', function () {
      
          table.column(0).search(this.value).draw();
        });
      
});
</script>
    
<?php echo $this->session->flashdata('success_msg'); ?>
    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">
          <div class=" form group row md-12">
            <div>
                <?php
                if ($data_pasien!="") {
                  foreach($data_pasien as $row){
                  ?>
                  <div class="container">
                    <div class="row">
                      <div class="col-sm-2">
                        <img height="120px" class="img-rounded" src="<?php echo base_url("assets/images/user.png");?>">
                      </div>
                      <div class="col-sm-10">
                      <table width="100%" style="margin-top:5px">
                          <tr>
                            <td width="20%">No.RM</td>
                            <td width="5%">:</td>
                            <td><?= $row->no_cm ?></td>
                          </tr>

                          <tr>
                            <td width="20%">Nama</td>
                            <td width="5%">:</td>
                            <td><?= $row->nama ?></td>
                          </tr>

                          <tr>
                            <td width="20%">Tempat,Tanggal Lahir</td>
                            <td width="5%">:</td>
                            <td><?= $row->tmpt_lahir.','.date('d-m-Y',strtotime($row->tgl_lahir)) ?></td>
                          </tr>

                          <tr>
                            <td width="20%">Alamat</td>
                            <td width="5%">:</td>
                            <td><?= $row->alamat ?></td>
                          </tr>
                      </table>
                      </div>
                    </div>
                    
                   
                  </div>
                 
              
                
                     
            
          


            <?php
              
              }}
              ?>
          </div>

          <div style="margin-top:50px">
          <a href="<?php echo site_url('emedrec/C_emedrec/cetak_identitas_awal/'.$row->no_cm); ?>" type="button" class="btn btn-primary"><i class="fas fa-user pr-1" aria-hidden="true"></i>Cetak Identitas Pasien</a>
          <a href="<?php echo site_url('emedrec/C_emedrec/cetak_cppt_rawat_jalan/'.$row->no_medrec.'/'.$row->no_cm); ?>" type="button" class="btn btn-warning"><i class="fas fa-print pr-2" aria-hidden="true"></i>Cetak CPPT Rawat Jalan</a>
          <!-- <a href="<?php //echo site_url('emedrec/C_emedrec_iri/get_cppt_iri/'.$row->no_medrec.'/'.$row->no_cm); ?>" type="button" class="btn btn-success"><i class="fas fa-print pr-2" aria-hidden="true"></i>Cetak CPPT Rawat Inap</a> -->
        
          <!-- <a href="<?php echo site_url('emedrec/C_emedrec//'.$row->no_medrec.'/'.$row->no_cm); ?>" type="button" class="btn btn-primary"><i class="fas fa-print pr-1" aria-hidden="true"></i>Formulir Registrasi</a> -->
          
        </div>

          <!--TABS-->
          <div class="card">
            <div class="card-header">
              <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="rj-tab" data-toggle="tab" href="#rawat_jalan" role="tab" aria-controls="rawat_jalan" aria-selected="true">RAWAT JALAN</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="rd-tab" data-toggle="tab" href="#rawat_darurat" role="tab" aria-controls="rawat_darurat" aria-selected="false">GAWAT DARURAT</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="ri-tab" data-toggle="tab" href="#rawat_inap" role="tab" aria-controls="rawat_inap" aria-selected="false">RAWAT INAP</a>
                </li>
               
              </ul>
            </div>
                    
          <!--END TABS -->

          

          <!-- TABS CONTENT -->
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="rawat_jalan" role="tabpanel" aria-labelledby="rj-tab">
           
              <br>
              <div class="table-responsive m-t-0">
                  <table id="tbl-rawatjalan" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                  <thead>
                      <tr>
                      <th>NO. REGISTRASI</th>
                      <th>TANGGAL</th>
                      <th>DOKTER</th>								
                      <th>POLIKLINIK</th>
                      <!-- <th>PRMRJ</th> -->
                      <th>Diagnosa</th>
                      <th>CPPT</th>
                      
                      <!-- <th>PENGKAJIAN MEDIS</th> -->
                      <!-- <th>STATUS PULANG</th> -->
                      <th>AKSI</th>
                      </tr>
                  </thead>
                  <tbody>
                  <?php
                      if ($data_pasien_irj != "") {
                      foreach($data_pasien_irj as $row){
                      ?>
                      <!-- <input type="hidden" name="no_register" value="<?= $row->noregister; ?>"> -->
                      <tr>
                          <td><?php echo $row->noregister;?></td>
                          <td><?php echo $row->tgl;?></td>
                          <td><?php echo $row->dokter;?></td>									
                          <td><?php echo $row->poli;?></td>
                      

                          <td><?php  
                          $a = $data['get_data_diagnos'] = $this->M_emedrec->get_diagnosa_pasien_utama($row->noregister)->row();
                          // var_dump($a);die();                          
                          if(isset($a)){
                            echo '<div style="text-align: center;">
                            <span style="font-weight:bold;font-size:12px;">';
                           echo $a->diagnosa ;
                            echo '</span>
                           </div>';
                          }else{
                            echo '<div style="text-align: center;">
                            <span style="font-size:17pt;">
                            -
                            </span>
                          </div>';
                          }

                          ?></td>
                          
                          <td><?php  
                          $a = $data['get_data_cppt'] = $this->M_emedrec->cek_cppt($row->noregister);
                          if (isset($a)){
                            if($a->subjective_dokter != null){
                              echo '<div style="text-align: center;">
                              <span style="font-weight:bold;font-size:20pt;">
                              ✓
                              </span>
                             </div>';
                            }else{
                              echo '<div style="text-align: center;">
                              <span style="font-size:17pt;">
                              ✖
                              </span>
                            </div>';
                            }
  
                          } else{
                            echo '<div style="text-align: center;">
                              <span style="font-size:17pt;">
                              ✖
                              </span>
                            </div>';
                          }                   
                         
                          ?></td>    
                          <td>
                          <a data-toggle="modal" data-poli="<?= $row->poli; ?>" data-id_poli="<?= $row->id_poli; ?>" data-userid="<?= $row->noregister; ?>"
                          href="#my_modal" 
                          class="btn btn-primary">Detail</a>
                          
                          <!-- <a href="#my_modal" data-toggle="modal">Detail</a> -->

                          </td>
                      </tr>
                      <?php } 
                      // }
                    }
                      ?>
                  </tbody>
                  </table>
              </div>
            </div>
            <div class="tab-pane fade" id="rawat_inap" role="tabpanel" aria-labelledby="ri-tab">
              <br>
                    <div class="table-responsive m-t-0">       
                      <table id="tbl-rawatinap" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                        <thead>
                          <tr>
                            <th>No. IPD</th>
                            <th>No. Registrasi</th>
                            <th>Tanggal Masuk</th>
                            <th>Tanggal Keluar</th>	
                            <th>Ruangan</th>							
                            <th>Dokter</th>
                            <th>Aksi</th>
                            <!-- <th>Tgl Lahir</th>
                            <th width="40px">Aksi</th> -->
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                          if ($data_pasien_iri != "") {
                            foreach($data_pasien_iri as $row){
                            ?>
                            <tr>
                              <td><?php echo $row->no_ipd;?></td>
                              <td><?php echo $row->noregasal;?></td>
                              <td><?php echo $row->tgl_masuk;?></td>	
                              <td><?php echo $row->tgl_keluar;?></td>								
                              <td><?php echo $row->nmruang;?></td>								
                              <td><?php echo $row->dokter;?></td>
                              <td>
                          <a data-toggle="modal" data-noregasal="<?= $row->noregasal ?>" data-userid="<?= $row->no_ipd; ?>"
                          href="#modal_rawat_inap" 
                          class="btn btn-primary">Detail</a>

                         
                            </tr>
                          <?php } 
                            }
                          ?>
                        </tbody>
                      </table>
                      </div>
            </div>
            <div class="tab-pane fade" id="rawat_darurat" role="tabpanel" aria-labelledby="rd-tab">
              <br>
                <div class="table-responsive m-t-0">
                    <table id="tbl-rawatDarurat" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                    <thead>
                        <tr>
                        <th>NO. REGISTRASI</th>
                        <th>TANGGAL</th>
                        <th>DOKTER</th>								
                        <th>POLIKLINIK</th>
                        <th>ASSESMENT MEDIK</th>
                        <th>ASSESMENT KEPERAWATAN</th>
                        <th>TRIASE</th>
                        <th>AKSI</th>
                        <!-- <th width="100px">Aksi</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ($data_pasien_ird != "") {
                        foreach($data_pasien_ird as $row){
                        ?>
                        <tr>
                            <td><?php echo $row->noregister;?></td>
                            <td><?php echo $row->tgl;?></td>
                            <td><?php echo $row->dokter;?></td>									
                            <td><?php echo $row->poli;?></td>
                            <td><?php 
                            
                            $a = $this->M_emedrec->get_data_assesment_medik_ird($row->noregister)->result();
                            if($a!= null){
                              echo '<div style="text-align: center;">
                              <span style="font-weight:bold;font-size:20pt;">
                              ✓
                              </span>
                            </div>';
                            }else{
                              echo '<div style="text-align: center;">
                                <span style="font-size:17pt;">
                                ✖
                                </span>
                              </div>';
                            }

                            ?></td>
                            
                            <td>
                            <?php  
                            
                            $b = $this->M_emedrec->get_data_asesmen_keperawatan_ird($row->noregister)->result();
                            if($b!= null ){
                              echo '<div style="text-align: center;">
                              <span style="font-weight:bold;font-size:20pt;">
                              ✓
                              </span>
                            </div>';
                            }else{
                              echo '<div style="text-align: center;">
                                <span style="font-size:17pt;">
                                ✖
                                </span>
                              </div>';
                            }

                            ?></td>
                             <td>
                            <?php  
                            
                            $b = $this->M_emedrec->get_data_triase_ird($row->noregister)->result();
                            if($b!= null ){
                              echo '<div style="text-align: center;">
                              <span style="font-weight:bold;font-size:20pt;">
                              ✓
                              </span>
                            </div>';
                            }else{
                              echo '<div style="text-align: center;">
                                <span style="font-size:17pt;">
                                ✖
                                </span>
                              </div>';
                            }

                            ?></td>
                            <td>
                            <a data-toggle="modal" data-poli="<?= $row->poli; ?>" data-userid="<?= $row->noregister; ?>"
                            href="#my_modal_ird" 
                            class="btn btn-primary">Detail</a>

                            </td>
                        </tr>
                        <?php } 
                        // }
                      }
                        ?>
                    </tbody>
                    </table>
                </div>
            </div>
          </div>
          <!-- END TABS CONTENT -->

                      
          </div>
          </div>
        </div>
      </div>
      </div>

      <!-- Modal Detail -->
      
      <!-- Modal Rawat Jalan -->
      <div class="modal fade" id="my_modal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Cetak Dokumen</h4>
                </div>
                <!-- Body -->
                <div class="modal-body">
                  <table class="table" border="1">
                    <thead>
                      <tr>
                        <th width="20%"><b>Kode</b></th>
                        <th><b>Nama Formulir</b></th>
                      </tr>
                    </thead>
                  <?php 
                  foreach($data_pasien as $row_data_pasien2){
                  ?>
                      <form action="<?= base_url('emedrec/C_emedrec/cetak_identitas'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.01</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Registrasi Pasien</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/ringkasan_keluar_rj'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.01-b1</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Ringkasan Keluar Pasien RJ</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/pengantar_surat_ranap'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.01.b</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Pengantar Rawat Inap</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/pengkajian_medis_rawat_jalan'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.02.a</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Pengkajian Medis Rawat Jalan</button>
                          </td>
                        </tr>
                      </form>
                    

                      <form action="<?= base_url('emedrec/C_emedrec/pengkajian_rawat_jalan'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.02.b</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Pengkajian Keperawatan Rawat Jalan</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/pengkajian_medis_anak'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.03.a1</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Pengkajian Medis Anak</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/pengkajian_tht'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.03.h</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Pengkajian Rawat jalan THTKL</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/pengkajian_gigi'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.03.h</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Pengkajian Rawat jalan Gigi</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/pengkajian_anak'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.03.a2</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Pengkajian Keperawatan Anak</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/pengkajian_medis_obgyn'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.03.d1</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Pengkajian Medis Obstetri dan Ginekologi</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/pengkajian_keperawatan_obgyn'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.03.d2</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Pengkajian Keperawatan Obstetri dan Ginekologi</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/cppt_rajal'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.04</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Catatan Perkembangan Pasien Terintegrasi Rawat Jalan</button>
                          </td>
                        </tr>
                      </form>

                     

                      <form action="<?= base_url('emedrec/C_emedrec/lembar_kontrol_pasien'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Lembar Kontrol Pasien</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/lap_echo'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Laporan Echocardiography</button>
                          </td>
                        </tr>
                      </form>
                      <form action="<?= base_url('emedrec/C_emedrec/formulir_registrasi_hiv'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Formulir Registrasi Layanan Konseling dan Tes HIV</button>
                          </td>
                        </tr>
                      </form>
                      <form action="<?= base_url('emedrec/C_emedrec/persetujuan_hiv'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Formulir Persetujuan Tes HIV</button>
                          </td>
                        </tr>
                      </form>
                      

                      <form action="<?= base_url('emedrec/C_emedrec/lembar_konsul_pasien'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Lembar Konsultasi</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/lembar_jawaban_konsul_pasien'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td >
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;" formtarget="_blank">Lembar Jawaban Konsultasi</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/resep_kacamata'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Resep Kacamata</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/lap_pemebedahan'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Laporan Pembedahan</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/rehabmedik_rj'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Layanan Kedokteran Fisik dan Rehabilitasi</button>
                          </td>
                        </tr>
                      </form>
                      
                      

                      <form action="<?= base_url('emedrec/C_emedrec/hasil_uji_fungsi'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Hasil Tindakan Uji Fungsi/Prosedur Layanan Kedokteran Fisik dan Rehabilitasi </button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/program_terapi'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Layanan Kedokteran Fisik dan Rehabilitasi (Program Terapi) </button>
                          </td>
                        </tr>
                      </form>
                      
                     

                      

                     

                      <form action="<?= base_url('emedrec/C_emedrec/permintaan_transfusi_darah'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Permintaan Transfusi Darah</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/persetujuan_tindakan_medik'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.17.a1</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Persetujuan Tindakan Medis</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/penolakan_tindakan_medik'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.17.a1</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Penolakan Tindakan Medis</button>
                          </td>
                        </tr>
                      </form>

                    

                      <form action="<?= base_url('emedrec/C_emedrec/surat_rujukan_pasien'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Surat Rujukan</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/cetak_surat_laboratorium'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Laboratorium</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/cetak_hasil_rad'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Radiologi</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/cetak_Eresep_telaah'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Resep</button>
                          </td>
                        </tr>
                      </form>

                     
                     
                  <?php } ?>
                  </table>
                </div>
                <!-- Body -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
      </div>
      <!-- End Modal Rawat Jalan -->




      <!-- Modal Rawat Inap -->
      <div class="modal fade" id="modal_rawat_inap" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Cetak Dokumen</h4>
                </div>
                <!-- Body -->
                <div class="modal-body">
                <!-- <div class="table-responsive m-t-0" > -->
                <input type="text" id="customSearch" placeholder="Cari Nama Formulir...">
                  <table id="tableranap" class="table" border="1">
                      <thead>
                        <tr>
                          <th width="80%"><b>Nama Formulir</b></th>
                          <th style="text-align:center"><b>View</b></th>
                          <th style="text-align:center">Paper</th>
                        </tr>
                      </thead>

                      <tbody>

                        
                          <tr>
                              <td>Pengkajian Keperawatan General</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengkajian_keperawatan_general'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengkajian_keperawatan_general'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Pengkajian Awal Rawat Inap</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengkajian_awal_ranap'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengkajian_awal_ranap'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Pengkajian Dekubitus</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengkajian_dekubitus_sjj'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengkajian_dekubitus_sjj'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Pengkajian awal medis Pasien Kecanduan</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengkajian_pasien_kecanduan'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengkajian_pasien_kecanduan'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Pengkajian Pra Anestesi dan Sedasi</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengkajian_anestesi_sedasi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengkajian_anestesi_sedasi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Pengkajian Resiko Infeksi</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengkajian_resiko_infeksi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengkajian_resiko_infeksi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Pengantar Rawat Inap</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengantar_rawat_inap'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengantar_rawat_inap'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Discharge planning Keperawatan</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/dicharge_planning_kep'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/dicharge_planning_kep'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>
                          <tr>
                            <td>Pemakaian Ventilator</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pemakaian_ventilator'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pemakaian_ventilator'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>
                          <tr>
                              <td>Ceklist Keselamatan Pasien di Luar OK</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/cek_keselamatan_ok'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/cek_keselamatan_ok'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Catatan Keperawatan Peri Operatif</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/catkep_peri_operatif'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/catkep_peri_operatif'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Catatan Pemindahan Pasien Dari Antar Ruangan</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/cat_pemindahan_ruangan'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/cat_pemindahan_ruangan'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Catatan Perawat</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/catatan_perawat'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/catatan_perawat'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Catatan Anestesi - Catatan Pemulihan</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/catatan_anestesi_pemulihan'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/catatan_anestesi_pemulihan'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Grafik Tanda Vital</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/grafik_tanda_vital'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/grafik_tanda_vital'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Lembar Observasi Harian</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/lembar_observasi_harian_new'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/lembar_observasi_harian_new'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Kontrol Intensive</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/kontrol_intensive'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/kontrol_intensive'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Rencana Penerapan Bundles Pencegahan Infeksi Rumah Sakit/HAIS</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/lembar_ppi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/lembar_ppi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Pemantauan Pemberian Cairan</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pemantauan_pemberian_cairan_new'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pemantauan_pemberian_cairan_new'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Rekonsiliasi Obat</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/rekonsiliasi_obat_new'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/rekonsiliasi_obat_new'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Rencana Tindakan Keperawatan</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/rencana_tindakan_keperawatan'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/rencana_tindakan_keperawatan'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Daftar Pemberian Terapi</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/daftar_pemberian_terapi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/daftar_pemberian_terapi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Laporan Pembedahan dengan Pendamping Anestesi Lokal</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/lap_pembedahan_anestesi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/lap_pembedahan_anestesi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Laporan Pembedahan dengan Pendamping Anestesi</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/lap_pendamping_anestesi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/lap_pendamping_anestesi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Laporan Pembedahan</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/laporan_pembedahan'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/laporan_pembedahan'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Lembaran Konsul</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/lembar_konsul'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/lembar_konsul'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Lembaran Intruksi</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/lembar_intruksi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/lembar_intruksi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Lembaran Harian HCU</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/intruksi_hcu'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/intruksi_hcu'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Patologi Anatomi</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/patologi_anatomi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/patologi_anatomi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Pengajuan Pembedahan</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengajuan_pembedahan'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengajuan_pembedahan'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Asuhan Keperawatan General</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/askep_general'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/askep_general'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Persiapan Perawatan Dirumah</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/persiapan_perawatan_dirumah'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/persiapan_perawatan_dirumah'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Catatan Khusus Paliatif</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/cat_khusus_paliatif'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/cat_khusus_paliatif'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Premedi Pasca Operasi</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pramedi_pasca_operasi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pramedi_pasca_operasi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Status Sedasi</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/status_sedasi_new'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/status_sedasi_new'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Penolakan Tindakan Medis</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/penolakan_tindakan_medis'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/penolakan_tindakan_medis'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Persetujuan Tindakan Medis</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/persetujuan_tindakan_medis'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/persetujuan_tindakan_medis'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Second Opinion</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/second_opinion'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/second_opinion'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Permintaan Privasi</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/permintaan_privasi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/permintaan_privasi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Pernyataan Rad Kontras</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pernyataan_rad_kontras'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pernyataan_rad_kontras'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Pernyataan Restrain mekanik</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pernyataan_restrain_mekanik'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pernyataan_restrain_mekanik'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Pernyataan tindakan Anestesi dan Sedasi</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pernyataan_anestesi_sedasi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pernyataan_anestesi_sedasi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Pernyataan tindakan Hemodialisis</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pernyataan_tindakan_hemodialisis'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pernyataan_tindakan_hemodialisis'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Pernyataan Tindakan Transfusi Darah</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pernyataan_transfusi_darah'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pernyataan_transfusi_darah'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Surat Izin Operasi</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/persetujuan_izin_operasi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/persetujuan_izin_operasi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Surat Keterangan Kelahiran</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/suket_kelahiran'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/suket_kelahiran'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Surat Penolakan Resusitasi</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/surat_penolakan_resusitasi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/surat_penolakan_resusitasi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Surat Pernyataan Persetujuan Pengobatan dengan Iodiumdoc</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengobatan_iodiumdoc'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengobatan_iodiumdoc'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Edukasi Pemberian Darah</td>
                              <td width="10%">
                                  <!-- <form action="<?= base_url('emedrec/C_emedrec_iri/edukasi_pemberian_darah'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form>  -->
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/edukasi_pemberian_darah'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Form Edukasi tindakan Anestesi dan Sedasi</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/edukasi_anestesi_sedasi_new'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/edukasi_anestesi_sedasi_new'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Tanda Terima Leaflet Hak & Kewajiban Pasien</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/leaflet_pasien'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/leaflet_pasien'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Surat Pertanyaan Pulang APS</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/surat_pernyataan_pulang'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/surat_pernyataan_pulang'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Registasi Awal</td>
                              <td width="10%">
                                  <!-- <form action="<?= base_url('emedrec/C_emedrec_iri/registrasi_awal'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form>  -->
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/registrasi_awal'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Ringkasan Masuk dan Keluar Pasien Rawat Inap</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/ringkasan_masuk_keluar_pasien'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/ringkasan_masuk_keluar_pasien'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Resume Pasien Pulang Keperawatan</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/resume_pasien_pulang_keperawatan'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/resume_pasien_pulang_keperawatan'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Resume Pasien Pulang Rawat Inap</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/resume_pasien_pulang'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/resume_pasien_pulang'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Pengkajian Risiko Jatuh Pasien Dewasa</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/risiko_jatuh_dewasa'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/risiko_jatuh_dewasa'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Pengkajian Risiko Jatuh Pasien Geriatri</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/risiko_jatuh_geriatri'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/risiko_jatuh_geriatri'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Data Bayi Baru Lahir</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/data_bayi_lahir'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/data_bayi_lahir'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Identifikasi Bayi</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/identifikasi_bayi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/identifikasi_bayi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Pengkajian Jatuh Neonatus</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengkajian_jatuh_neonatus'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengkajian_jatuh_neonatus'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Pengkajian Keperawatan Perinatologi</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengkajian_kep_perinatologi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengkajian_kep_perinatologi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>

                          <tr>
                              <td>Pengkajian Keperawatan Anak</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengkajian_kep_anak'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengkajian_kep_anak'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>
                          <tr>
                              <td>Pengkajian Resiko Jatuh Anak (Humpty Dumpty)</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/resiko_jatuh_anak'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/resiko_jatuh_anak'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>
                          <tr>
                              <td>Penilaian Pengkajian Pasien Resiko Jatuh </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/resiko_jatuh_new'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/resiko_jatuh_new'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>
                          <tr>
                              <td>Pengkajian Medis Rawat Inap Anak</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/medis_ranap_anak'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/medis_ranap_anak'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>
                          <tr>
                              <td>Pengkajian Medis Neonatus</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/medis_ranap_neonatus'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/medis_ranap_neonatus'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                            
                          </tr>
                          <tr>
                              <td>Persetujuan Bayi Tabung</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/persetujuan_bayi_tabung'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/persetujuan_bayi_tabung'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>
                          <tr>
                              <td>Serah Terima Bayi</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/serah_terima_bayi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/serah_terima_bayi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>
                          <tr>
                              <td>Asuhan Keperawatan Obgyn</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/askep_obgyn'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/askep_obgyn'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>
                          <tr>
                              <td>Pengkajian Keperawatan Obgyn</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengkajian_keperawatan_obgyn'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengkajian_keperawatan_obgyn'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>
                          <tr>
                              <td>Pengkajian Medis KB</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengkajian_medis_kb'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengkajian_medis_kb'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>
                          <tr>
                              <td>Asuhan Keperawatan HCU</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/asuhan_keperawatan_hcu'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/asuhan_keperawatan_hcu'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>
                          
                          <tr>
                              <td>Pengkajian Keperawatan HCU</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengkajian_kep_hcu'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pengkajian_kep_hcu'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>
                          <tr>
                              <td>Catatan Serah Terima / Hand Over</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/hand_over'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/hand_over'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>

                          <tr>
                              <td>CPPT</td>
                              <td></td>
                              <td width="10%">
                                      <form action="<?= base_url('emedrec/C_emedrec_iri/get_cppt_iri'); ?>" method="post" target="_blank">
                                      <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                          </tr>


                          <tr>
                              <td>Assesment Ulang Nyeri</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/assesment_ulang_nyeri'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/assesment_ulang_nyeri'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>


                          <tr>
                              <td>PEWS</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pews'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/pews'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>
                          <tr>
                              <td>Surat Rujukan</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/surat_rujukan_new'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/surat_rujukan_new'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>
                          <tr>
                              <td>Surat Keterangan Kematian</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/suket_kematian'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/suket_kematian'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>
                          <tr>
                              <td>Persetujuan/Penolakan Rujukan</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/persetujuan_penolakan_rujukan'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/persetujuan_penolakan_rujukan'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>
                          <tr>
                              <td>Catatan edukasi terintegrasi</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/catatan_edukasi_terintegrasi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/catatan_edukasi_terintegrasi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>
                          <tr>
                              <td>Penandaan Lokasi operasi</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/penandaan_lokasi_op'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/penandaan_lokasi_op'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>
                          <tr>
                              <td>Monitoring Tranfusi darah</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/monitoring_transfusi_darah'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/monitoring_transfusi_darah'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>
                          <tr>
                              <td>Monitoring Intra sedasi/anastesi</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/insert_monitoring_anatesi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/insert_monitoring_anatesi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>
                          <tr>
                              <td>Formulir Transfer Pasien</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/formulir_transfer_pasien'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/formulir_transfer_pasien'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>
                          <tr>
                              <td>Asuhan Gizi</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/insert_asuhan_gizi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/insert_asuhan_gizi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>
                          <tr>
                              <td>Lembar Observasi Earlywarning Score (EWS)</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/ews_dewasa'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/ews_dewasa'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>
                          <tr>
                              <td>Surat Perintah Tugas</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/surat_tugas'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/surat_tugas'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>
                          <tr>
                              <td>Formulir pemberi makan</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/gizi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/gizi'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>
                          <tr>
                              <td>Asuhan Keperawatan Anak</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/askep_anak'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/askep_anak'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>
                          <tr>
                              <td>Permintaan Transfusi Darah</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/permintaan_darah'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/permintaan_darah'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>
                          <tr>
                              <td>Lembar Observasi Modified Early Obstertic Warning System (Meows)</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/meows'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/meows'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>
                          <tr>
                              <td>Surat Pernyatan Naik Kelas</td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/naik_kelas'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" class="btn btn-primary btn-sm">View</button>
                                  </form> 
                              </td>
                              <td width="10%">
                                  <form action="<?= base_url('emedrec/C_emedrec_iri/naik_kelas'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_id" value="<?= $data_pasien_iri[0]->no_ipd; ?>"> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">Paper</button>
                                  </form>
                              </td>
                          </tr>
                      
                          






                            <!-- edukasi_pemberian_darah -->
                            

                            <!-- persetujuan_izin_operasi -->
                            <!-- <form action="<?= base_url('emedrec/C_emedrec_iri/persetujuan_izin_operasi'); ?>" method="post" target="_blank">
                              <tr onclick="this.children[0].click()">
                              <td>
                              <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                              </td>
                              <td>
                                  <input type="hidden" name="user_id" value=""> 
                                  <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                  <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                  <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Persetujuan Izin Operasi</button>
                                </td>
                              </tr>
                            </form> -->


                            <!-- data_bayi_lahir -->
                            <!-- <form action="<?= base_url('emedrec/C_emedrec_iri/data_bayi_lahir'); ?>" method="post" target="_blank">
                              <tr onclick="this.children[0].click()">
                              <td>
                              <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                              </td>
                              <td>
                                  <input type="hidden" name="user_id" value=""> 
                                  <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                  <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                  <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Data Bayi Baru Lahir</button>
                                </td>
                              </tr>
                            </form> -->




                          <!-- pengantar_iri -->
                            <!-- <form action="<?= base_url('emedrec/C_emedrec_iri/cetak_pengantar_iri'); ?>" method="post" target="_blank">
                              <tr onclick="this.children[0].click()">
                              <td>
                              <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                              </td>
                              <td>
                                  <input type="hidden" name="user_id" value=""> 
                                  <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                  <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                  <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Surat Pengantar Rawat Inap</button>
                                </td>
                              </tr>
                            </form> -->

                            <!-- cetak_general_consent -->  
                            <!-- <form action="<?= base_url('emedrec/C_emedrec_iri/cetak_general_consent'); ?>" method="post" target="_blank">
                              <tr onclick="this.children[0].click()">
                              <td>
                              <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                              </td>
                              <td>
                                  <input type="hidden" name="user_id" value=""> 
                                  <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                  <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                  <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Persetujuan umum / general consent</button>
                                </td>
                              </tr>
                            </form> -->

                            <!-- Assesment awal keperawatan umum -->  
                            <!-- <form action="<?= base_url('emedrec/C_emedrec_iri/assesment_awal_keperawatan'); ?>" method="post" target="_blank">
                              <tr onclick="this.children[0].click()">
                              <td>
                              <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                              </td>
                              <td>
                                  <input type="hidden" name="user_id" value=""> 
                                  <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                  <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                  <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Asesmen Awal Keperawatan Rawat Inap</button>
                                </td>
                              </tr>
                            </form> -->

                            <!-- Asesmen Awal Keperawatan Anak Rawat Inap -->  
                            <!-- <form action="<?= base_url('emedrec/C_emedrec_iri/assesment_awal_keperawatan_anak'); ?>" method="post" target="_blank">
                              <tr onclick="this.children[0].click()">
                              <td>
                              <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                              </td>
                              <td>
                                  <input type="hidden" name="user_id" value=""> 
                                  <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                  <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                  <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Asesmen Awal Keperawatan Anak Rawat Inap</button>
                                </td>
                              </tr>
                            </form> -->

                            <!-- Asemen Awal Keperawatan Rawat Inap Kebidanan -->  
                            <!-- <form action="<?= base_url('emedrec/C_emedrec_iri/assesment_awal_kebidanan'); ?>" method="post" target="_blank">
                              <tr onclick="this.children[0].click()">
                              <td>
                              <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                              </td>
                              <td>
                                  <input type="hidden" name="user_id" value=""> 
                                  <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                  <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                  <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Asemen Awal Keperawatan Rawat Inap Kebidanan</button>
                                </td>
                              </tr>
                            </form> -->

                            <!-- Asemen Awal Keperawatan Rawat Inap Neonatus -->  
                            <!-- <form action="<?= base_url('emedrec/C_emedrec_iri/assesment_awal_bayi'); ?>" method="post" target="_blank">
                              <tr onclick="this.children[0].click()">
                              <td>
                              <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                              </td>
                              <td>
                                  <input type="hidden" name="user_id" value=""> 
                                  <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                  <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                  <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Asemen Awal Keperawatan Rawat Inap Neonatus</button>
                                </td>
                              </tr>
                            </form> -->

                              <!-- catatan_medis_awal_rawat_inap -->
                              <!-- <form action="<?= base_url('emedrec/C_emedrec_iri/catatan_medis_awal_rawat_inap'); ?>" method="post" target="_blank">
                                <tr onclick="this.children[0].click()">
                                <td>
                                <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                                </td>
                                <td>
                                    <input type="hidden" name="user_id" value=""> 
                                    <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                    <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                    <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Catatan Medis Awal Rawat Inap</button>
                                  </td>
                                </tr>
                            </form> -->

                              <!-- Catatan medis awal rawat inap anak -->  
                            <!-- <form action="<?= base_url('emedrec/C_emedrec_iri/catatan_medis_awal_rawat_inap_anak'); ?>" method="post" target="_blank">
                              <tr onclick="this.children[0].click()">
                              <td>
                              <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                              </td>
                              <td>
                                  <input type="hidden" name="user_id" value=""> 
                                  <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                  <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                  <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Catatan Medis Awal Rawat Inap Anak</button>
                                </td>
                              </tr>
                            </form> -->

                            <!-- Catatan Medis Awal Rawat Inap Kebidanan -->
                            <!-- <form action="<?= base_url('emedrec/C_emedrec_iri/catatan_medis_awal_bidan'); ?>" method="post" target="_blank">
                              <tr onclick="this.children[0].click()">
                              <td>
                              <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                              </td>
                              <td>
                                  <input type="hidden" name="user_id" value=""> 
                                  <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                  <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                  <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Catatan Medis Awal Rawat Inap Kebidanan</button>
                                </td>
                              </tr>
                            </form> -->

                            <!-- medis neonatus -->
                            <!-- <form action="<?= base_url('emedrec/C_emedrec_iri/catatan_medis_awal_neonatus'); ?>" method="post" target="_blank">
                              <tr onclick="this.children[0].click()">
                              <td>
                              <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                              </td>
                              <td>
                                  <input type="hidden" name="user_id" value=""> 
                                  <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                  <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                  <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Catatan Medis Awal Rawat Inap Neonatus</button>
                                </td>
                              </tr>
                            </form> -->

                            <!-- Lembar Observasi EWS				 -->  
                            <!-- <form action="<?= base_url('emedrec/C_emedrec_iri/ews_iri'); ?>" method="post" target="_blank">
                              <tr onclick="this.children[0].click()">
                              <td>
                              <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                              </td>
                              <td>
                                  <input type="hidden" name="user_id" value=""> 
                                  <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                  <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                  <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Lembar observasi Early warning score (EWS)</button>
                                </td>
                              </tr>
                            </form> -->

                            <!-- Asesmen Ulang Resiko Jatuh Pada Pasien Dewasa   -->  
                            <!-- <form action="<?= base_url('emedrec/C_emedrec_iri/asesmen_ulang_jatuh_dewasa'); ?>" method="post" target="_blank">
                              <tr onclick="this.children[0].click()">
                              <td>
                              <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                              </td>
                              <td>
                                  <input type="hidden" name="user_id" value=""> 
                                  <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                  <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                  <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Pengkajian risiko jatuh pada pasien dewasa</button>
                                </td>
                              </tr>
                            </form> -->

                            <!-- Catatan Edukasi Terintegrasi Pasien/Keluarga -->  
                            <!-- <form action="<?= base_url('emedrec/C_emedrec_iri/catatan_edukasi_iri'); ?>" method="post" target="_blank">
                              <tr onclick="this.children[0].click()">
                              <td>
                              <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                              </td>
                              <td>
                                  <input type="hidden" name="user_id" value=""> 
                                  <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                  <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                  <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Catatan pemberian informasi dan edukasi pasein dan keluarga terintegrasi</button>
                                </td>
                              </tr>
                            </form> -->

                            <!-- Tindakan Keperawatan -->  
                            <!-- <form action="<?= base_url('emedrec/C_emedrec_iri/tindakan_keperawatan'); ?>" method="post" target="_blank">
                              <tr onclick="this.children[0].click()">
                              <td>
                              <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                              </td>
                              <td>
                                  <input type="hidden" name="user_id" value=""> 
                                  <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                  <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                  <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Catatan perawat</button>
                                </td>
                              </tr>
                            </form> -->

                            <!-- Pemantauan Pemberian Cairan -->  
                            <!-- <form action="<?= base_url('emedrec/C_emedrec_iri/pemantauan_pemberian_cairan'); ?>" method="post" target="_blank">
                              <tr onclick="this.children[0].click()">
                              <td>
                              <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                              </td>
                              <td>
                                  <input type="hidden" name="user_id" value=""> 
                                  <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                  <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                  <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Pemantauan Pemberian Cairan</button>
                                </td>
                              </tr>
                            </form> -->

                            <!-- Rencana Pemulangan Pasien (Discharge Planning) -->  
                            <!-- <form action="<?= base_url('emedrec/C_emedrec_iri/rencana_pemulangan_pasien'); ?>" method="post" target="_blank">
                              <tr onclick="this.children[0].click()">
                              <td>
                              <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                              </td>
                              <td>
                                  <input type="hidden" name="user_id" value=""> 
                                  <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                  <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                  <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Rencana Pemulangan Pasien (Discharge Planning)</button>
                                </td>
                              </tr>
                            </form> -->

                            <!-- Kartu Intruksi Obat -->  
                            <!-- <form action="<?= base_url('emedrec/C_emedrec_iri/kio_resep'); ?>" method="post" target="_blank">
                              <tr onclick="this.children[0].click()">
                              <td>
                              <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                              </td>
                              <td>
                                  <input type="hidden" name="user_id" value=""> 
                                  <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                  <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                  <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Kartu Intruksi Obat</button>
                                </td>
                              </tr>
                            </form> -->

                              <!-- Asesmen Ulang Nyeri Pada Pasien Dewasa    -->  
                              <!-- <form action="<?= base_url('emedrec/C_emedrec_iri/monitoring_asesmen_nyeri_dewasa'); ?>" method="post" target="_blank">
                                  <tr onclick="this.children[0].click()">
                                  <td>
                                  <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                                  </td>
                                  <td>
                                      <input type="hidden" name="user_id" value=""> 
                                      <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                      <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                      <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Asesmen Ulang Nyeri Pasien Dewasa </button>
                                    </td>
                                  </tr>
                            </form> -->

                            <!-- Catatan Serah Terima (Hand Over) Asuhan Pasien -->  
                            <!-- <form action="<?= base_url('emedrec/C_emedrec_iri/cetak_serah_terima_asuhan_pasien_iri'); ?>" method="post" target="_blank">
                              <tr onclick="this.children[0].click()">
                              <td>
                              <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                              </td>
                              <td>
                                  <input type="hidden" name="user_id" value=""> 
                                  <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                  <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                  <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Catatan Serah Terima (Hand Over) Asuhan Pasien</button>
                                </td>
                              </tr>
                            </form> -->

                            <!-- Daftar Pemberian Obat -->  
                            <!-- <form action="<?= base_url('emedrec/C_emedrec_iri/daftar_pemberian_obat'); ?>" method="post" target="_blank">
                              <tr onclick="this.children[0].click()">
                              <td>
                              <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                              </td>
                              <td>
                                  <input type="hidden" name="user_id" value=""> 
                                  <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                                  <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                                  <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Daftar Pemberian Terapi</button>
                                </td>
                              </tr>
                            </form> -->

                      </tbody>

                  </table>
                  </div>
                <!-- </div> -->

                <!-- Body -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
      </div>
      <!-- End Modal Rawat Inap -->



      <!-- Modal Rawat Darurat -->
        <div class="modal fade" id="my_modal_ird" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Cetak Dokumen</h4>
                </div>
                <!-- Body -->
                <div class="modal-body">
                <table class="table" border="1">
                    <thead>
                      <tr>
                        <th ><b>Kode</b></th>
                        <th><b>Nama Formulir</b></th>
                      </tr>
                    </thead>
                      <?php 
                      foreach($data_pasien as $row_data_pasien2){
                      ?>
                      <!-- <form action="<?= base_url('emedrec/C_emedrec/cetak_identitas'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td >
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.RJ.01</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;" formtarget="_blank">Formulir Pendaftaran Pasien Baru Rawat Jalan/Gawat Darurat</button>
                          </td>
                        </tr>
                      </form> -->
                        
                      <!-- added putri 04-06-2024 -->
                      <form action="<?= base_url('emedrec/C_emedrec/cetak_identitas'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.01</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Registrasi Pasien</button>
                          </td>
                        </tr>
                      </form>
                       <form action="<?= base_url('emedrec/C_emedrec/surat_keterangan_masuk_igd'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td >
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;" formtarget="_blank">Surat keterangan masuk IGD</button>
                          </td>
                        </tr>
                      </form>


                      <form action="<?= base_url('emedrec/C_emedrec/pengantar_surat_ranap'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td >
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.01.b</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;" formtarget="_blank">Pengantar Rawat Inap</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/suket_kematian'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td >
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;" formtarget="_blank">Surat Keterangan Kematian</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/surat_rujukan_pasien'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td >
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;" formtarget="_blank">Surat Rujukan</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/lembar_konsul_new'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td >
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;" formtarget="_blank">Lembar Konsultasi</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/lembar_jawaban_konsul_pasien'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td >
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;" formtarget="_blank">Lembar Jawaban Konsultasi</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/ringkasan_pulang_igd'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td >
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.01.a2</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;" formtarget="_blank">Ringkasan pulang pasien IGD</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/persetujuan_tindakan_medik'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td >
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;" formtarget="_blank">Persetujuan Tindakan Medis</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/penolakan_tindakan_medik'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td >
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.17.A1</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;" formtarget="_blank">Penolakan Tindakan Medis</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/cuti_perawatan'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td >
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;" formtarget="_blank">Permohonan Cuti Perawatan</button>
                          </td>
                        </tr>
                      </form>
                      <form action="<?= base_url('emedrec/C_emedrec/keperawatan_ponek'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td >
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;" formtarget="_blank">Catatan Keperawatan Ponek</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/penundaan_pelayanan'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td >
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;" formtarget="_blank">Penundaan Pelayanan</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/skrining'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td >
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;" formtarget="_blank">Formulir Skrining</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/observasi'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td >
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;" formtarget="_blank">Form Observasi</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/edukasi_pasien'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td >
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;" formtarget="_blank">Formulir Edukasi Pasien Terintegrasi</button>
                          </td>
                        </tr>
                      </form>


                      <form action="<?= base_url('emedrec/C_emedrec/pengkajian_medis_igd'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td >
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.03.b1</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;" formtarget="_blank">Pengkajian Medis IGD</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/pengkajian_gigi'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.03.h</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Pengkajian Rawat jalan Gigi</button>
                          </td>
                        </tr>
                      </form>

                      <form action="<?= base_url('emedrec/C_emedrec/triase'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td >
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;" formtarget="_blank">Formulir Triase</button>
                          </td>
                        </tr>
                      </form>
                      
                     
                      <form action="<?= base_url('emedrec/C_emedrec/kesediaan'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td >
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;" formtarget="_blank">Form Kesediaan dirawat</button>
                          </td>
                        </tr>
                      </form>

                     

                      
                      <!-- <form action="<?= base_url('emedrec/C_emedrec/cetak_triase_ird'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td width="150px">
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.RJ.03 A</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;" formtarget="_blank">Triase Gawat Darurat</button>
                          </td>
                        </tr>
                      </form> -->
                      <!-- <form action="<?= base_url('emedrec/C_emedrec/assesment_medik_ird'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td width="150px">
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.RJ.03 B</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;" formtarget="_blank">Asesmen Medis Igd</button>
                          </td>
                        </tr>
                      </form> -->
                      <!-- <form action="<?= base_url('emedrec/C_emedrec/cetak_asesmen_awal_keperawatan_ird'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td width="150px">
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.RJ.04</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;" formtarget="_blank">Asesmen Awal Keperawatan Igd</button>
                          </td>
                        </tr>
                      </form> -->
                      <!-- <form action="<?= base_url('emedrec/C_emedrec/skrining_triase_covid'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td width="150px">
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.RJ.07C</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;" formtarget="_blank">Skrining Triase/Poliklinik Pasien COVID-19</button>
                          </td>
                        </tr>
                      </form> -->
                      <!-- <form action="<?= base_url('emedrec/C_emedrec/cetak_resume_by_noreg'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.RJ.09</button>
                        </td>
                        <td>
                        <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Profil Ringkas Medis Rawat Jalan (PRMRJ)</button>
                          </td>
                        </tr>
                      </form> -->
                      <!-- <form action="<?= base_url('emedrec/C_emedrec/rasal'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.RJ.10</button>
                        </td>
                        <td>
                        <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Raspro Alur Antibiotik Awal (RASAL)</button>
                          </td>
                        </tr>
                      </form> -->

                      <!-- <form action="<?= base_url('emedrec/C_emedrec/raslan'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.RJ.11</button>
                        </td>
                        <td>
                        <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Raspro Alur Antibiotik Lanjutan (RASLAN)</button>
                          </td>
                        </tr>
                      </form> -->

                      <!-- <form action="<?= base_url('emedrec/C_emedrec/gyssens'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.RJ.12</button>
                        </td>
                        <td>
                        <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Evaluasi Pemakaian Antibiotik (GYSSENS)</button>
                          </td>
                        </tr>
                      </form> -->

                      <!-- <form action="<?= base_url('emedrec/C_emedrec/raspatur'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.RJ.13</button>
                        </td>
                        <td>
                        <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Antibiotik Sesuai Kultur (RASPATUR)</button>
                          </td>
                        </tr>
                      </form> -->

                      <!-- <form action="<?= base_url('emedrec/C_emedrec/edukasi_penolakan_rencana_asuhan'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM.RJ.15</button>
                        </td>
                        <td>
                        <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Edukasi Persetujuan/Penolakan Rencana Asuhan</button>
                          </td>
                        </tr>
                      </form> -->

                      <!-- <form action="<?= base_url('emedrec/C_emedrec/nihss'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM-032/RI</button>
                        </td>
                        <td>
                        <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">National Institute of Health Stroke Scale (NIHSS)</button>
                          </td>
                        </tr>
                      </form> -->

                      <!-- <form action="<?= base_url('emedrec/C_emedrec/ews_dewasa'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM-028/RI</button>
                        </td>
                        <td>
                        <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Lembar Observasi EWS</button>
                          </td>
                        </tr>
                      </form> -->

                      <!-- <form action="<?= base_url('emedrec/C_emedrec/disfagia'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM-033/RI</button>
                        </td>
                        <td>
                        <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Prosedur Skrining Disfagia</button>
                          </td>
                        </tr>
                      </form> -->

                      <!-- <form action="<?= base_url('emedrec/C_emedrec_iri/cetak_formulir_transfer_antar_ruangan?noreg_old=123&akses_luar=true'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM-020a/RI</button>
                        </td>
                        <td>
                        <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"> Transfer Antar Ruangan</button>
                          </td>
                        </tr>
                      </form> -->

                      <!-- <form action="<?= base_url('emedrec/C_emedrec/cetak_serah_terima_asuhan_pasien'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM-026/RI</button>
                        </td>
                        <td>
                        <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Catatan Serah Terima (Hand Over) Asuhan Pasien</button>
                          </td>
                        </tr>
                      </form> -->

                      <!-- <form action="<?= base_url('emedrec/C_emedrec/penilaian_fungsional'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM-006h/RI</button>
                        </td>
                        <td>
                        <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Penilaian Fungsional</button>
                          </td>
                        </tr>
                      </form> -->

                      <!-- <form action="<?= base_url('emedrec/C_emedrec/konsul_dokter_iGD'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">RM-011/RI</button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Lembar Konsultasi Antar Bagian</button>
                          </td>
                        </tr>
                      </form> -->

                      <!-- <form action="<?= base_url('emedrec/C_emedrec/cetak_diagnosa_noreg'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Surat Bukti Pelayanan Kesehatan</button>
                          </td>
                        </tr>
                      </form> -->

                      <!-- <form action="<?= base_url('emedrec/C_emedrec/suket_sakit'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                        <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Surat Keterangan Sakit Setelah Perawatan</button>
                          </td>
                        </tr>
                      </form> -->

                      <!-- <form action="<?= base_url('emedrec/C_emedrec/cetak_surat_kontrol'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                        <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Surat Kontrol</button>
                          </td>
                        </tr>
                      </form> -->

                     

                      <!-- <form action="<?= base_url('emedrec/C_emedrec/cetak_Eresep'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                        <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="poli" value="">
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">E-Resep</button>
                          </td>
                        </tr>
                      </form> -->

                      <!-- <form action="<?= base_url('emedrec/C_emedrec/cetak_surat_laboratorium'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Laboratorium</button>
                          </td>
                        </tr>
                      </form> -->

                      <!-- <form action="<?= base_url('emedrec/C_emedrec/cetak_hasil_rad'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                        <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Radiologi</button>
                          </td>
                        </tr>
                      </form> -->

                      <!-- <form action="<?= base_url('emedrec/C_emedrec/cetak_surat_elektromedik'); ?>" method="post" target="_blank">
                        <tr onclick="this.children[0].click()">
                        <td>
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;"></button>
                        </td>
                        <td>
                        <input type="hidden" name="user_id" value=""> 
                            <input type="hidden" name="no_cm" value="<?= $row_data_pasien2->no_cm; ?>">
                            <input type="hidden" name="no_medrec" value="<?= $row_data_pasien2->no_medrec; ?>">
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; font-size: 100%;">Elektromedik</button>
                          </td>
                        </tr>
                      </form> -->
                  <?php } ?>
                  </table>
                </div>
                <!-- Body -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
      </div>
      <!-- End Modal Rawat Darurat -->


    <!-- MDB -->
    <script type="text/javascript" src="<?php echo site_url('/assets/mdb2/js/mdb.min.js'); ?>"></script>
    <!-- Custom scripts -->
    <script type="text/javascript">
      var a = document.getElementById('disc-50');
      $('#my_modal').on('show.bs.modal', function(e) {
        var userid = $(e.relatedTarget).data('userid');
        var id_poli = $(e.relatedTarget).data('id_poli');
        var poli = $(e.relatedTarget).data('poli');
        // console.log(poli);
        $(e.currentTarget).find('input[name="user_id"]').val(userid);
        $(e.currentTarget).find('input[name="id_poli"]').val(id_poli);
        $(e.currentTarget).find('input[name="poli"]').val(poli);
      
    });

    $('#modal_rawat_inap').on('show.bs.modal', function(e) {
        var userid = register!=""?register:$(e.relatedTarget).data('userid');
        var userid_old = register_old!=""?register_old:$(e.relatedTarget).data('noregasal')
        $(e.currentTarget).find('input[name="user_id"]').val(userid);
        $(e.currentTarget).find('input[name="user_id_old"]').val(userid_old);
        // console.log()
    

    });

    $('#modal_rawat_inap2').on('show.bs.modal', function(e) {
        var userid = register!=""?register:$(e.relatedTarget).data('userid');
        var userid_old = register_old!=""?register_old:$(e.relatedTarget).data('noregasal')
        $(e.currentTarget).find('input[name="user_id"]').val(userid);
        $(e.currentTarget).find('input[name="user_id_old"]').val(userid_old);
        // console.log()
    

    });

    $('#my_modal_ird').on('show.bs.modal', function(e) {
        var userid = $(e.relatedTarget).data('userid');
        $(e.currentTarget).find('input[name="user_id"]').val(userid);
        

    });

      function Clipboard_CopyTo(value) {
        var tempInput = document.createElement("input");
        tempInput.value = value;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
      }

    </script>



    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>
<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?>

<script type='text/javascript'>
$(function() {
    $('#tbl-rawatjalan').DataTable({
          "language": {
          "emptyTable": "Data tidak tersedia."
          }
      });
});
</script>
    
<?php echo $this->session->flashdata('success_msg'); ?>
    
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
                <?php
                if ($data_pasien!="") {
                  foreach($data_pasien as $row){
                  ?>

                  <div class="row">
                    <div class="col-md-7">
                      <div class="form-outline" style="margin-bottom: calc(var(--bs-gutter-x)/2)">
                        <input type="text" id="nama" name="" class="form-control" value="<?php echo strtoupper($row->nama);?>" readonly/>
                        <label class="form-label" for="nama">Nama</label>
                      </div>
                    </div>

                    <div class="col-md-5">
                      <?php
                        if($row->sex == "L"){
                      ?>
                        <div class="form-outline" style="margin-bottom: calc(var(--bs-gutter-x)/2)">
                          <input type="text" id="gender" name="gender" class="form-control" value="LAKI-LAKI" readonly/>
                          <label class="form-label" for="gender">Jenis Kelamin</label>
                        </div>
                      
                      <?php
                        }
                        else{
                      ?>
                      <div class="form-outline" style="margin-bottom: calc(var(--bs-gutter-x)/2)">
                          <input type="text" id="gender" name="gender" class="form-control" value="PEREMPUAN" readonly/>
                          <label class="form-label" for="gender">Jenis Kelamin</label>
                        </div>
                      <?php
                        }
                      ?>
                      
                    </div>
                  </div>
                  
                                   
                  <div class="form-outline" style="margin-bottom: calc(var(--bs-gutter-x)/2)">
                    <input type="text" id="no_cm" name="no_cm" class="form-control" value="<?php echo strtoupper($row->no_cm);?>" readonly/>
                    <label class="form-label" for="no_cm">No. RM</label>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-7">
                      <div class="form-outline" style="margin-bottom: calc(var(--bs-gutter-x)/2)">
                        <input type="text" id="tmpt_lahir" name="tmpt_lahir" class="form-control" value="<?php echo strtoupper($row->tmpt_lahir);?>" readonly/>
                        <label class="form-label" for="tmpt_lahir">Tempat Lahir</label>
                      </div>
                    </div>
                    
                    <div class="col-md-5">
                      <div class="form-outline" style="margin-bottom: calc(var(--bs-gutter-x)/2)">
                        <input type="text" id="tgl_lahir" name="tgl_lahir" class="form-control" value="<?php echo substr($row->tgl_lahir,0,10);?>" readonly/>
                        <label class="form-label" for="tgl_lahir">Tanggal Lahir</label>
                      </div>
                    </div>
                  </div>
                  

                  <div class="form-outline" style="margin-bottom: calc(var(--bs-gutter-x)/2)">
                    <textarea type="text" id="alamat" name="alamat" rows="4" class="form-control" readonly><?php echo strtoupper($row->alamat);?></textarea>
                    <label class="form-label" for="no_cm">Alamat</label>
                  </div>
                  
              
            </div>
            <div class="row">
            <div class="col-md-4">
              <a href="<?php echo site_url('emedrec/C_emedrec/cetak_resume/'.$row->no_cm); ?>" type="button" class="btn waves-effect waves-light btn-floating btn-info"  target="_blank">
                <i class="fas fa-print"></i>
              </a>
            </div>
          </div>
            <?php
              
              }}
              ?>
            
            <div class="table-responsive m-t-0">
                <table id="tbl-rawatjalan" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                <thead>
                    <tr>
                    <th>NO. REGISTRASI</th>
                    <th>TANGGAL masuk</th>
                    <th>DOKTER</th>								
                    <!-- <th>POLIKLINIK</th> -->
                    <th>DIAGNOSA</th>
                    <th>AKSI</th>
                    <!-- <th width="100px">Aksi</th> -->
                    </tr>
                </thead>
                <tbody>
                <?php
                    if ($data_pasien_iri != "") {
                    foreach($data_pasien_iri as $row){
                    ?>
                    <tr>
                        <td><?php echo $row->no_ipd;?></td>
                        <td><?php echo $row->tgl_masuk;?></td>
                        <td><?php echo $row->dokter;?></td>									
                        <!-- <td><?php echo $row->poli;?></td> -->
                        <td><?php echo $row->nm_diagnosa;?></td>
                        <td><button class="btn btn-success btn-rounded" style='margin-bottom: 3px;' data-toggle="modal" data-target="#myModal"><i class="fa fa-search" style="margin-right: 3px"></i>Detail</button></td>
                        <!-- <td><a href="" class="btn btn-danger btn-xs" style='width:90px;margin-bottom: 3px;'>HTML</a></td> -->
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

      <!-- Modal Detail -->
      <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Cetak Dokumen</h4>
                </div>
                <!-- Body -->
                <div class="modal-body">
                <?php
                    if ($data_pasien_iri != "") {
                    foreach($data_pasien_iri as $row){
                    ?>
                <div class="list-group">
                    <button type="button" class="list-group-item list-group-item-action">ASESMEN AWAL</button>
                    <button type="button" class="list-group-item list-group-item-action">ASESMEN MEDIS POLI</button>
                    <button type="button" class="list-group-item list-group-item-action">CPPT</button>
                    <button type="button" class="list-group-item list-group-item-action">DIAGNOSA</button>
                    <button type="button" class="list-group-item list-group-item-action">E-RESEP</button>
                    <button type="button" class="list-group-item list-group-item-action">KONTROL</button>
                    <button type="button" class="list-group-item list-group-item-action">LABOR</button>
                    <button type="button" class="list-group-item list-group-item-action">RADIOLOGI</button>
                    <button type="button" class="list-group-item list-group-item-action">ELEKTROMEDIK</button>
                    <button type="button" class="list-group-item list-group-item-action">KONSUL DOKTER</button>
                    <a type="button" class="list-group-item list-group-item-action" target="_blank" href="<?php echo base_url()?>emedrec/C_emedrec_iri/cetak_resume_medis_iri/<?php echo  $row->no_ipd;?>">RESUME MEDIS</a>
                </div>
                <?php } 
                    }
                    ?>
                </div>
                <!-- Body -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>


    <!-- MDB -->
    <script type="text/javascript" src="<?php echo site_url('/assets/mdb2/js/mdb.min.js'); ?>"></script>
    <!-- Custom scripts -->
    <script type="text/javascript">
      var a = document.getElementById('disc-50');
      // a.onclick = function () {
      //   Clipboard_CopyTo("T9TTVSQB");
      //   var div = document.getElementById('code-success');
      //   div.style.display = 'block';
      //   setTimeout(function () {
      //     document.getElementById('code-success').style.display = 'none';
      //   }, 900);
      };

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